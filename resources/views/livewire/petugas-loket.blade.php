<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                    Dashboard Petugas Loket
                </h1>
                <p class="text-gray-600">Kelola antrian pasien dengan mudah dan efisien</p>
            </div>
            
            <!-- Auto Refresh Controls -->
            <div class="flex items-center space-x-4">
                <!-- Manual Refresh Button -->
                <button wire:click="refreshData" 
                        class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
                
                <!-- Auto Refresh Toggle -->
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Auto Refresh</span>
                    <button wire:click="toggleAutoRefresh" 
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 ease-in-out 
                                   @if($autoRefresh) bg-blue-600 @else bg-gray-300 @endif">
                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 ease-in-out 
                                    @if($autoRefresh) translate-x-6 @else translate-x-1 @endif"></span>
                    </button>
                    @if($autoRefresh)
                        <div class="flex items-center text-green-600">
                            <svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-xs">Aktif</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- Error Message -->
    @if ($errorMessage)
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            {{ $errorMessage }}
        </div>
    @endif

    <!-- Profile and Loket Selection Section -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-white/50 p-6 backdrop-blur-sm">
                <div class="text-center">
                    <!-- Profile Photo -->
                    <div class="relative inline-block">
                        <img src="{{ Auth::user()->avatar }}" 
                             alt="Profile Photo" 
                             class="w-20 h-20 rounded-full border-4 border-white shadow-lg mx-auto mb-4">
                        <div class="absolute bottom-4 right-0 w-5 h-5 bg-green-500 rounded-full border-2 border-white"></div>
                    </div>
                    
                    <!-- User Info -->
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ Auth::user()->name }}</h2>
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 mb-4">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ Auth::user()->role === 'petugas' ? 'Petugas Loket' : ucfirst(Auth::user()->role) }}
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">
                                {{ \App\Models\Antrian::whereDate('created_at', today())->count() }}
                            </div>
                            <div class="text-xs text-blue-600 font-medium">Antrian Hari Ini</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">
                                {{ \App\Models\Antrian::where('status', 'selesai')->whereDate('updated_at', today())->count() }}
                            </div>
                            <div class="text-xs text-green-600 font-medium">Terselesaikan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loket Selection Card -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-lg border border-white/50 p-6 backdrop-blur-sm h-full">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Pilih Loket
                        </h2>
                        <p class="text-sm text-gray-600">Pilih loket yang Anda tangani</p>
                    </div>
                    <!-- Current Time -->
                    <div class="text-right">
                        <div class="text-2xl font-bold text-gray-800" id="currentTime">
                            {{ now()->format('H:i') }}
                        </div>
                        <div class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</div>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
                    <div class="relative w-full md:w-80">
                        <select wire:model.live="loket_id" 
                                class="border border-gray-300 rounded-xl px-4 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white shadow-sm appearance-none pr-10">
                            <option value="">-- Pilih Loket --</option>
                            @foreach ($lokets as $loket)
                                <option value="{{ $loket->id }}">{{ $loket->nama_loket }}</option>
                            @endforeach
                        </select>
                        <!-- Custom Dropdown Arrow -->
                        <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    @if ($loket_id)
                        @php $selectedLoket = $lokets->firstWhere('id', $loket_id); @endphp
                        <div class="flex items-center space-x-2 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                            <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-blue-800">
                                Loket aktif: <strong>{{ $selectedLoket->nama_loket }}</strong>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Performance Metrics -->
                @if ($loket_id)
                    <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ count($menunggu) }}</div>
                            <div class="text-sm text-gray-600">Menunggu</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">{{ count($dipanggil) }}</div>
                            <div class="text-sm text-gray-600">Dipanggil</div>
                        </div>
                        <div class="text-center">
                            @php
                                $selesaiCount = \App\Models\Antrian::where('loket_id', $loket_id)
                                    ->where('status', 'selesai')
                                    ->whereDate('updated_at', today())
                                    ->count();
                            @endphp
                            <div class="text-2xl font-bold text-green-600">{{ $selesaiCount }}</div>
                            <div class="text-sm text-gray-600">Selesai Hari Ini</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Antrian Sections -->
    @if ($loket_id)
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <!-- Antrian Menunggu -->
            <div class="bg-white rounded-2xl shadow-lg border border-white/50 p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                        Antrian Menunggu
                    </h2>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                        {{ count($menunggu) }}
                    </span>
                </div>
                
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse ($menunggu as $item)
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4 transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow">
                                        <span class="text-white font-bold text-sm">{{ $item->nomor_antrian }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Dibuat</p>
                                        <p class="text-sm font-medium text-gray-700">{{ $item->created_at->format('H:i') }}</p>
                                    </div>
                                </div>
                                <button wire:click="panggil({{ $item->id }})"
                                        @if(count($dipanggil) > 0) 
                                            disabled
                                            class="bg-gray-400 text-white px-4 py-2 rounded-lg font-medium cursor-not-allowed flex items-center opacity-50"
                                        @else
                                            class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow flex items-center"
                                        @endif>
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    @if(count($dipanggil) > 0)
                                        Menunggu
                                    @else
                                        Panggil
                                    @endif
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p>Tidak ada antrian menunggu</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Sedang Dipanggil -->
            <div class="bg-white rounded-2xl shadow-lg border border-white/50 p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        Sedang Dipanggil
                    </h2>
                    <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                        {{ count($dipanggil) }}
                    </span>
                </div>
                
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse ($dipanggil as $item)
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border border-yellow-200 rounded-xl p-4 transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center shadow animate-pulse">
                                        <span class="text-white font-bold text-sm">{{ $item->nomor_antrian }}</span>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Dipanggil</p>
                                        <p class="text-sm font-medium text-gray-700">
                                            @if($item->waktu_panggil)
                                                {{ \Carbon\Carbon::parse($item->waktu_panggil)->format('H:i') }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <button wire:click="selesai({{ $item->id }})"
                                        class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow flex items-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Selesai
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Tidak ada antrian dipanggil</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Antrian Selesai -->
            <div class="bg-white rounded-2xl shadow-lg border border-white/50 p-6 backdrop-blur-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        Antrian Selesai
                    </h2>
                    @php
                        $selesai = \App\Models\Antrian::with('loket')
                            ->where('loket_id', $loket_id)
                            ->where('status', 'selesai')
                            ->orderBy('updated_at', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                        {{ count($selesai) }}
                    </span>
                </div>
                
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse ($selesai as $item)
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 transition-all duration-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center shadow">
                                    <span class="text-white font-bold text-sm">{{ $item->nomor_antrian }}</span>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Selesai</p>
                                    <p class="text-sm font-medium text-gray-700">{{ $item->updated_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Tidak ada antrian selesai</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-medium text-blue-800">Informasi Sistem</h3>
                    <p class="text-sm text-blue-600 mt-1">
                        Setiap loket hanya dapat memanggil satu antrian dalam satu waktu. 
                        Selesaikan antrian yang sedang dipanggil terlebih dahulu sebelum memanggil antrian berikutnya.
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl shadow-lg border border-white/50 p-12 text-center backdrop-blur-sm">
            <div class="w-24 h-24 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Pilih Loket Terlebih Dahulu</h3>
            <p class="text-gray-500 max-w-md mx-auto">
                Silakan pilih loket yang Anda tangani dari dropdown di atas untuk mulai mengelola antrian.
            </p>
        </div>
    @endif
</div>

<script>
    // Update current time every second
    function updateCurrentTime() {
        const now = new Date();
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            timeElement.textContent = now.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false 
            });
        }
    }

    // Auto refresh functionality
    let refreshInterval;

    function startAutoRefresh() {
        // Clear existing interval
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
        
        // Set new interval (5 detik)
        refreshInterval = setInterval(() => {
            Livewire.dispatch('refresh-antrian');
        }, 5000);
    }

    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
            refreshInterval = null;
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);
        
        // Start auto refresh by default
        startAutoRefresh();
    });

    // Listen to Livewire events
    document.addEventListener('livewire:initialized', function() {
        // Start auto refresh when component is ready
        startAutoRefresh();
        
        // Listen for manual refresh events
        Livewire.on('start-auto-refresh', () => {
            startAutoRefresh();
        });
        
        Livewire.on('stop-auto-refresh', () => {
            stopAutoRefresh();
        });
        
        Livewire.on('antrian-refreshed', () => {
            // Optional: Show brief refresh indicator
            const refreshBtn = document.querySelector('[wire\\:click="refreshData"]');
            if (refreshBtn) {
                refreshBtn.classList.add('animate-pulse');
                setTimeout(() => {
                    refreshBtn.classList.remove('animate-pulse');
                }, 1000);
            }
        });
    });

    // Cleanup on page unload
    document.addEventListener('livewire:navigating', function() {
        stopAutoRefresh();
    });
</script>