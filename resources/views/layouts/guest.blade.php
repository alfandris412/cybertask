<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'CyberTask') }}</title>
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700;900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            h1, h2, .brand-font { font-family: 'Outfit', sans-serif; }

            /* 1. Animasi Partikel Melayang (Float) */
            @keyframes float-slow {
                0%, 100% { transform: translateY(0px) translateX(0px); }
                50% { transform: translateY(-30px) translateX(20px); }
            }
            @keyframes float-medium {
                0%, 100% { transform: translateY(0px) translateX(0px); }
                50% { transform: translateY(20px) translateX(-20px); }
            }
            @keyframes float-fast {
                0%, 100% { transform: translateY(0px) translateX(0px); }
                50% { transform: translateY(-15px) translateX(15px); }
            }

            .animate-float-slow { animation: float-slow 8s ease-in-out infinite; }
            .animate-float-medium { animation: float-medium 6s ease-in-out infinite; }
            .animate-float-fast { animation: float-fast 4s ease-in-out infinite; }

            /* 2. Hack Input Autofill Gelap */
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus, 
            input:-webkit-autofill:active {
                -webkit-box-shadow: 0 0 0 30px #0f172a inset !important;
                -webkit-text-fill-color: white !important;
                transition: background-color 5000s ease-in-out 0s;
            }
        </style>
    </head>
    <body class="font-sans text-slate-900 antialiased">
        
        <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 sm:pt-0 bg-slate-950 relative overflow-hidden">
            
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] animate-float-slow"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-600/20 rounded-full blur-[100px] animate-float-medium"></div>
                
                <div class="absolute top-1/4 left-1/4 w-3 h-3 bg-indigo-400 rounded-full blur-[2px] opacity-60 animate-float-fast"></div>
                <div class="absolute top-3/4 right-1/4 w-4 h-4 bg-purple-400 rounded-full blur-[3px] opacity-40 animate-float-slow" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-10 left-1/2 w-2 h-2 bg-cyan-400 rounded-full blur-[1px] opacity-70 animate-float-medium" style="animation-delay: 2s;"></div>
            </div>

            <div class="relative z-10 mb-6 text-center animate-float-medium">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-[0_0_40px_rgba(79,70,229,0.5)] transition-transform group-hover:rotate-6 group-hover:scale-110">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-3xl font-extrabold text-white tracking-tight brand-font drop-shadow-2xl">
                        Cyber<span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-cyan-400">Task</span>
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-slate-900/80 backdrop-blur-xl border border-slate-800 shadow-2xl overflow-hidden sm:rounded-3xl relative z-10">
                <div class="absolute top-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-50"></div>
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-slate-500 text-sm relative z-10">
                &copy; {{ date('Y') }} CyberTask System.
            </div>
        </div>
    </body>
</html>