<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Display Antrian - RS Sehat Selalu' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            overflow-x: hidden;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-32 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-40 -left-32 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    </div>

    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-lg border-b border-white/50 shadow-sm relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            RS Sehat Selalu
                        </h1>
                        <span class="text-xs text-gray-500">Display Antrian Digital</span>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-800" id="currentTime">
                        {{ now()->format('H:i') }}
                    </div>
                    <div class="text-sm text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</div>
                </div>
            </div>
        </div>
    </header>

    <main class="relative z-10">
        {{ $slot }}
    </main>

    <footer class="bg-white/80 backdrop-blur-lg border-t border-white/50 py-4 text-center text-gray-500 text-sm relative z-10 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            &copy; {{ date('Y') }} RS Sehat Selalu. All rights reserved.
        </div>
    </footer>

    @livewireScripts
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

        // Update time immediately and then every second
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);
    </script>
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        /* Animasi untuk antrian dipanggil */
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { box-shadow: 0 0 0 20px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }
        .animate-pulse-glow {
            animation: pulse-glow 2s infinite;
        }
        
        /* Animasi scroll */
        @keyframes scroll-up {
            0% { transform: translateY(100%); opacity: 0; }
            10% { transform: translateY(0); opacity: 1; }
            90% { transform: translateY(0); opacity: 1; }
            100% { transform: translateY(-100%); opacity: 0; }
        }
        .animate-scroll-up {
            animation: scroll-up 15s linear infinite;
        }
    </style>
</body>
</html>