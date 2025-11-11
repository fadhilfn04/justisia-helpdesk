<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Models\CategoryAgent;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ApitiketController extends BaseController
{
    public function getKategori()
    {
        $kategori = TicketCategory::all();

        return response()->json($kategori);
    }

    public function getDetailTiket($id)
    {
        $ticket = Ticket::with('file')->find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Tiket tidak ditemukan'], 404);
        }

        $files = $ticket->file->pluck('file_ticket')->toArray();

        return response()->json([
            'id' => $ticket->id,
            'user_id' => $ticket->user_id,
            'category_id' => $ticket->category_id,
            'category_name' => optional($ticket->category)->name ?? '-',
            'wilayah_id' => $ticket->wilayah_id,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'file_ticket' => $files,
            'status' => $ticket->status,
            'priority' => $ticket->priority,
            'created_at' => $ticket->created_at,
        ]);
    }

    public function getTiket(Request $request)
    {
        $query = Ticket::latest();
        $userId = Auth::id();

        if(auth()->user()->role->id == '3')
        {
            $query = Ticket::where('user_id', $userId)->latest();
        }

        if(auth()->user()->role->id == '2')
        {
            $isAgentTeknis = CategoryAgent::where('user_id', $userId)->get();
            $categories = $isAgentTeknis->pluck('category');

            $categoryTiketAgent = TicketCategory::whereIn('name', $categories)->get();
            $categoryIds = $categoryTiketAgent->pluck('id');

            $query = Ticket::where('assigned_to', $userId)
                ->whereIn('status', ['assignee', 'in_progress', 'closed', 'resolved'])
                ->whereIn('category_id', $categoryIds)
                ->latest();
        }

        if(auth()->user()->role->id == '1')
        {
            $query = Ticket::whereNotIn('status', ['draft', 'need_revision'])->latest();
        }

        // filter status
        if ($request->filled('status')) {
            $statusMap = [
                'terbuka' => 'open',
                'proses' => 'in_progress',
                'diverifikasi' => 'assignee',
                'ditutup' => 'closed',
                'draft' => 'draft',
                'ditolak' => 'agent_rejected',
                'selesai' => 'resolved',
                'revisi' => 'need_revision'
            ];

            $statusValue = $statusMap[$request->status] ?? null;

            if ($statusValue) {
                $query->where('status', $statusValue);
            }
        }

        if ($request->filled('prioritas')) {
            $prioritasMap = [
                'rendah' => 'low',
                'sedang' => 'medium',
                'tinggi' => 'high'
            ];

            $prioritasValue = $prioritasMap[$request->prioritas] ?? null;

            if ($prioritasValue) {
                $query->where('priority', $prioritasValue);
            }
        }

        return DataTables::of($query)
            ->filter(function ($query) use ($request) {
                if ($search = $request->get('search')['value']) {

                    $searchLower = strtolower($search);
                    $priorityMap = [
                        'rendah' => 'low',
                        'sedang' => 'medium',
                        'tinggi' => 'high',
                    ];
                    $statusMap = [
                        'draft' => 'draft',
                        'proses' => 'in_progress',
                        'diverifikasi' => 'assignee',
                        'terbuka' => 'open',
                        'ditutup' => 'closed',
                        'selesai' => 'resolved',
                        'ditolak agent' => 'agent_rejected',
                        'perlu revisi' => 'need_revision'
                    ];

                    $mappedPriority = $priorityMap[$searchLower] ?? null;
                    $mappedStatus = $statusMap[$searchLower] ?? null;

                    $idSearch = null;
                    if (preg_match('/TKT-\d{4}-(\d+)/i', $search, $matches)) {
                        $idSearch = (int)$matches[1];
                    } elseif (is_numeric($search)) {
                        $idSearch = (int)$search;
                    }

                    $query->where(function ($q) use ($search, $mappedPriority, $mappedStatus, $idSearch) {
                        $q->where('title', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhere('priority', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");

                        // search priority
                        if ($mappedPriority) {
                            $q->orWhere('priority', $mappedPriority);
                        }

                        // search status
                        if ($mappedStatus) {
                            $q->orWhere('status', $mappedStatus);
                        }

                        // search id
                        if ($idSearch) {
                            $q->orWhere('id', 'like', "%{$idSearch}%");
                        }
                        if (stripos($search, 'tkt') !== false) {
                            $q->orWhereRaw("CONCAT('TKT-', YEAR(created_at), '-', LPAD(id, 3, '0')) LIKE ?", ["%{$search}%"]);
                        }

                    });
                }
            })
            ->addColumn('id', function ($row) {
                $tahun = $row->created_at ? $row->created_at->format('Y') : date('Y');
                return sprintf('TKT-%s-%03d', $tahun, $row->id);
            })
            ->addColumn('judul', function ($row) {
                return '
                    <div class="d-flex flex-column">
                        <span class="fw-semibold text-dark">' . e($row->title) . '</span>
                        <span class="text-truncate-ellipsis">' . e($row->description ?? '') . '</span>
                    </div>
                ';
            })
            ->addColumn('status', function ($row) {
                $status = strtolower($row->status ?? '-');
                $color = 'badge-bg-primary';
                $icon = 'triangle-alert';
                $textColor = 'text-primary';

                switch ($status) {
                    case 'draft':
                        $color = 'badge-bg-secondary'; $icon = 'file'; $textColor = 'text-info'; break;
                    case 'in_progress':
                        $status = 'proses';
                        $color = 'badge-bg-warning'; $icon = 'clock'; $textColor = 'text-warning'; break;
                    case 'assignee':
                        $status = 'diverifikasi';
                        $color = 'badge-bg-success'; $icon = 'circle-check-big'; $textColor = 'text-success'; break;
                    case 'open':
                        $status = 'terbuka';
                        $color = 'badge-bg-dark-blue'; $icon = 'clock'; $textColor = 'text-dark-blue'; break;
                    case 'closed':
                        $status = 'ditutup';
                        $color = 'badge-bg-dark'; $icon = 'circle-check-big'; $textColor = 'text-dark'; break;
                    case 'resolved':
                        $status = 'selesai';
                        $color = 'badge-bg-primary'; $icon = 'circle-check-big'; $textColor = 'text-primary'; break;
                    case 'need_revision':
                        $status = 'Perlu Revisi';
                        $color = 'badge-bg-danger'; $icon = 'triangle-alert'; $textColor = 'text-danger'; break;
                    case 'agent_rejected':
                        $status = 'Ditolak Agent';
                        $color = 'badge-bg-danger'; $icon = 'triangle-alert'; $textColor = 'text-danger'; break;
                }

                return '
                    <span class="badge d-inline-flex align-items-center gap-2 py-0 px-3 '.$color.'">
                        <i data-lucide="'.$icon.'" class="'.$textColor.'" style="width:0.95rem;"></i>
                        <span class="'.$textColor.'">'.ucfirst($status).'</span>
                    </span>
                ';
            })
            ->addColumn('prioritas', function ($row) {
                $priority = $row->priority;

                switch($priority) {
                    case 'low':
                        $priority = 'Rendah'; break;
                    case 'medium':
                        $priority = 'Sedang'; break;
                    case 'high':
                        $priority = 'Tinggi'; break;
                }

                return '
                    <span class="badge d-inline-flex align-items-center justify-content-center px-3 py-1 border border-gray-300 text-dark bg-transparent">
                        '.e($priority ?? '-').'
                    </span>
                ';
            })
            ->addColumn('pelapor', function ($row) {
                $user = $row->user;
                $nama = e($user->name ?? 'User');
                return '
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-dark" style="width:1.4rem;"></i>
                        <span>'.$nama.'</span>
                    </span>
                ';
            })
            ->addColumn('pj', function($row) {
                $pj = $row->agent->name ?? '-';

                 $initials = '-';

                if ($row->agent && $row->agent->name) {
                    $words = explode(' ', trim($row->agent->name));
                    $words = array_slice($words, 0, 2);

                    $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), $words)));
                }

                return '
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">'.$initials.'</span>
                        <span>'.$pj.'</span>
                    </span>
                ';
            })
            ->addColumn('wilayah', function ($row) {
                return '
                    <span class="d-inline-flex align-items-center gap-2">
                        <i data-lucide="map-pin" class="text-dark" style="width:1.4rem;"></i>
                        <span>'.e($row->wilayah_id ?? '-').'</span>
                    </span>
                ';
            })
            ->addColumn('sla', fn() => '-')
            ->addColumn('respon', function ($row) use ($userId) {
                $countResponMessage = $row->messages->count();
                $roleIdUser = User::where('id', $userId)->first();
                $agentId = $row->agent->id ?? null;
                if(auth()->user()->role->id != '1')
                {
                    $countResponMessage = $row->messages->where('sender_id', '!=', $userId)->count();
                }

                return '<a href="javascript:void(0)"
                            class="btn-respon text-dark"
                            data-id="' . $row->id . '"
                            data-status="' . $row->status . '"
                            data-user-role-id="' . $roleIdUser->role_id . '"
                            data-pj="' . ($agentId ?? '') . '">
                            <i data-lucide="message-square" class="text-dark" style="width:1.1rem;cursor:pointer;"></i>
                            '. $countResponMessage .'
                        </a>';
            })
            ->addColumn('aksi', function ($row) {
                $roleUserLogin = auth()->user()->role->id;

                $dropdown = '
                    <div class="dropdown position-relative">
                        <button class="btn btn-icon btn-sm btn-hover-primary" data-bs-toggle="dropdown">
                            <i data-lucide="ellipsis" class="icon-action"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-fixed">
                            <a href="javascript:void(0)" class="dropdown-item btn-detail" data-id="'.$row->id.'" data-status="'.$row->status.'" data-role-user="'.$roleUserLogin.'" data-bs-toggle="modal" data-bs-target="#createTiketModal">
                            <i data-lucide="eye" class="me-2 text-warning" width="18" height="18"></i> Detail
                            </a>';

                if ($roleUserLogin == '3' && $row->status === 'resolved')
                {
                    $dropdown .= '
                        <a href="#" class="dropdown-item f" data-id="'.$row->id.'">
                            <i data-lucide="notebook" class="me-2 text-primary" width="18" height="18"></i> Detail Penyelesaian
                        </a>
                        <a class="dropdown-item btn-tutup" href="#" data-id="' . $row->id . '">
                            <i data-lucide="check-check" class="me-2 text-success" width="18" height="18"></i> Tutup Tiket
                        </a>';
                }

                if ($roleUserLogin == '3' && ($row->status === 'draft' || $row->status === 'need_revision')) {
                    $dropdown .= '
                        <a href="javascript:void(0)" class="dropdown-item btnAjukanTiket" data-id="'.$row->id.'" data-user-pelapor="'.$row->user_id.'">
                            <i data-lucide="send" class="me-2 text-info" width="18" height="18"></i> Ajukan Tiket
                        </a>
                        <a href="javascript:void(0)" class="dropdown-item btn-edit" data-id="'.$row->id.'" data-role-user="'.$roleUserLogin.'" data-bs-toggle="modal" data-bs-target="#createTiketModal">
                            <i data-lucide="pencil" class="me-2 text-primary" width="18" height="18"></i> Edit
                        </a>';
                }

                if ($roleUserLogin == '3' && ($row->status === 'draft' ||$row->status === 'open')) {
                    $dropdown .= '
                            <a href="#" class="dropdown-item btn-delete" data-id="'.$row->id.'">
                                <i data-lucide="trash" class="me-2 text-danger" width="18" height="18"></i> Hapus
                            </a>';
                }


                if ($roleUserLogin == '1' && ($row->status === 'open' || $row->status === 'need_revision' || $row->status == 'agent_rejected')) {
                    $dropdown .= '
                            <a class="dropdown-item btn-verifikasi" href="#" data-id="' . $row->id . '">
                                <i data-lucide="check-circle" class="me-2 text-success" width="18" height="18"></i> Verifikasi
                            </a>';
                }

                if ($roleUserLogin != '2' && $row->status === 'closed') {
                    $dropdown .= '
                            <a class="dropdown-item btn-tutup" href="#" data-id="' . $row->id . '">
                                <i data-lucide="x-circle" class="me-2 text-danger" width="18" height="18"></i> Tutup Tiket
                            </a>';
                }

                if($roleUserLogin == '2' && $row->status == 'in_progress')
                {
                    $dropdown .= '
                            <a class="dropdown-item btn-penyelesaian" href="#" data-id="' . $row->id . '">
                                <i data-lucide="bookmark-check" class="me-2 text-success" width="18" height="18"></i> Input Penyelesaian
                            </a>';
                }

                $dropdown .= '
                        </div>
                    </div>';

                return $dropdown;
            })
            ->rawColumns(['judul', 'status', 'prioritas', 'pelapor', 'pj', 'wilayah', 'respon', 'aksi'])
            ->make(true);
    }

    public function statusSummary(Request $request)
    {
        $userId = Auth::id();

        $statusMap = [
            'open' => 'Terbuka',
            'in_progress' => 'Proses',
            'draft' => 'Draft',
            'closed' => 'Selesai',
            'need_revision' => 'Revisi',
        ];

        $colors = [
            'open' => 'text-dark-blue',
            'in_progress' => 'text-warning',
            'draft' => 'text-primary',
            'closed' => 'text-success',
            'need_revision' => 'text-danger',
        ];

        $statusCounts = Ticket::where('user_id', $userId)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $response = [];

        $totalAll = array_sum($statusCounts);
        $response[] = [
            'label' => 'Semua Tiket',
            'count' => $totalAll,
            'color' => 'text-dark',
            'key' => 'semua tiket'
        ];

        foreach ($statusMap as $key => $label) {
            $response[] = [
                'label' => $label,
                'count' => $statusCounts[$key] ?? 0,
                'color' => $colors[$key],
                'key' => strtolower($label)
            ];
        }

        return response()->json($response);
    }

    public function checkDuplicateTiket($userId, $title)
    {
        $normalizedTitle = strtolower(trim(preg_replace('/\s+/', ' ', $title)));

        $exists = Ticket::where('user_id', $userId)
            ->get()
            ->contains(function ($ticket) use ($normalizedTitle) {
                $dbTitle = strtolower(trim(preg_replace('/\s+/', ' ', $ticket->title)));
                return $dbTitle === $normalizedTitle;
            });

        return response()->json(['exists' => $exists]);
    }

}
