                    <div class="card shadow-sm rounded-3 p-4 mb-6 bg-light">
                        <h4 class="fw-bold mb-1">Kinerja Agen</h4>
                        <p class="text-muted mb-4">Performa individual agen helpdesk</p>

                        @php
                            $agents = [
                                ['name' => 'Ahmad Fauzi', 'tickets' => 45, 'response' => 2.5, 'rating' => 4.8],
                                ['name' => 'Dewi Sartika', 'tickets' => 38, 'response' => 3.2, 'rating' => 4.6],
                                ['name' => 'Rina Susanti', 'tickets' => 42, 'response' => 2.8, 'rating' => 4.7],
                                ['name' => 'Bambang Sutrisno', 'tickets' => 35, 'response' => 3.5, 'rating' => 4.4],
                                ['name' => 'Sari Indah', 'tickets' => 28, 'response' => 4.1, 'rating' => 4.2],
                            ];
                        @endphp

                        <div class="space-y-3">
                            @foreach ($agents as $agent)
                                @php
                                    $initials = collect(explode(' ', $agent['name']))->map(fn($n) => strtoupper($n[0]))->join('');
                                @endphp

                                <div class="d-flex align-items-center justify-content-between border rounded-3 p-3 hover:bg-gray-50 transition">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-weight: 600;">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $agent['name'] }}</div>
                                            <div class="text-muted small">{{ $agent['tickets'] }} tiket ditangani</div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-semibold">{{ $agent['response'] }} hari</div>
                                        <div class="text-muted small">Rata-rata Respon</div>
                                    </div>
                                    <div class="text-end ms-4">
                                        <div class="fw-semibold">{{ $agent['rating'] }}/5.0</div>
                                        <div class="text-muted small">Rating</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>