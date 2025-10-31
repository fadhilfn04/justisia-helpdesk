<div class="card shadow-sm border-0">
    <div class="card-header">
        <div class="card-title">
            <h2>Distribusi Regional</h2>
        </div>
    </div>

    @php
        // Dummy data progress per wilayah
        $regions = [
            ['name' => 'DKI Jakarta', 'value' => 90, 'color' => 'success'],
            ['name' => 'Jawa Barat', 'value' => 75, 'color' => 'info'],
            ['name' => 'Jawa Tengah', 'value' => 60, 'color' => 'warning'],
            ['name' => 'Jawa Timur', 'value' => 45, 'color' => 'danger'],
            ['name' => 'Sumatera Utara', 'value' => 55, 'color' => 'primary'],
        ];
    @endphp

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle table-row-dashed fs-6 gy-5">
                <tbody>
                    @foreach ($regions as $region)
                        <tr>
                            <td class="fw-semibold text-gray-700 w-30">
                                {{ $region['name'] }}
                            </td>
                            <td class="w-100">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-100 me-3" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $region['color'] }}" role="progressbar"
                                            style="width: {{ $region['value'] }}%;" 
                                            aria-valuenow="{{ $region['value'] }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span class="fw-bold text-gray-700">{{ $region['value'] }}%</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>