<!DOCTYPE html>
<html lang="{{ session('locale', 'id') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>AJ NETWORK - @yield('title', __('messages.dashboard'))</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.03); }
        ::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.2); border-radius: 4px; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade { animation: fadeInUp 0.4s ease-out; }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            transition: background 0.3s ease, color 0.3s ease;
            min-height: 100vh;
        }
        
        /* ===== BRAND COLORS ===== */
        :root {
            --brand-orange: #F39C16;
            --brand-darkblue: #0B326D;
            --brand-green: #249770;
            --brand-softyellow: #F0D192;
            --brand-grayblue: #A4B8CD;
        }
        
        /* Dark Mode Background */
        body.dark-mode {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
        }
        
        /* Light Mode Background */
        body.light-mode {
            background: linear-gradient(135deg, #F5F6F5 0%, #E8ECF1 100%);
        }
        
        /* ===== SIDEBAR ===== */
        body.light-mode #sidebar {
            background: #FFFFFF !important;
            border-right-color: #E2E8F0 !important;
        }
        
        body.light-mode #sidebar .nav-link {
            color: #475569 !important;
        }
        
        body.light-mode #sidebar .nav-link:hover {
            background: #F1F5F9 !important;
            color: #0B326D !important;
        }
        
        body.light-mode #sidebar .nav-link.active {
            background: rgba(11, 50, 109, 0.1) !important;
            color: #0B326D !important;
            border-left-color: #0B326D !important;
        }
        
        body.light-mode #sidebar .brand h1 {
            background: linear-gradient(135deg, #0B326D, #1a4a8a) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            color: transparent !important;
        }
        
        body.dark-mode #sidebar {
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%) !important;
            border-right-color: rgba(255, 255, 255, 0.1) !important;
        }
        
        body.dark-mode #sidebar .nav-link {
            color: #94A3B8 !important;
        }
        
        body.dark-mode #sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            color: #F39C16 !important;
        }
        
        body.dark-mode #sidebar .nav-link.active {
            background: rgba(243, 156, 22, 0.15) !important;
            color: #F39C16 !important;
            border-left-color: #F39C16 !important;
        }
        
        /* ===== DROPDOWN SETTINGS ===== */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            border-radius: 12px;
            min-width: 150px;
            z-index: 100;
            display: none;
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.4);
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-menu .dropdown-header {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 8px 12px;
            margin-bottom: 4px;
            border-bottom: 1px solid;
        }
        
        .dropdown-menu a,
        .dropdown-menu button {
            display: block;
            width: 100%;
            text-align: left;
            padding: 8px 12px;
            font-size: 13px;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .dropdown-menu {
            min-width: 130px;
        }
        
        .dropdown-menu a.active,
        .dropdown-menu button.active {
            font-weight: bold;
        }
        
        body.light-mode .dropdown-menu {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        body.light-mode .dropdown-menu .dropdown-header {
            color: #64748B;
            border-bottom-color: rgba(0, 0, 0, 0.1);
        }
        
        body.light-mode .dropdown-menu a,
        body.light-mode .dropdown-menu button {
            color: #1E293B;
        }
        
        body.light-mode .dropdown-menu a.active,
        body.light-mode .dropdown-menu button.active {
            color: #0B326D;
        }
        
        body.light-mode .dropdown-menu a:hover,
        body.light-mode .dropdown-menu button:hover {
            background: rgba(0, 0, 0, 0.05);
        }
        
        body.dark-mode .dropdown-menu {
            background: rgba(30, 41, 59, 0.98);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.dark-mode .dropdown-menu .dropdown-header {
            color: #94A3B8;
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }
        
        body.dark-mode .dropdown-menu a,
        body.dark-mode .dropdown-menu button {
            color: #CBD5E1;
        }
        
        body.dark-mode .dropdown-menu a.active,
        body.dark-mode .dropdown-menu button.active {
            color: #F39C16;
        }
        
        body.dark-mode .dropdown-menu a:hover,
        body.dark-mode .dropdown-menu button:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .settings-trigger {
            cursor: pointer;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 13px;
            color: #CBD5E1;
        }
        
        .settings-trigger:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        body.light-mode .settings-trigger {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.1);
            color: #1E293B;
        }
        
        body.light-mode .bg-slate-900\/95 {
            background: rgba(255, 255, 255, 0.97) !important;
        }
        
        body.light-mode .text-slate-100,
        body.light-mode .text-slate-200,
        body.light-mode .text-slate-300,
        body.light-mode .stat-card .text-slate-100 {
            color: #1E293B !important;
        }
        
        body.light-mode .card-glass,
        body.light-mode .stat-card {
            background: rgba(255, 255, 255, 0.8) !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
        }
        
        body.light-mode .border-white\/10 {
            border-color: rgba(0, 0, 0, 0.08) !important;
        }
        
        body.light-mode .text-slate-400,
        body.light-mode .text-slate-500 {
            color: #64748B !important;
        }
        
        body.light-mode .bg-slate-800\/50 {
            background: rgba(255, 255, 255, 0.9) !important;
            border-color: rgba(0, 0, 0, 0.08) !important;
        }
        
        body.light-mode .input-modern {
            background: rgba(0, 0, 0, 0.05);
            border-color: rgba(0, 0, 0, 0.1);
            color: #1E293B;
        }
        
        body.light-mode select.input-modern option {
            background-color: #FFFFFF;
            color: #1E293B;
        }
        
        .card-glass {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .card-glass:hover {
            border-color: rgba(243, 156, 22, 0.3);
            background: rgba(255, 255, 255, 0.06);
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            border-color: rgba(243, 156, 22, 0.4);
            background: rgba(255, 255, 255, 0.07);
            transform: translateY(-2px);
        }
        
        .badge-active {
            background: var(--brand-green);
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-warning {
            background: var(--brand-softyellow);
            color: #1E293B;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-nonactive {
            background: rgba(239, 68, 68, 0.15);
            color: #F87171;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
        }

        .badge-wa {
            background: rgba(34, 197, 94, 0.15);
            color: #4ADE80;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-sms {
            background: rgba(139, 92, 246, 0.15);
            color: #A78BFA;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 500;
        }
        
        .btn-primary, .btn-secondary, .btn-outline, .btn-danger {
            transition: all 0.2s ease;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
        }
        
        .btn-primary {
            padding: 10px 20px;
            color: white;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-primary:hover {
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: transparent;
            border: 1.5px solid;
            padding: 9px 19px;
            font-weight: 500;
        }
        
        .btn-outline {
            background: transparent;
            border: 1.5px solid;
            padding: 9px 19px;
            font-weight: 500;
        }
        .btn-outline:hover {
            color: white;
        }
        
        .btn-danger {
            background: #EF4444;
            color: white;
            padding: 10px 20px;
            border: none;
        }
        .btn-danger:hover {
            background: #DC2626;
        }
        
        body.light-mode .btn-primary {
            background: #0B326D;
        }
        body.light-mode .btn-primary:hover {
            background: #1a4a8a;
            box-shadow: 0 8px 20px rgba(11, 50, 109, 0.3);
        }
        
        body.light-mode .btn-secondary {
            border-color: #0B326D;
            color: #0B326D;
        }
        body.light-mode .btn-secondary:hover {
            background: rgba(11, 50, 109, 0.05);
        }
        
        body.light-mode .btn-outline {
            border-color: #0B326D;
            color: #0B326D;
        }
        body.light-mode .btn-outline:hover {
            background: #0B326D;
            color: white;
        }
        
        body.dark-mode .btn-primary {
            background: #F39C16;
        }
        body.dark-mode .btn-primary:hover {
            background: #E67E22;
            box-shadow: 0 8px 20px rgba(243, 156, 22, 0.3);
        }
        
        body.dark-mode .btn-secondary {
            border-color: #F39C16;
            color: #F39C16;
        }
        body.dark-mode .btn-secondary:hover {
            background: rgba(243, 156, 22, 0.05);
        }
        
        body.dark-mode .btn-outline {
            border-color: #F39C16;
            color: #F39C16;
        }
        body.dark-mode .btn-outline:hover {
            background: #F39C16;
            color: white;
        }
        
        @media (max-width: 640px) {
            .btn-primary, .btn-secondary, .btn-danger, .btn-outline {
                padding: 6px 12px;
                font-size: 11px;
            }
        }
        
        .input-modern {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 16px;
            color: #F1F5F9;
            font-size: 14px;
            transition: all 0.2s ease;
            width: 100%;
        }
        .input-modern:focus {
            outline: none;
            border-color: var(--brand-orange);
            background: rgba(255, 255, 255, 0.08);
        }
        
        select.input-modern {
            background-color: rgba(255, 255, 255, 0.05);
            cursor: pointer;
        }
        
        textarea.input-modern {
            resize: vertical;
        }
        
        select.input-modern option {
            background-color: #1E293B;
            color: #F1F5F9;
        }

        #sidebarOverlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 39;
            backdrop-filter: blur(2px);
        }
        #sidebarOverlay.show {
            display: block;
        }
        
        .wrapper {
            display: flex;
            min-height: 100vh;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }
        
        #sidebar {
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            position: fixed !important;
            top: 0;
            left: 0;
            height: 100vh !important;
            width: 288px !important;
            z-index: 1000 !important;
            overflow-y: auto !important;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        #sidebar.open {
            transform: translateX(0);
        }

        @media (min-width: 1024px) {
            #sidebar {
                position: relative !important;
                transform: translateX(0) !important;
                flex-shrink: 0;
            }
            #sidebarOverlay {
                display: none !important;
            }
            #sidebarToggle {
                display: none !important;
            }
        }

        #sidebar > nav {
            flex: 1 1 auto !important;
            overflow-y: auto !important;
        }
        
        #sidebar > div:last-child {
            margin-top: auto !important;
            flex-shrink: 0 !important;
        }
        
        main {
            flex: 1;
            overflow-y: auto !important;
            height: 100vh;
            width: 100%;
            min-width: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
        }
        
        body.dark-mode th,
        body.dark-mode td {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        body.light-mode th,
        body.light-mode td {
            border-bottom: 1px solid #CBD5E1;
        }
        
        body.light-mode th {
            background-color: #F1F5F9;
            color: #1E293B;
        }
        
        body.dark-mode th {
            background-color: rgba(255, 255, 255, 0.05);
            color: #E2E8F0;
        }
        
        body.light-mode tr:hover {
            background-color: #F8FAFC;
        }
        
        body.dark-mode tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }
        
        @media (max-width: 640px) {
            .stat-card {
                padding: 12px !important;
            }
            th, td {
                padding: 8px 10px !important;
                font-size: 11px !important;
            }
            .card-glass {
                padding: 12px !important;
                border-radius: 16px !important;
            }
            #sidebar {
                width: 280px !important;
            }
            .settings-trigger {
                padding: 5px 10px !important;
                font-size: 11px !important;
            }
            .overflow-x-auto {
                overflow-x: auto !important;
            }
            table {
                min-width: 480px !important;
            }
        }

        html, body {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background-attachment: fixed !important;
            background-size: cover !important;
            min-height: 100vh;
        }

        @media (max-width: 640px) {
            body {
                background-attachment: fixed !important;
                background-size: cover !important;
            }
            
            .wrapper {
                width: 100%;
                overflow-x: hidden;
            }
            
            main {
                overflow-x: hidden !important;
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="dark-mode font-sans antialiased" id="appBody">

    <!-- Mobile Menu Toggle -->
    <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-slate-800/90 backdrop-blur-lg border border-white/10 rounded-xl p-2.5 text-white shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div class="wrapper">

        <div id="sidebarOverlay"></div>

        <aside id="sidebar">
            
            <div class="p-6 border-b border-white/10 flex-shrink-0 brand">
                <h1 class="text-2xl font-bold" style="background: linear-gradient(135deg, #F39C16, #F0D192); -webkit-background-clip: text; background-clip: text; color: transparent;">AJ NETWORK</h1>
                <p class="text-xs text-slate-500 mt-1">Network Monitoring System</p>
            </div>
            
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
                <!-- Dashboard - SEMUA ROLE bisa lihat -->
                <a href="{{ route('dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <!-- Menu khusus ADMINISTRATOR saja -->
                @if(Auth::user()->role == 'administrator')
                <a href="{{ route('pelanggan.index') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    Pelanggan
                </a>

                <!-- Menu khusus ADMINISTRATOR saja -->
                <a href="{{ route('log.index') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('log.*') ? 'active' : '' }}">
                    Log Aktivitas
                </a>
                <a href="{{ route('notifikasi.index') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('notifikasi.*') ? 'active' : '' }}">
                    Notifikasi
                </a>
                @endif
                
                <!-- Pembayaran - SEMUA ROLE bisa lihat -->
                <a href="{{ route('pembayaran.index') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                    Pembayaran
                </a>
                
                <!-- Laporan Keuangan - SEMUA ROLE bisa lihat -->
                <a href="{{ route('laporan.index') }}" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    Laporan Keuangan
                </a>
            </nav>
            
            <div class="p-4 border-t border-white/10 flex-shrink-0">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 transition-all duration-200">
                        {{ __('messages.logout') }}
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 transition-all duration-300">
            
            <nav class="bg-slate-800/50 backdrop-blur-lg border border-white/10 rounded-2xl mb-4 sm:mb-6 p-3 sm:p-4 flex justify-between items-center gap-2 relative z-30">
                <div class="text-slate-200 text-xs sm:text-sm font-medium pl-8 lg:pl-0 truncate">
                    {{ session('locale', 'id') == 'id' ? 'Sistem Informasi & Monitoring Jaringan' : 'Information System & Network Monitoring' }}
                </div>
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    <div class="text-slate-400 text-xs sm:text-sm pr-2 sm:pr-3 border-r border-white/10 hidden sm:block">
                        {{ Auth::user()->nama_lengkap ?? 'Admin' }}
                        <span class="text-xs ml-1 px-1 py-0.5 rounded bg-gray-700 text-white">({{ Auth::user()->role == 'administrator' ? 'Admin' : 'Direktur' }})</span>
                    </div>
                    
                    <div class="dropdown">
                        <button type="button" class="settings-trigger text-xs sm:text-sm" id="settingsDropdownBtn">
                            ⚙ {{ session('locale', 'id') == 'id' ? 'Pengaturan' : 'Settings' }}
                        </button>
                        <div class="dropdown-menu" id="settingsDropdownMenu">
                            <div class="dropdown-header">{{ session('locale', 'id') == 'id' ? 'BAHASA' : 'LANGUAGE' }}</div>
                            <a href="{{ route('lang.switch', 'id') }}" class="{{ session('locale', 'id') == 'id' ? 'active' : '' }}">Indonesia</a>
                            <a href="{{ route('lang.switch', 'en') }}" class="{{ session('locale', 'id') == 'en' ? 'active' : '' }}">English</a>
                            <div class="dropdown-header">{{ session('locale', 'id') == 'id' ? 'TEMA' : 'THEME' }}</div>
                            <a href="#" onclick="setTheme('dark'); return false;" id="themeDark">{{ session('locale', 'id') == 'id' ? 'Gelap' : 'Dark' }}</a>
                            <a href="#" onclick="setTheme('light'); return false;" id="themeLight">{{ session('locale', 'id') == 'id' ? 'Terang' : 'Light' }}</a>
                        </div>
                    </div>
                </div>
            </nav>
            
            @if(session('success'))
                <div id="flashSuccess" style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999; min-width:260px; max-width:360px;"
                    class="p-3 sm:p-4 bg-emerald-500/90 border border-emerald-400 rounded-xl text-white text-xs sm:text-sm shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div id="flashWarning" style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999; min-width:260px; max-width:360px;"
                    class="p-3 sm:p-4 bg-red-500/90 border border-red-400 rounded-xl text-white text-xs sm:text-sm shadow-lg">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('error'))
                <div id="flashError" style="position:fixed; top:20px; left:50%; transform:translateX(-50%); z-index:9999; min-width:260px; max-width:360px;"
                    class="p-3 sm:p-4 bg-red-500/90 border border-red-400 rounded-xl text-white text-xs sm:text-sm shadow-lg">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function applyTheme() {
            let theme = sessionStorage.getItem('theme') || 'dark';
            document.body.classList.remove('dark-mode', 'light-mode');
            document.body.classList.add(theme === 'dark' ? 'dark-mode' : 'light-mode');

            // Sync active di dropdown
            const darkBtn = document.getElementById('themeDark');
            const lightBtn = document.getElementById('themeLight');
            if (darkBtn && lightBtn) {
                darkBtn.classList.toggle('active', theme === 'dark');
                lightBtn.classList.toggle('active', theme === 'light');
            }
        }
        
        function setTheme(theme) {
            sessionStorage.setItem('theme', theme);
            localStorage.setItem('theme', theme);
            document.body.classList.remove('dark-mode', 'light-mode');
            document.body.classList.add(theme === 'dark' ? 'dark-mode' : 'light-mode');

            const darkBtn = document.getElementById('themeDark');
            const lightBtn = document.getElementById('themeLight');
            if (darkBtn && lightBtn) {
                darkBtn.classList.toggle('active', theme === 'dark');
                lightBtn.classList.toggle('active', theme === 'light');
            }
        }       
        
        // Terapkan tema saat halaman load
        document.addEventListener('DOMContentLoaded', applyTheme);

        // ===== SIDEBAR TOGGLE =====
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });

        // ===== DROPDOWN SETTINGS =====
        const dropdownBtn = document.getElementById('settingsDropdownBtn');
        const dropdownMenu = document.getElementById('settingsDropdownMenu');
        
        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
            
            document.addEventListener('click', (e) => {
                if (!dropdownBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }
        
        // ===== AUTO HIDE FLASH MESSAGES =====
        setTimeout(() => {
            ['flashSuccess', 'flashWarning', 'flashError'].forEach(id => {
                const el = document.getElementById(id);
                if (el) {
                    el.style.transition = 'opacity 0.5s, transform 0.5s';
                    el.style.opacity = '0';
                    el.style.transform = 'translateX(20px)';
                    setTimeout(() => el.remove(), 500);
                }
            });
        }, 3000);
    </script>
    @stack('scripts')
</body>
</html>