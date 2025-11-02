<div class="min-h-screen flex flex-col">
    <!-- Main Content -->
    <div class="flex-1 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-4">
                    AMBIL NOMOR ANTRIAN
                </h1>
                <p class="text-lg text-gray-600">Rumah Sakit Sehat Selalu</p>
                <div class="w-32 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto mt-4 rounded-full"></div>
            </div>

            <!-- Notifications -->
            @if ($message)
                <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8 transform transition-all duration-300 hover:scale-[1.02]">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-green-800 mb-1">Berhasil!</h3>
                            <p class="text-green-700">{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($error)
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-red-800 mb-1">Terjadi Kesalahan</h3>
                            <p class="text-red-700">{{ $error }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Form Ambil Antrian -->
                <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/50 p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2 flex items-center justify-center">
                            <svg class="w-6 h-6 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Pilih Loket
                        </h2>
                        <p class="text-gray-600">Pilih jenis layanan yang Anda butuhkan</p>
                    </div>

                    <form wire:submit="ambilAntrian">
                        <div class="space-y-6">
                            <!-- Pilihan Loket -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Jenis Layanan
                                </label>
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($lokets as $loket)
                                        <label class="relative flex cursor-pointer">
                                            <input 
                                                type="radio" 
                                                wire:model="selectedLoketId" 
                                                value="{{ $loket->id }}"
                                                class="peer sr-only"
                                            >
                                            <div class="w-full bg-white border-2 border-gray-200 rounded-2xl p-4 transition-all duration-200 hover:border-blue-300 hover:shadow-md peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-lg">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-4">
                                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                                            <span class="text-white font-bold text-sm">
                                                                {{ $this->generateHurufLoket($loket->id) }}
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-semibold text-gray-800">{{ $loket->nama_loket }}</h3>
                                                            @if($loket->deskripsi)
                                                                <p class="text-sm text-gray-600 mt-1">{{ $loket->deskripsi }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <button 
                                type="submit"
                                class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white py-4 px-6 rounded-2xl font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                wire:loading.attr="disabled"
                            >
                                <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove>Ambil Nomor Antrian</span>
                                <span wire:loading>Memproses...</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Informasi & Antrian Terakhir -->
                <div class="space-y-8">
                    <!-- Antrian Terakhir -->
                    @if($antrianTerakhir)
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-3xl shadow-2xl p-8 text-center transform transition-all duration-300 hover:scale-[1.02]">
                            <div class="mb-6">
                                <h2 class="text-2xl font-bold text-gray-800 mb-2">Nomor Antrian Anda</h2>
                                <div class="w-24 h-1 bg-gradient-to-r from-green-400 to-emerald-500 mx-auto rounded-full"></div>
                            </div>
                            
                            <div class="mb-6">
                                <div class="w-32 h-32 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto shadow-lg mb-4">
                                    <span class="text-white font-bold text-4xl">{{ $antrianTerakhir->nomor_antrian }}</span>
                                </div>
                                <p class="text-lg font-semibold text-gray-700">{{ $antrianTerakhir->loket->nama_loket }}</p>
                                <p class="text-sm text-gray-500 mt-2">Dibuat: {{ $antrianTerakhir->created_at->format('H:i') }}</p>
                            </div>

                            <div class="bg-green-100 border border-green-200 rounded-2xl p-4">
                                <div class="flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-green-700 font-medium">Silakan tunggu panggilan di layar display</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Placeholder untuk antrian terakhir -->
                        <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/50 p-8 text-center">
                            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Antrian</h3>
                            <p class="text-gray-500">Ambil nomor antrian untuk melihat informasi di sini</p>
                        </div>
                    @endif

                    <!-- Statistik Cepat -->
                    <div class="bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/50 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Statistik Hari Ini
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-3 bg-blue-50 rounded-xl">
                                <div class="text-2xl font-bold text-blue-600">
                                    {{ \App\Models\Antrian::whereDate('created_at', today())->count() }}
                                </div>
                                <div class="text-xs text-blue-600 font-medium">Total Antrian</div>
                            </div>
                            <div class="text-center p-3 bg-green-50 rounded-xl">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ \App\Models\Antrian::where('status', 'selesai')->whereDate('updated_at', today())->count() }}
                                </div>
                                <div class="text-xs text-green-600 font-medium">Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl border border-white/50 p-8">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Informasi Layanan</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 mx-auto rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Proses Cepat</h3>
                        <p class="text-sm text-gray-600">Sistem antrian digital untuk pelayanan yang lebih efisien</p>
                    </div>

                    <div class="text-center p-4">
                        <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Terjamin</h3>
                        <p class="text-sm text-gray-600">Nomor antrian Anda aman dan terjamin keabsahannya</p>
                    </div>

                    <div class="text-center p-4">
                        <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-2">Real-time</h3>
                        <p class="text-sm text-gray-600">Pantau antrian secara real-time melalui layar display</p>
                    </div>
                </div>
            </div>

            <!-- Link ke Display -->
            <div class="text-center mt-8">
                <a href="{{ route('display.antrian') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-2xl text-blue-700 bg-blue-100 hover:bg-blue-200 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Display Antrian
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Auto Reset Message Script -->
<script>
    // Auto reset pesan setelah 5 detik
    @if($message)
        setTimeout(() => {
            Livewire.dispatch('resetMessage');
        }, 5000);
    @endif

    @if($error)
        setTimeout(() => {
            Livewire.dispatch('resetError');
        }, 5000);
    @endif
</script>