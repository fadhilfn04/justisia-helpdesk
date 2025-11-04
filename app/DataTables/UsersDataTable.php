<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['pengguna', 'kontak', 'status', 'last_login_at', 'aksi'])
            ->editColumn('pengguna', function (User $user) {
                return view('pages/apps.user-management.users.columns._user', compact('user'));
            })
            ->editColumn('role', function (User $user) {
                return ucwords($user->role?->name ?? '-');
            })
            ->addColumn('kontak', function (User $user) {
                return $user->phone
                    ? "<div class='text-gray-700'>{$user->phone}</div><div class='text-muted fs-7'>{$user->email}</div>"
                    : "<div class='text-muted'>{$user->email}</div>";
            })
            ->addColumn('departemen', function () {
                $departemen = ['TI', 'Hukum', 'Pelayanan', 'Kepegawaian', 'Umum'];
                return $departemen[array_rand($departemen)];
            })
            ->addColumn('wilayah', function () {
                $wilayah = ['Jakarta Selatan', 'Bandung', 'Makassar', 'Surabaya', 'Medan'];
                return $wilayah[array_rand($wilayah)];
            })
            ->addColumn('status', function (User $user) {
                $status = $user->status ?? 'aktif';
                $badgeClass = match ($status) {
                    'aktif' => 'badge-light-success',
                    'tidak_aktif' => 'badge-light-warning',
                    'ditangguhkan' => 'badge-light-danger',
                    default => 'badge-light-secondary',
                };
                return "<div class='badge {$badgeClass} fw-bold text-capitalize'>{$status}</div>";
            })
            ->addColumn('tiket_ditangani', function () {
                return rand(0, 20);
            })
            ->editColumn('last_login_at', function (User $user) {
                return sprintf('<div class="badge badge-light fw-bold">%s</div>', $user->last_login_at ? $user->last_login_at->diffForHumans() : $user->updated_at->diffForHumans());
            })
            ->addColumn('aksi', function (User $user) {
                return view('pages/apps.user-management.users.columns._actions', compact('user'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>")
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/user-management/users/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('pengguna')->addClass('d-flex align-items-center')->name('name')->title('Pengguna'),
            Column::make('role')->searchable(false),
            Column::make('kontak')->title('Kontak')->orderable(false),
            Column::make('departemen')->orderable(false),
            Column::make('wilayah')->orderable(false),
            Column::make('status')->orderable(false)->searchable(false),
            Column::make('tiket_ditangani')->title('Tiket Ditangani')->searchable(false),
            Column::make('last_login_at')->title('Terakhir Login')->searchable(false),
            Column::computed('aksi')
                ->title('Aksi')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}