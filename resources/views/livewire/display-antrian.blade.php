<div class="min-h-screen flex flex-col">
    <!-- Main Content -->
    <div class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                    ANTRIAN SEDANG DIPANGGIL
                </h1>
                <p class="text-lg text-gray-600">Rumah Sakit Sehat Selalu</p>
            </div>

            <!-- Current Antrian Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Sedang Dipanggil -->
                <div class="lg:col-span-2">
                    <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/50 p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                                <div class="w-4 h-4 bg-yellow-500 rounded-full mr-3 animate-pulse"></div>
                                SEDANG DIPANGGIL
                            </h2>
                            <div class="w-24 h-1 bg-gradient-to-r from-yellow-400 to-orange-500 mx-auto rounded-full"></div>
                        </div>

                        <div class="space-y-6">
                            @forelse ($antrianDipanggil as $antrian)
                                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl p-6 transform transition-all duration-300 hover:scale-[1.02] hover:shadow-lg animate-pulse-glow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-6">
                                            <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                                                <span class="text-white font-bold text-2xl">{{ $antrian->nomor_antrian }}</span>
                                            </div>
                                            <div class="text-left">
                                                <p class="text-sm text-gray-500 mb-1">Nomor Antrian</p>
                                                <p class="text-3xl font-bold text-gray-800">{{ $antrian->nomor_antrian }}</p>
                                                <p class="text-lg text-gray-600 mt-2">
                                                    <span class="font-medium">Loket:</span> {{ $antrian->loket->nama_loket }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm text-gray-500 mb-1">Dipanggil</p>
                                            <p class="text-lg font-semibold text-gray-700">
                                                @if($antrian->waktu_panggil)
                                                    {{ \Carbon\Carbon::parse($antrian->waktu_panggil)->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Antrian</h3>
                                    <p class="text-gray-500">Tidak ada antrian yang sedang dipanggil saat ini</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Informasi -->
                <div class="space-y-8">
                    <!-- Total Antrian Hari Ini -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/50 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Statistik Hari Ini
                        </h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Antrian</span>
                                <span class="font-bold text-blue-600">
                                    {{ \App\Models\Antrian::whereDate('created_at', today())->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Selesai</span>
                                <span class="font-bold text-green-600">
                                    {{ \App\Models\Antrian::where('status', 'selesai')->whereDate('updated_at', today())->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Sedang Dipanggil</span>
                                <span class="font-bold text-yellow-600">
                                    {{ \App\Models\Antrian::where('status', 'dipanggil')->count() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Loket -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/50 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Daftar Loket
                        </h3>
                        <div class="space-y-3">
                            @foreach(\App\Models\Loket::all() as $loket)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-700 font-medium">{{ $loket->nama_loket }}</span>
                                    <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded-full">
                                        {{ $loket->antrians()->where('status', 'dipanggil')->count() }} dipanggil
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Informasi Sistem -->
                    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-medium text-blue-800">Informasi</h3>
                                <p class="text-sm text-blue-600 mt-1">
                                    Display ini akan otomatis diperbarui setiap 3 detik. Pastikan nomor antrian Anda sesuai dengan yang ditampilkan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Button Ambil Antrian (Alternatif di sidebar) -->
                    <div class="text-center">
                        <a href="http://localhost:8000/antrian" 
                           class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ambil Antrian
                        </a>
                    </div>
                </div>
            </div>

            <!-- Antrian Berikutnya Section -->
            <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/50 p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">ANTRIAN BERIKUTNYA</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $antrianMenunggu = \App\Models\Antrian::with('loket')
                            ->where('status', 'menunggu')
                            ->orderBy('created_at', 'asc')
                            ->limit(8)
                            ->get()
                            ->groupBy('loket_id');
                    @endphp

                    @foreach(\App\Models\Loket::all() as $loket)
                        @if(isset($antrianMenunggu[$loket->id]) && $antrianMenunggu[$loket->id]->count() > 0)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-6">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4 text-center">{{ $loket->nama_loket }}</h3>
                                <div class="space-y-3">
                                    @foreach($antrianMenunggu[$loket->id]->take(2) as $antrian)
                                        <div class="bg-white rounded-xl p-4 shadow-sm border border-blue-100">
                                            <div class="flex items-center justify-between">
                                                <span class="text-lg font-bold text-gray-800">{{ $antrian->nomor_antrian }}</span>
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                                    Menunggu
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">
                                                dibuat {{ $antrian->created_at->format('H:i') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if($antrianMenunggu->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500">Tidak ada antrian menunggu</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Auto Refresh Script -->
<script>
    // Auto refresh komponen Livewire setiap 3 detik
    setInterval(() => {
        Livewire.dispatch('refresh');
    }, 3000);
</script>