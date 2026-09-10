<!DOCTYPE html>
<html lang="en" class="h-full bg-[#fbf8f4]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Coffee Shop Cambodia
  </title>

    <!-- Google Fonts: Plus Jakarta Sans & Caveat for cursive script -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        coffee: {
                            50: '#fdfbf7',
                            100: '#f7efe9',
                            200: '#ebd9cb',
                            300: '#d9bda3',
                            400: '#c49a6c',
                            500: '#a36d40',
                            600: '#875130',
                            700: '#5c3520',
                            800: '#3f2417',
                            900: '#23150d',
                            950: '#1b110b',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        script: ['"Caveat"', 'cursive'],
                    }
                }
            }
        }
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fbf8f4;
            color: #2b231d;
        }
        .font-script {
            font-family: 'Caveat', cursive;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1ede8;
        }
        ::-webkit-scrollbar-thumb {
            background: #d4c5b9;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #bfaea0;
        }
        .sidebar-item-active {
            background-color: #43271a;
            color: #ffffff !important;
            font-weight: 600;
        }
        .sidebar-item-active i, .sidebar-item-active svg {
            color: #ffffff !important;
        }
    </style>
</head>
<body class="h-full antialiased overflow-x-hidden" x-data="{ sidebarOpen: false, timeFilter: '7days' }">

@php
    $currentUser = auth()->user();
    $currentUserName = $currentUser ? ($currentUser->full_name ?: ($currentUser->name ?: 'Admin User')) : 'Admin User';
    $currentUserAvatar = ($currentUser && $currentUser->avatar && file_exists(public_path($currentUser->avatar)))
        ? asset($currentUser->avatar)
        : asset('img/dashboard-coffee/avatar_sok_dara.jpg');
    $currentUserRole = $currentUser ? ($currentUser->role?->name ?: 'Admin') : 'Admin';
    $pendingBadgeCount = ($pending_orders ?? 0) > 0 ? $pending_orders : ($total_orders ?? 3);
@endphp

<div class="min-h-full flex">

    <!-- ============================================================== -->
    <!-- LEFT SIDEBAR                                                   -->
    <!-- ============================================================== -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-[#1b110b] flex flex-col justify-between transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto"
           :class="sidebarOpen ? 'translate-x-0 shadow-2xl' : '-translate-x-full'">
        
        <!-- Sidebar Top Header & Menu -->
        <div class="px-5 pt-6 pb-4 flex-1 flex flex-col overflow-y-auto">
            
            <!-- Brand Logo -->
            <div class="flex items-center gap-3 px-2 mb-8">
                <!-- Coffee Cup with Steam Logo Icon -->
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#452719] to-[#2a170e] flex items-center justify-center text-[#d4a373] shadow-inner flex-shrink-0 border border-[#4d2e20]">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 8h1a4 4 0 0 1 0 8h-1"></path>
                        <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path>
                        <line x1="6" y1="1" x2="6" y2="4"></line>
                        <line x1="10" y1="1" x2="10" y2="4"></line>
                        <line x1="14" y1="1" x2="14" y2="4"></line>
                    </svg>
                </div>
                <div>
                    <h1 class="text-white font-bold text-lg tracking-tight leading-tight">System Coffee</h1>
                    <p class="text-[11px] text-[#a6958a] font-medium tracking-wide">Good Coffee &bull; Better Days</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5 flex-1">
                <!-- 1. Dashboard (Active) -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-item-active flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm transition-all duration-150">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Orders -->
                <a href="{{ route('order.index') }}" 
                   class="flex items-center justify-between px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <div class="flex items-center gap-3.5">
                        <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span>Orders</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-full text-[11px] font-semibold bg-[#703b22] text-white">{{ $pendingBadgeCount }}</span>
                </a>

                <!-- 3. Products -->
                <a href="{{ route('product.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span>Products</span>
                </a>

                <!-- 4. POS -->
                <a href="{{ route('order.create') }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                    <span>POS</span>
                </a>

                <!-- 5. Tables -->
                <a href="{{ Route::has('reservation.index') ? route('reservation.index') : (Route::has('reservation.public') ? route('reservation.public') : url('/reservation')) }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14"></path>
                        <line x1="2" y1="19" x2="22" y2="19"></line>
                    </svg>
                    <span>Tables</span>
                </a>

                <!-- 6. Customers -->
                <a href="{{ route('customer.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Customers</span>
                </a>

                <!-- 7. Reports -->
                <a href="{{ route('reports.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Reports</span>
                </a>

                <!-- 8. Staff -->
                <a href="{{ route('employee.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Staff</span>
                </a>

                <!-- 9. Settings -->
                <a href="{{ route('user.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-sm font-medium text-[#b5a397] hover:text-white hover:bg-white/5 transition-all duration-150">
                    <svg class="w-5 h-5 text-[#9e8c81]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- Bottom Coffee Quote Card Widget -->
            <div class="mt-6 mb-2">
                <div class="relative rounded-2xl overflow-hidden shadow-lg border border-[#3b2318] h-36 flex flex-col justify-end p-4 group">
                    <!-- Background image with latte art -->
                    <img src="{{ asset('img/dashboard-coffee/sidebar_promo.jpg') }}" 
                         alt="Good Coffee" 
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>
                    
                    <div class="relative z-10">
                        <h4 class="font-script text-white text-xl leading-snug font-bold">Good Coffee<br>Better Days</h4>
                        <p class="text-[11px] text-amber-200/80 font-light mt-0.5">Fresh coffee<br>Fresh ideas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Profile Bottom Bar in Sidebar -->
        <div class="px-5 py-4 border-t border-[#2e1d14] bg-[#170e08]/70 flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ $currentUserAvatar }}" 
                     alt="{{ $currentUserName }}" 
                     class="w-9 h-9 rounded-full object-cover border border-[#4d3223] flex-shrink-0">
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate leading-tight">
                        {{ $currentUserName }}
                    </p>
                    <p class="text-xs text-[#a6958a] truncate">{{ $currentUserRole }}</p>
                </div>
            </div>
            <a href="{{ route('customer.profile') }}" class="text-[#a6958a] hover:text-white transition-colors" title="Options">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
            </a>
        </div>
    </aside>

    <!-- Overlay backdrop for mobile -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    <!-- ============================================================== -->
    <!-- MAIN WRAPPER (NAVBAR + CONTENT)                                -->
    <!-- ============================================================== -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- Top Header Navbar -->
        <header class="sticky top-0 z-30 bg-[#fbf8f4]/95 backdrop-blur-md border-b border-[#eee6dc] px-4 sm:px-8 py-3 flex items-center justify-between gap-4">
            
            <!-- Left: Toggle Hamburger & Search -->
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <!-- Hamburger on Mobile / Desktop -->
                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 rounded-xl text-[#3d261a] hover:bg-[#f0e8de] transition-colors focus:outline-none" 
                        aria-label="Toggle Navigation">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>

                <!-- Search Input Pill with Ctrl + K -->
                <div class="relative w-full max-w-md hidden sm:block">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#9e8e82]">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>
                    <input type="text" 
                           placeholder="Search anything..." 
                           class="w-full pl-9 pr-16 py-2 rounded-full text-sm bg-white border border-[#e5dcd1] placeholder-[#a6978a] text-[#2c2017] focus:outline-none focus:ring-2 focus:ring-[#8c5332]/20 focus:border-[#8c5332] transition-all shadow-sm">
                    <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none">
                        <kbd class="px-2 py-0.5 text-[10px] font-semibold text-[#8a7b70] bg-[#f5ede5] border border-[#e2d6c9] rounded-md shadow-xs">Ctrl + K</kbd>
                    </div>
                </div>
            </div>

            <!-- Right Controls: Notification, Sun toggle, User profile -->
            <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0">
                
                <!-- Notification Bell -->
                <a href="{{ route('order.index') }}" class="relative p-2 rounded-full text-[#4a3528] hover:bg-[#f0e8de] transition-colors focus:outline-none" title="Orders">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                    <span class="absolute top-1 right-1 w-4 h-4 rounded-full bg-[#df382b] text-white text-[9px] font-bold flex items-center justify-center ring-2 ring-[#fbf8f4]">{{ $pendingBadgeCount }}</span>
                </a>

                <!-- Sun / Theme Toggle -->
                <button class="p-2 rounded-full text-[#4a3528] hover:bg-[#f0e8de] transition-colors focus:outline-none" title="Light Mode Active">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5"></circle>
                        <line x1="12" y1="12" x2="12" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="23"></line>
                        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                        <line x1="1" y1="12" x2="3" y2="12"></line>
                        <line x1="21" y1="12" x2="23" y2="12"></line>
                        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                    </svg>
                </button>

                <!-- Profile Pill -->
                <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 pl-2 sm:pl-3 sm:border-l sm:border-[#e5dcd1]">
                    <img src="{{ $currentUserAvatar }}" 
                         alt="{{ $currentUserName }}" 
                         class="w-8 h-8 rounded-full object-cover border border-[#d9cbbd]">
                    <div class="hidden sm:block text-left">
                        <div class="text-xs font-bold text-[#23150d] leading-none truncate max-w-[120px]">
                            {{ $currentUserName }}
                        </div>
                        <div class="text-[11px] text-[#8f7f74] font-medium mt-0.5">{{ $currentUserRole }}</div>
                    </div>
                </a>
            </div>
        </header>

        <!-- ========================================================== -->
        <!-- MAIN DASHBOARD CONTENT AREA                                -->
        <!-- ========================================================== -->
        <main class="flex-1 px-4 sm:px-8 py-6 max-w-[1600px] w-full mx-auto space-y-6">

            <!-- 1. HERO WELCOME BANNER -->
            <div class="relative rounded-2xl overflow-hidden shadow-sm border border-[#3b2318] min-h-[140px] flex items-center bg-[#1e130c]">
                <!-- Background Image & Gradient overlay -->
                <img src="{{ asset('img/dashboard-coffee/banner_coffee_cup.jpg') }}" 
                     alt="Coffee Cup" 
                     class="absolute right-0 top-0 bottom-0 h-full w-auto max-w-[50%] object-cover object-left opacity-90">
                <div class="absolute inset-0 bg-gradient-to-r from-[#190e08] via-[#1e130cd9] to-transparent"></div>

                <!-- Left Content -->
                <div class="relative z-10 px-6 sm:px-8 py-5 max-w-2xl">
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                        Welcome Back, {{ $currentUserName }}!
                    </h2>
                    <p class="text-xs sm:text-sm text-[#d4c3b7] mt-1 font-normal">
                        Here's what's happening with your coffee shop today.
                    </p>

                    <!-- Date and Time Badges -->
                    <div class="flex items-center flex-wrap gap-2.5 mt-4">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white/10 backdrop-blur-md text-white/90 text-xs font-medium border border-white/10 shadow-xs">
                            <i class="far fa-calendar text-[11px] text-[#ebd4c1]"></i>
                            <span>Today, {{ $current_date_formatted ?? now()->format('j M Y') }}</span>
                        </div>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-white/10 backdrop-blur-md text-white/90 text-xs font-medium border border-white/10 shadow-xs">
                            <i class="far fa-clock text-[11px] text-[#ebd4c1]"></i>
                            <span>{{ $current_time_formatted ?? now()->format('h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Handwritten Cursive Overlay on the Right -->
                <div class="hidden md:block absolute right-8 top-1/2 -translate-y-1/2 z-10 text-right pointer-events-none">
                    <span class="font-script text-white text-3xl font-bold tracking-wide drop-shadow-md">
                        Good Coffee<br>Better Days <span class="text-red-300">♡</span>
                    </span>
                </div>
            </div>

            <!-- 2. FOUR TOP METRIC CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-5">
                
                <!-- Card 1: Total Sales -->
                <div class="bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-[#f7efe9] flex items-center justify-center text-[#875130]">
                            <i class="fas fa-mug-hot text-base"></i>
                        </div>
                        <span class="text-[#875130] text-sm">
                            <i class="fas fa-chart-simple"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs font-semibold text-[#8c7e75] tracking-wide">Total Sales</p>
                        <h3 class="text-2xl font-bold text-[#1f140e] mt-1 tracking-tight">
                            ${{ $display_total_sales ?? '0.00' }}
                        </h3>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-xs">
                        @if(($sales_growth ?? 0) >= 0)
                            <span class="font-bold text-emerald-600 flex items-center gap-0.5">
                                <i class="fas fa-arrow-up text-[10px]"></i> {{ $sales_growth ?? 12 }}%
                            </span>
                        @else
                            <span class="font-bold text-rose-600 flex items-center gap-0.5">
                                <i class="fas fa-arrow-down text-[10px]"></i> {{ abs($sales_growth) }}%
                            </span>
                        @endif
                        <span class="text-[#9e9087]">vs yesterday</span>
                    </div>
                </div>

                <!-- Card 2: Total Orders -->
                <div class="bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-[#f7efe9] flex items-center justify-center text-[#875130]">
                            <i class="fas fa-shopping-cart text-base"></i>
                        </div>
                        <span class="text-[#875130] text-sm">
                            <i class="fas fa-chart-line"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs font-semibold text-[#8c7e75] tracking-wide">Total Orders</p>
                        <h3 class="text-2xl font-bold text-[#1f140e] mt-1 tracking-tight">
                            {{ $display_total_orders ?? 0 }}
                        </h3>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-xs">
                        @if(($orders_growth ?? 0) >= 0)
                            <span class="font-bold text-emerald-600 flex items-center gap-0.5">
                                <i class="fas fa-arrow-up text-[10px]"></i> {{ $orders_growth ?? 8 }}%
                            </span>
                        @else
                            <span class="font-bold text-rose-600 flex items-center gap-0.5">
                                <i class="fas fa-arrow-down text-[10px]"></i> {{ abs($orders_growth) }}%
                            </span>
                        @endif
                        <span class="text-[#9e9087]">vs yesterday</span>
                    </div>
                </div>

                <!-- Card 3: Customers -->
                <div class="bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-[#f7efe9] flex items-center justify-center text-[#875130]">
                            <i class="fas fa-users text-base"></i>
                        </div>
                        <span class="text-[#875130] text-sm">
                            <i class="fas fa-arrow-trend-up"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs font-semibold text-[#8c7e75] tracking-wide">Customers</p>
                        <h3 class="text-2xl font-bold text-[#1f140e] mt-1 tracking-tight">
                            {{ $display_customers ?? 0 }}
                        </h3>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-xs">
                        <span class="font-bold text-emerald-600 flex items-center gap-0.5">
                            <i class="fas fa-arrow-up text-[10px]"></i> {{ $customers_growth ?? 15 }}%
                        </span>
                        <span class="text-[#9e9087]">vs yesterday</span>
                    </div>
                </div>

                <!-- Card 4: Avg. Order Value -->
                <div class="bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-[#f7efe9] flex items-center justify-center text-[#875130]">
                            <i class="fas fa-box-open text-base"></i>
                        </div>
                        <span class="text-[#875130] text-sm">
                            <i class="fas fa-arrow-up-right-dots"></i>
                        </span>
                    </div>
                    <div class="mt-4">
                        <p class="text-xs font-semibold text-[#8c7e75] tracking-wide">Avg. Order Value</p>
                        <h3 class="text-2xl font-bold text-[#1f140e] mt-1 tracking-tight">
                            ${{ $display_avg_order ?? '0.00' }}
                        </h3>
                    </div>
                    <div class="mt-3 flex items-center gap-1.5 text-xs">
                        <span class="font-bold text-emerald-600 flex items-center gap-0.5">
                            <i class="fas fa-arrow-up text-[10px]"></i> {{ $avg_order_growth ?? 10 }}%
                        </span>
                        <span class="text-[#9e9087]">vs yesterday</span>
                    </div>
                </div>
            </div>

            <!-- ========================================================== -->
            <!-- 3. MAIN DUAL-COLUMN SECTION                                -->
            <!-- ========================================================== -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                <!-- ------------------------------------------------------ -->
                <!-- LEFT COLUMN (Span 8 out of 12)                         -->
                <!-- ------------------------------------------------------ -->
                <div class="xl:col-span-8 space-y-6">

                    <!-- ROW 1: Sales Overview (Left) + Top Selling Products (Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                        
                        <!-- Sales Overview Card (Col 7) -->
                        <div class="lg:col-span-7 bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs">
                            <div class="flex items-center justify-between flex-wrap gap-2 mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-[#875130]"></span>
                                    <h3 class="font-bold text-sm text-[#1f140e]">Sales Overview</h3>
                                </div>

                                <!-- Filter Buttons: 7 Days / 30 Days / 1 Year -->
                                <div class="inline-flex rounded-lg p-0.5 bg-[#f6eee7] text-xs font-medium">
                                    <button @click="timeFilter = '7days'; updateSalesChart('7days')" 
                                            :class="timeFilter === '7days' ? 'bg-[#43271a] text-white shadow-xs' : 'text-[#7d6c61] hover:text-[#23150d]'"
                                            class="px-2.5 py-1 rounded-md transition-all">
                                        7 Days
                                    </button>
                                    <button @click="timeFilter = '30days'; updateSalesChart('30days')" 
                                            :class="timeFilter === '30days' ? 'bg-[#43271a] text-white shadow-xs' : 'text-[#7d6c61] hover:text-[#23150d]'"
                                            class="px-2.5 py-1 rounded-md transition-all">
                                        30 Days
                                    </button>
                                    <button @click="timeFilter = '1year'; updateSalesChart('1year')" 
                                            :class="timeFilter === '1year' ? 'bg-[#43271a] text-white shadow-xs' : 'text-[#7d6c61] hover:text-[#23150d]'"
                                            class="px-2.5 py-1 rounded-md transition-all">
                                        1 Year
                                    </button>
                                </div>
                            </div>

                            <!-- Line Chart Container -->
                            <div class="h-56 relative w-full">
                                <canvas id="salesOverviewChart"></canvas>
                            </div>
                        </div>

                        <!-- Top Selling Products (Col 5) -->
                        <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-mug-saucer text-[#875130] text-xs"></i>
                                        <h3 class="font-bold text-sm text-[#1f140e]">Top Selling Products</h3>
                                    </div>
                                    <a href="{{ route('product.index') }}" class="text-xs font-medium text-[#875130] hover:underline">View All</a>
                                </div>

                                <!-- Product Rows List from Real DB -->
                                <div class="space-y-3.5">
                                    @forelse($top_products ?? [] as $item)
                                    <div class="flex items-center justify-between text-xs">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            <img src="{{ $item['image'] }}" 
                                                 alt="{{ $item['name'] }}" 
                                                 class="w-7 h-7 rounded-lg object-cover border border-[#f0e7dd] flex-shrink-0">
                                            <span class="font-semibold text-[#2c1f17] truncate max-w-[130px]">{{ $item['name'] }}</span>
                                        </div>
                                        <div class="flex items-center gap-4 text-right flex-shrink-0">
                                            <span class="text-[#807268] font-medium">{{ $item['sold'] }} sold</span>
                                            <span class="font-bold text-[#1f140e] min-w-[40px]">${{ number_format($item['price'], 2) }}</span>
                                        </div>
                                    </div>
                                    @empty
                                    <p class="text-xs text-[#8c7e75] py-2">No products sold yet.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ROW 2: Recent Orders (Left) + Sales by Category (Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
                        
                        <!-- Recent Orders Table Card (Col 7) -->
                        <div class="lg:col-span-7 bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-receipt text-[#875130] text-xs"></i>
                                    <h3 class="font-bold text-sm text-[#1f140e]">Recent Orders</h3>
                                </div>
                                <a href="{{ route('order.index') }}" class="text-xs font-medium text-[#875130] hover:underline">View All</a>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="text-[#96887e] border-b border-[#f4eee7]">
                                            <th class="pb-2.5 font-semibold">#</th>
                                            <th class="pb-2.5 font-semibold">Customer</th>
                                            <th class="pb-2.5 font-semibold text-center">Items</th>
                                            <th class="pb-2.5 font-semibold">Total</th>
                                            <th class="pb-2.5 font-semibold">Status</th>
                                            <th class="pb-2.5 font-semibold">Time</th>
                                            <th class="pb-2.5 font-semibold text-right"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-[#f8f4ef]">
                                        @forelse($recent_orders ?? [] as $ord)
                                        <tr class="hover:bg-[#fbf9f6] transition-colors">
                                            <td class="py-2.5 text-[#8a7b71] font-medium">#{{ $ord['id'] }}</td>
                                            <td class="py-2.5">
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ $ord['avatar'] }}" 
                                                         alt="{{ $ord['customer'] }}" 
                                                         class="w-6 h-6 rounded-full object-cover border border-[#ebdccc] flex-shrink-0">
                                                    <span class="font-semibold text-[#241710] truncate max-w-[100px]">{{ $ord['customer'] }}</span>
                                                </div>
                                            </td>
                                            <td class="py-2.5 text-center text-[#695b52]">{{ $ord['items'] }}</td>
                                            <td class="py-2.5 font-bold text-[#1f140e]">${{ number_format($ord['total'], 2) }}</td>
                                            <td class="py-2.5">
                                                @if(strtolower($ord['status']) === 'preparing' || strtolower($ord['status']) === 'pending')
                                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-[#fef3c7] text-[#b45309]">
                                                        Preparing
                                                    </span>
                                                @elseif(strtolower($ord['status']) === 'delivered')
                                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-[#e0e7ff] text-[#3730a3]">
                                                        Delivered
                                                    </span>
                                                @elseif(strtolower($ord['status']) === 'cancelled')
                                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-[#fee2e2] text-[#b91c1c]">
                                                        Cancelled
                                                    </span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-semibold bg-[#dcfce7] text-[#15803d]">
                                                        Completed
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="py-2.5 text-[#8f8177] whitespace-nowrap">{{ $ord['time'] }}</td>
                                            <td class="py-2.5 text-right text-[#96897f]">
                                                <a href="{{ route('order.show', $ord['id']) }}" class="hover:text-[#23150d] p-1" title="View Order Details">
                                                    <i class="fas fa-ellipsis-vertical"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="py-4 text-center text-xs text-[#8c7e75]">No orders found in database.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Sales by Category (Col 5) -->
                        <div class="lg:col-span-5 bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-chart-pie text-[#875130] text-xs"></i>
                                        <h3 class="font-bold text-sm text-[#1f140e]">Sales by Category</h3>
                                    </div>
                                </div>

                                <!-- Doughnut Chart Area with Center Overlay -->
                                <div class="flex items-center justify-between gap-2 mt-2">
                                    <div class="w-36 h-36 relative flex-shrink-0">
                                        <canvas id="categoryDonutChart"></canvas>
                                        <!-- Center Text in Donut -->
                                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                                            <span class="text-xs font-bold text-[#1f140e] leading-tight">${{ $display_total_sales ?? '0.00' }}</span>
                                            <span class="text-[9px] text-[#96877d]">Total Sales</span>
                                        </div>
                                    </div>

                                    <!-- Category Legend List from Real DB -->
                                    <div class="space-y-2 text-xs flex-1 pl-2">
                                        @php
                                            $catPalette = ['#6F4E37', '#C49A6C', '#DDB892', '#3D2314', '#8C5332'];
                                            $colorIndex = 0;
                                        @endphp
                                        @foreach($category_sales ?? [] as $catName => $catPct)
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $catPalette[$colorIndex % count($catPalette)] }};"></span>
                                                <span class="text-[#63544a] truncate max-w-[95px]">{{ $catName }}</span>
                                            </div>
                                            <span class="font-bold text-[#23150d] ml-1">{{ $catPct }}%</span>
                                        </div>
                                        @php $colorIndex++; @endphp
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Mini Sparkline Trend -->
                            <div class="mt-4 pt-3 border-t border-[#f4ece3] flex items-center justify-between">
                                <div>
                                    <p class="text-[11px] font-semibold text-[#807065]">Weekly Sales</p>
                                    <p class="text-xs font-bold text-emerald-600 flex items-center gap-1 mt-0.5">
                                        <i class="fas fa-arrow-up text-[10px]"></i> {{ $sales_growth ?? 12 }}%
                                    </p>
                                </div>
                                <div class="w-28 h-8">
                                    <canvas id="miniSparkline"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ------------------------------------------------------ -->
                <!-- RIGHT COLUMN (Span 4 out of 12)                        -->
                <!-- ------------------------------------------------------ -->
                <div class="xl:col-span-4 space-y-5">
                    
                    <!-- 1. Today's Summary Card (Dark Espresso) -->
                    <div class="rounded-2xl p-5 bg-[#231710] text-white shadow-md border border-[#3b271d]">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-[#382318] flex items-center justify-center text-[#d4a373]">
                                    <i class="far fa-calendar-days text-sm"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-sm tracking-tight leading-tight">Today's Summary</h3>
                                    <p class="text-[11px] text-[#a6958a]">{{ $current_date_formatted ?? now()->format('j M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rows in Summary Card from Real DB -->
                        <div class="space-y-3.5 text-xs">
                            <!-- Today's Sales -->
                            <div class="flex items-center justify-between py-1 border-b border-[#362319]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#3b2318] flex items-center justify-center text-[#d4a373]">
                                        <i class="fas fa-mug-hot text-xs"></i>
                                    </div>
                                    <span class="text-[#cfc0b6] font-medium">Total Sales</span>
                                </div>
                                <span class="font-bold text-white text-sm">${{ $display_today_sales ?? $display_total_sales ?? '0.00' }}</span>
                            </div>

                            <!-- Total Orders -->
                            <div class="flex items-center justify-between py-1 border-b border-[#362319]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#3b2318] flex items-center justify-center text-[#d4a373]">
                                        <i class="fas fa-shopping-cart text-xs"></i>
                                    </div>
                                    <span class="text-[#cfc0b6] font-medium">Total Orders</span>
                                </div>
                                <span class="font-bold text-white text-sm">{{ $today_orders ?? $display_total_orders ?? 0 }}</span>
                            </div>

                            <!-- Customers -->
                            <div class="flex items-center justify-between py-1 border-b border-[#362319]">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#3b2318] flex items-center justify-center text-[#d4a373]">
                                        <i class="fas fa-users text-xs"></i>
                                    </div>
                                    <span class="text-[#cfc0b6] font-medium">Customers</span>
                                </div>
                                <span class="font-bold text-white text-sm">{{ $display_customers ?? 0 }}</span>
                            </div>

                            <!-- Avg. Order Value -->
                            <div class="flex items-center justify-between py-1">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#3b2318] flex items-center justify-center text-[#d4a373]">
                                        <i class="fas fa-box-open text-xs"></i>
                                    </div>
                                    <span class="text-[#cfc0b6] font-medium">Avg. Order Value</span>
                                </div>
                                <span class="font-bold text-white text-sm">${{ $display_avg_order ?? '0.00' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Action Buttons -->
                    <div class="space-y-2.5">
                        <a href="{{ route('order.create') }}" 
                           class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#48291a] hover:bg-[#391f13] text-white font-semibold text-xs sm:text-sm tracking-wide transition-colors shadow-xs">
                            <i class="fas fa-plus text-xs"></i>
                            <span>Create New Order</span>
                        </a>
                        <a href="{{ route('reports.index') }}" 
                           class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-white hover:bg-[#fbf7f2] text-[#3d2518] font-semibold text-xs sm:text-sm tracking-wide border border-[#e8ded3] transition-colors shadow-xs">
                            <i class="fas fa-chart-column text-xs text-[#875130]"></i>
                            <span>View Reports</span>
                        </a>
                    </div>

                    <!-- 3. Special Today Promo Card (Buy 2 Get 1 Free) -->
                    <div class="relative rounded-2xl overflow-hidden p-4 bg-[#f3e7dc] border border-[#e8dacd] flex items-center justify-between">
                        <!-- Left Info -->
                        <div class="z-10 max-w-[60%]">
                            <div class="flex items-center gap-1 text-[11px] font-semibold text-[#875130]">
                                <i class="fas fa-sparkles"></i>
                                <span>Special Today</span>
                            </div>
                            <h4 class="font-bold text-[#23150d] text-sm leading-snug mt-1">
                                Buy 2 Get 1 Free
                            </h4>
                            <p class="text-[10px] text-[#786659] mt-0.5">on Selected Drinks</p>
                            <a href="{{ route('menu') }}" 
                               class="inline-flex items-center gap-1.5 mt-3 px-3 py-1.5 rounded-full bg-[#231710] hover:bg-[#382318] text-white text-[11px] font-semibold transition-colors">
                                <span>View Menu</span>
                                <i class="fas fa-arrow-right text-[9px]"></i>
                            </a>
                        </div>

                        <!-- Right Coffee Cup Image -->
                        <div class="w-24 h-24 flex-shrink-0 flex items-center justify-center">
                            <img src="{{ asset('img/dashboard-coffee/special_coffee_cup.jpg') }}" 
                                 alt="Special Promo Drink" 
                                 class="w-full h-full object-contain drop-shadow-md">
                        </div>
                    </div>

                    <!-- 4. Quick Actions Grid Card (6 items) -->
                    <div class="bg-white rounded-2xl p-5 border border-[#ede5dc] shadow-xs">
                        <h3 class="font-bold text-sm text-[#1f140e] mb-4">Quick Actions</h3>

                        <div class="grid grid-cols-3 gap-2.5 text-center">
                            
                            <!-- 1. New Order -->
                            <a href="{{ route('order.create') }}" 
                               class="flex flex-col items-center justify-center p-3 rounded-xl bg-[#fbf8f4] hover:bg-[#f5ece2] transition-colors border border-[#f0e7dd] group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#875130] group-hover:scale-110 transition-transform">
                                    <i class="fas fa-cart-shopping text-sm"></i>
                                </div>
                                <span class="text-[11px] font-medium text-[#4d3c32] mt-1.5 leading-tight">New Order</span>
                            </a>

                            <!-- 2. Add Product -->
                            <a href="{{ route('product.create') }}" 
                               class="flex flex-col items-center justify-center p-3 rounded-xl bg-[#fbf8f4] hover:bg-[#f5ece2] transition-colors border border-[#f0e7dd] group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#875130] group-hover:scale-110 transition-transform">
                                    <i class="fas fa-square-plus text-sm"></i>
                                </div>
                                <span class="text-[11px] font-medium text-[#4d3c32] mt-1.5 leading-tight">Add Product</span>
                            </a>

                            <!-- 3. Manage Tables -->
                            <a href="{{ Route::has('reservation.index') ? route('reservation.index') : (Route::has('reservation.public') ? route('reservation.public') : url('/reservation')) }}" 
                               class="flex flex-col items-center justify-center p-3 rounded-xl bg-[#fbf8f4] hover:bg-[#f5ece2] transition-colors border border-[#f0e7dd] group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#875130] group-hover:scale-110 transition-transform">
                                    <i class="fas fa-chair text-sm"></i>
                                </div>
                                <span class="text-[11px] font-medium text-[#4d3c32] mt-1.5 leading-tight">Manage Tables</span>
                            </a>

                            <!-- 4. Customers -->
                            <a href="{{ route('customer.index') }}" 
                               class="flex flex-col items-center justify-center p-3 rounded-xl bg-[#fbf8f4] hover:bg-[#f5ece2] transition-colors border border-[#f0e7dd] group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#875130] group-hover:scale-110 transition-transform">
                                    <i class="fas fa-user-group text-sm"></i>
                                </div>
                                <span class="text-[11px] font-medium text-[#4d3c32] mt-1.5 leading-tight">Customers</span>
                            </a>

                            <!-- 5. Reports -->
                            <a href="{{ route('reports.index') }}" 
                               class="flex flex-col items-center justify-center p-3 rounded-xl bg-[#fbf8f4] hover:bg-[#f5ece2] transition-colors border border-[#f0e7dd] group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#875130] group-hover:scale-110 transition-transform">
                                    <i class="fas fa-chart-simple text-sm"></i>
                                </div>
                                <span class="text-[11px] font-medium text-[#4d3c32] mt-1.5 leading-tight">Reports</span>
                            </a>

                            <!-- 6. Settings -->
                            <a href="{{ route('user.index') }}" 
                               class="flex flex-col items-center justify-center p-3 rounded-xl bg-[#fbf8f4] hover:bg-[#f5ece2] transition-colors border border-[#f0e7dd] group">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#875130] group-hover:scale-110 transition-transform">
                                    <i class="fas fa-gear text-sm"></i>
                                </div>
                                <span class="text-[11px] font-medium text-[#4d3c32] mt-1.5 leading-tight">Settings</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<!-- ============================================================== -->
<!-- CHART SCRIPTS (Chart.js)                                       -->
<!-- ============================================================== -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // -------------------------------------------------------------
        // 1. Sales Overview Line Chart (From Real Database)
        // -------------------------------------------------------------
        const salesCanvas = document.getElementById('salesOverviewChart');
        let salesChartInstance = null;

        const chartDatasets = {
            '7days': {
                labels: {!! json_encode(array_column($sales_chart ?? [], 'label')) !!},
                data: {!! json_encode(array_column($sales_chart ?? [], 'value')) !!}
            },
            '30days': {
                labels: {!! json_encode(array_column($sales_30days ?? [], 'label')) !!},
                data: {!! json_encode(array_column($sales_30days ?? [], 'value')) !!}
            },
            '1year': {
                labels: {!! json_encode(array_column($sales_1year ?? [], 'label')) !!},
                data: {!! json_encode(array_column($sales_1year ?? [], 'value')) !!}
            }
        };

        function getDynamicMax(dataArray) {
            const maxVal = Math.max(0, ...dataArray);
            if (maxVal <= 10) return 10;
            if (maxVal <= 50) return 50;
            if (maxVal <= 200) return 200;
            if (maxVal <= 500) return 500;
            return Math.ceil(maxVal * 1.25);
        }

        if (salesCanvas) {
            const ctx = salesCanvas.getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 200);
            gradient.addColorStop(0, 'rgba(156, 102, 68, 0.35)');
            gradient.addColorStop(1, 'rgba(156, 102, 68, 0.00)');

            salesChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartDatasets['7days'].labels,
                    datasets: [{
                        label: 'Sales ($)',
                        data: chartDatasets['7days'].data,
                        borderColor: '#9C6644',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        tension: 0.45,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#8C5332',
                        pointBorderWidth: 2.5,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#231710',
                            titleColor: '#f7efe9',
                            bodyColor: '#ffffff',
                            padding: 10,
                            borderRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function (context) {
                                    return 'Sales: $' + Number(context.parsed.y).toFixed(2);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: getDynamicMax(chartDatasets['7days'].data),
                            ticks: {
                                color: '#9e8f85',
                                font: { size: 11 },
                                callback: function (val) {
                                    return '$' + val;
                                }
                            },
                            grid: {
                                color: '#f2eae2',
                                drawBorder: false,
                                borderDash: [4, 4]
                            }
                        },
                        x: {
                            ticks: {
                                color: '#9e8f85',
                                font: { size: 11 }
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        window.updateSalesChart = function (range) {
            if (!salesChartInstance || !chartDatasets[range]) return;
            salesChartInstance.data.labels = chartDatasets[range].labels;
            salesChartInstance.data.datasets[0].data = chartDatasets[range].data;
            salesChartInstance.options.scales.y.suggestedMax = getDynamicMax(chartDatasets[range].data);
            salesChartInstance.update();
        };

        // -------------------------------------------------------------
        // 2. Sales by Category Doughnut Chart (From Real Database)
        // -------------------------------------------------------------
        const categoryCanvas = document.getElementById('categoryDonutChart');
        if (categoryCanvas) {
            const catLabels = {!! json_encode(array_keys($category_sales ?? [])) !!};
            const catData = {!! json_encode(array_values($category_sales ?? [])) !!};

            new Chart(categoryCanvas, {
                type: 'doughnut',
                data: {
                    labels: catLabels,
                    datasets: [{
                        data: catData,
                        backgroundColor: ['#6F4E37', '#C49A6C', '#DDB892', '#3D2314', '#8C5332'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#231710',
                            padding: 8,
                            borderRadius: 8,
                            callbacks: {
                                label: function (context) {
                                    return context.label + ': ' + context.parsed + '%';
                                }
                            }
                        }
                    }
                }
            });
        }

        // -------------------------------------------------------------
        // 3. Mini Sparkline
        // -------------------------------------------------------------
        const sparklineCanvas = document.getElementById('miniSparkline');
        if (sparklineCanvas) {
            const ctxSpark = sparklineCanvas.getContext('2d');
            const sparkGradient = ctxSpark.createLinearGradient(0, 0, 0, 32);
            sparkGradient.addColorStop(0, 'rgba(156, 102, 68, 0.35)');
            sparkGradient.addColorStop(1, 'rgba(156, 102, 68, 0.00)');

            new Chart(ctxSpark, {
                type: 'line',
                data: {
                    labels: [1, 2, 3, 4, 5, 6, 7],
                    datasets: [{
                        data: {!! json_encode(array_column($sales_chart ?? [], 'value')) !!},
                        borderColor: '#9C6644',
                        backgroundColor: sparkGradient,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    scales: {
                        x: { display: false },
                        y: { display: false }
                    }
                }
            });
        }
    });
</script>

<!-- AlpineJS CDN for reactive interactions -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
