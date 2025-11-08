<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
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

        // filter status
        if ($request->filled('status')) {
            $statusMap = [
                'terbuka' => 'open',
                'proses' => 'in_progress',
                'selesai' => 'closed',
                'draft' => 'draft',
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
                        $color = 'badge-bg-primary'; $icon = 'clock'; $textColor = 'text-primary'; break;
                    case 'in_progress':
                        $status = 'proses';
                        $color = 'badge-bg-warning'; $icon = 'clock'; $textColor = 'text-warning'; break;
                    case 'open':
                        $status = 'terbuka';
                        $color = 'badge-bg-dark-blue'; $icon = 'clock'; $textColor = 'text-dark-blue'; break;
                    case 'closed':
                        $status = 'selesai';
                        $color = 'badge-bg-success'; $icon = 'circle-check-big'; $textColor = 'text-success'; break;
                    case 'need_revision':
                        $status = 'Perlu Revisi';
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
                return '
                    <span class="d-inline-flex align-items-center gap-2">
                        <span class="profile-circle bg-brown text-white fw-semibold">AF</span>
                        <span>-</span>
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
                $admin = User::where('id', $userId)->first();

                if(auth()->user()->role->id != '1')
                {
                    $countResponMessage = $row->messages->where('sender_id', '!=', $userId)->count();
                }

                return '<a href="javascript:void(0)"
                            class="btn-respon text-dark"
                            data-id="' . $row->id . '"
                            data-status="' . $row->status . '"
                            data-admin-role-id="' . $admin->role_id . '">
                            <i data-lucide="message-square" class="text-dark" style="width:1.1rem;cursor:pointer;"></i>
                            '. $countResponMessage .'
                        </a>';
            })
            ->addColumn('aksi', function ($row) {
                $dropdown = '
                    <div class="dropdown position-relative">
                        <button class="btn btn-icon btn-sm btn-hover-primary" data-bs-toggle="dropdown">
                            <i data-lucide="ellipsis" class="icon-action"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-fixed">
                            <a href="javascript:void(0)" class="dropdown-item btn-detail" data-id="'.$row->id.'" data-status="'.$row->status.'" data-bs-toggle="modal" data-bs-target="#createTiketModal">Detail</a>';

                if ($row->status === 'draft') {
                    $dropdown .= '
                        <a href="javascript:void(0)" class="dropdown-item btn-edit" data-id="'.$row->id.'" data-bs-toggle="modal" data-bs-target="#createTiketModal">Edit</a>';
                }

                if ($row->status === 'draft' ||$row->status === 'open') {
                    $dropdown .= '
                            <a href="#" class="dropdown-item btn-delete" data-id="'.$row->id.'">Hapus</a>';
                }

                $isAdmin = auth()->user()->role->id;

                if ( $isAdmin == '1' && ($row->status === 'open' || $row->status === 'need_revision')) {
                    $dropdown .= '
                            <a class="dropdown-item btn-verifikasi" href="#" data-id="' . $row->id . '">
                                <i data-lucide="check-circle" class="me-2 text-success"></i> Verifikasi
                            </a>';
                }

                if ($row->status === 'in_progress') {
                    $dropdown .= '
                            <a class="dropdown-item btn-tutup" href="#" data-id="' . $row->id . '">
                                <i data-lucide="x-circle" class="me-2 text-danger"></i> Tutup Tiket
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
