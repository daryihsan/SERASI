<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERASI - BPOM</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>

<body class="bg-slate-50 font-sans text-slate-800 antialiased"
      x-data="{ 
          sidebarOpen: false, 
          insertOpen: false 
      }"
      x-init="insertOpen = {{ request()->routeIs('serasi.insert.*') ? 'true' : 'false' }}">

    <div class="flex h-screen overflow-hidden">

        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 flex flex-col sidebar-transition lg:static lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="lg:hidden flex justify-end p-4 border-b border-slate-100">
                <button @click="sidebarOpen = false" class="text-slate-500 hover:text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="hidden lg:block h-6"></div>

            <nav class="flex-1 px-4 space-y-3 overflow-y-auto py-4">
                <a href="{{ route('serasi.index') }}" 
                   class="flex items-center gap-3 px-5 py-4 rounded-xl transition-all duration-200 font-bold text-lg w-full group
                   {{ request()->routeIs('serasi.index') ? 'bg-blue-600 text-white shadow-lg shadow-blue-200' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">
                   <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                   <span>Dashboard</span>
                </a>

                <div>
                    <button @click="insertOpen = !insertOpen" type="button" 
                            class="flex items-center justify-between gap-3 px-5 py-4 rounded-xl transition-all duration-200 font-bold text-lg w-full text-slate-600 hover:bg-blue-50 hover:text-blue-700"> 
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Insert Data</span>
                        </div>
                        <svg class="w-5 h-5 shrink-0 transition-transform duration-200" :class="insertOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="insertOpen" x-cloak x-transition.origin.top.duration.200ms class="pl-14 pr-2 py-2 space-y-1">
                        <a href="{{ route('serasi.insert.manual') }}" class="block px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('serasi.insert.manual') ? 'text-blue-600 bg-blue-50' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }}">• Input Manual</a>
                        <a href="{{ route('serasi.insert.excel') }}" class="block px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('serasi.insert.excel') ? 'text-blue-600 bg-blue-50' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }}">• Upload Excel</a>
                    </div>
                </div>
            </nav>
            <div class="p-4 border-t border-slate-100"></div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden w-full relative">
            
            <header class="bg-white border-b border-slate-200 flex items-center justify-between px-4 py-3 lg:hidden sticky top-0 z-40 w-full shadow-sm">
                
                <button @click="sidebarOpen = true" class="text-slate-600 p-2 rounded-md hover:bg-slate-100 border border-slate-200">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="font-bold text-blue-700 text-lg">SERASI Mobile</div>
                
            </header>

            <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden backdrop-blur-sm"></div>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 lg:p-10 w-full relative z-0">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>