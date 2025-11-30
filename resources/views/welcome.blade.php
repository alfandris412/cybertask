<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CyberTask - Enterprise Task Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .brand-font { font-family: 'Outfit', sans-serif; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* ANIMASI CSS CUSTOM */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }
        .animate-float { animation: float 6s ease-in-out infinite; }

        @keyframes pulse-glow {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.1); }
        }
        .animate-pulse-glow { animation: pulse-glow 4s ease-in-out infinite; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient {
            background-size: 200% auto;
            animation: gradientShift 3s linear infinite;
        }
    </style>
</head>
<body class="antialiased bg-slate-950 text-slate-300 overflow-x-hidden selection:bg-indigo-500 selection:text-white">

    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-600/20 rounded-full blur-[120px] animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[120px]"></div>
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
    </div>

    <nav class="fixed top-0 w-full z-50 transition-all duration-300 bg-slate-950/80 backdrop-blur-md border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:shadow-indigo-500/40 transition-all">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="font-bold text-xl text-white tracking-tight brand-font">Cyber<span class="text-indigo-400">Task</span></span>
            </a>

            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-400">
                <a href="#features" class="hover:text-white transition-colors">Fitur</a>
                <a href="#stats" class="hover:text-white transition-colors">Statistik</a>
                <a href="#faq" class="hover:text-white transition-colors">Bantuan</a>
            </div>

            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" 
                           class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-full transition-all shadow-lg shadow-indigo-600/30">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white font-medium hover:text-indigo-400 transition-colors hidden sm:block">Masuk</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-white text-slate-900 font-bold rounded-full hover:bg-indigo-50 transition-all transform hover:scale-105 shadow-lg">
                                Daftar Gratis
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="relative pt-40 pb-20 lg:pt-52 lg:pb-32 px-6 max-w-7xl mx-auto text-center z-10">
        
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-900 border border-slate-800 text-sm font-medium text-indigo-400 mb-8 animate-fade-in-up">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
            </span>
            Versi UKK 1.0 Ready
        </div>

        <h1 class="text-5xl lg:text-7xl font-extrabold text-white leading-tight mb-8 tracking-tight animate-fade-in-up" style="animation-delay: 0.1s;">
            Manajemen Proyek <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400 drop-shadow-[0_0_30px_rgba(129,140,248,0.3)]">
                Tanpa Batas.
            </span>
        </h1>

        <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-12 leading-relaxed animate-fade-in-up" style="animation-delay: 0.2s;">
            Platform internal untuk mengelola pembagian tugas tim di Cybermedia Teknologi. Efisien, Cepat, dan Terstruktur untuk produktivitas maksimal.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.3s;">
            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-500 hover:to-violet-500 text-white font-bold rounded-2xl shadow-[0_10px_40px_-10px_rgba(79,70,229,0.5)] transition-all transform hover:-translate-y-1">
                Mulai Sekarang &rarr;
            </a>
            <a href="#features" class="px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl border border-slate-800 hover:border-slate-600 transition-all">
                Pelajari Fitur
            </a>
        </div>

        <div class="mt-20 relative animate-fade-in-up" style="animation-delay: 0.5s;">
            <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl opacity-20 blur-2xl animate-pulse-glow"></div>
            
            <div class="relative rounded-2xl border border-slate-700 bg-slate-900 p-2 shadow-2xl overflow-hidden group cursor-default">
                <div class="h-8 bg-slate-800 border-b border-slate-700 flex items-center px-4 gap-2 rounded-t-lg">
                    <div class="w-3 h-3 rounded-full bg-red-500 transition-transform group-hover:scale-110"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-500 transition-transform group-hover:scale-110 delay-75"></div>
                    <div class="w-3 h-3 rounded-full bg-green-500 transition-transform group-hover:scale-110 delay-150"></div>
                </div>

                <div class="aspect-video w-full bg-slate-950 relative overflow-hidden flex items-center justify-center group-hover:bg-slate-900 transition-colors duration-700">
                    <div class="absolute inset-0 transition-transform duration-1000 group-hover:scale-110" 
                         style="background-image: radial-gradient(#3730a3 1px, transparent 1px); background-size: 30px 30px; opacity: 0.2;">
                    </div>
                    
                    <div class="relative z-10 text-center animate-float transition-all duration-500 group-hover:scale-105">
                        
                        <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-[0_0_50px_rgba(79,70,229,0.5)] transition-all duration-500 group-hover:rotate-12 group-hover:shadow-[0_0_80px_rgba(79,70,229,0.8)]">
                             <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        
                        <h2 class="text-6xl md:text-8xl font-black tracking-tighter brand-font text-white drop-shadow-2xl transition-all duration-700 group-hover:tracking-widest">
                            Cyber<span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400 bg-[length:200%_auto] animate-gradient group-hover:from-indigo-300 group-hover:to-cyan-300">Task</span>
                        </h2>
                        
                        <div class="mt-4 inline-block px-4 py-1 rounded-full bg-indigo-500/20 border border-indigo-500/50 text-indigo-300 text-sm font-mono transition-all duration-500 group-hover:bg-indigo-500/40 group-hover:text-white">
                            ● SYSTEM ONLINE
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="stats" class="py-10 border-y border-slate-800 bg-slate-900/50 relative z-10">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-extrabold text-white mb-1">UKK</div>
                <div class="text-sm text-indigo-400 font-medium">Project Level</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-white mb-1">2025</div>
                <div class="text-sm text-indigo-400 font-medium">Tahun Ajaran</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-white mb-1">100%</div>
                <div class="text-sm text-indigo-400 font-medium">Keamanan Data</div>
            </div>
            <div>
                <div class="text-4xl font-extrabold text-white mb-1">Laravel</div>
                <div class="text-sm text-indigo-400 font-medium">Framework 11</div>
            </div>
        </div>
    </section>

    <section id="features" class="py-24 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Fitur Unggulan</h2>
                <p class="text-slate-400">Didesain khusus untuk memenuhi standar kompetensi rekayasa perangkat lunak.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-[0_10px_40px_-10px_rgba(79,70,229,0.2)] relative overflow-hidden hover:-translate-y-2">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl group-hover:bg-indigo-500/30 transition-all"></div>
                    <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Manajemen Proyek</h3>
                    <p class="text-slate-400">Admin dapat membuat proyek baru, menentukan tenggat waktu, dan menetapkan manajer proyek.</p>
                </div>

                <div class="group p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-purple-500/50 transition-all duration-300 hover:shadow-[0_10px_40px_-10px_rgba(168,85,247,0.2)] relative overflow-hidden hover:-translate-y-2">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-500/20 rounded-full blur-2xl group-hover:bg-purple-500/30 transition-all"></div>
                    <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Multi-User Role</h3>
                    <p class="text-slate-400">Sistem keamanan berbasis role (Admin & Karyawan) dengan Middleware untuk membatasi akses.</p>
                </div>

                <div class="group p-8 rounded-3xl bg-slate-900 border border-slate-800 hover:border-cyan-500/50 transition-all duration-300 hover:shadow-[0_10px_40px_-10px_rgba(6,182,212,0.2)] relative overflow-hidden hover:-translate-y-2">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-cyan-500/20 rounded-full blur-2xl group-hover:bg-cyan-500/30 transition-all"></div>
                    <div class="w-14 h-14 rounded-2xl bg-slate-800 flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Tracking Progres</h3>
                    <p class="text-slate-400">Karyawan dapat memperbarui status tugas dan mengunggah bukti pekerjaan secara digital.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20 bg-slate-900/30 relative z-10">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Pertanyaan Umum (FAQ)</h2>
            </div>
            <div class="space-y-4">
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:border-indigo-500/30 transition-colors">
                    <h3 class="text-lg font-bold text-white mb-2">Apa tujuan aplikasi ini?</h3>
                    <p class="text-slate-400">Aplikasi ini dibuat sebagai proyek Uji Kompetensi Keahlian (UKK) untuk mendemonstrasikan kemampuan Fullstack Development.</p>
                </div>
                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 hover:border-indigo-500/30 transition-colors">
                    <h3 class="text-lg font-bold text-white mb-2">Teknologi apa yang digunakan?</h3>
                    <p class="text-slate-400">CyberTask dibangun menggunakan Laravel 11, Tailwind CSS, MySQL, dan Alpine.js.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-slate-950 border-t border-slate-900 pt-16 pb-10 relative z-10">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mb-16">
                <div class="col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 font-bold text-xl text-white mb-4">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        CyberTask
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Sistem Informasi Manajemen Tugas Karyawan. Dibuat untuk meningkatkan efisiensi operasional di Cybermedia Teknologi.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-4">Fitur Sistem</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-indigo-400 transition-colors">Dashboard Admin</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors">CRUD Project</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors">Update Status</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Informasi UKK</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="#" class="hover:text-indigo-400 transition-colors">Paket Soal 2</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors">Dokumentasi</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition-colors">Flowchart</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><span class="text-slate-500">Lokasi:</span> Cybermedia Teknologi</li>
                        <li><span class="text-slate-500">Email:</span> admin@cybertask.com</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-900 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-slate-600 text-sm">
                    &copy; {{ date('Y') }} CyberTask Project. Developed for UKK RPL.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>