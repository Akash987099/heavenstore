
  <!-- SIDEBAR -->
  <aside class="w-[72px] md:w-[260px] h-full flex-shrink-0 bg-white/80 glass border-r border-white/40 shadow-sm hidden md:flex flex-col py-6 px-3 overflow-y-auto">
    <!-- logo -->
    <div class="flex items-center gap-2 px-3 mb-8">
      <span class="text-xl font-bold text-[#0F172A] tracking-tight hidden md:block">Heaven<span class="text-[#25D366]">Kart</span></span>
    </div>

    <!-- nav -->
    <nav class="flex-1 space-y-1.5">
      <a href="{{ route('index') }}" class="sidebar-link {{ request()->routeIs('index') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600"><i class="fas fa-th-large w-5 text-center"></i><span class="hidden md:inline">Dashboard</span></a>
      <a href="{{ route('pos.order') }}" class="sidebar-link {{ request()->routeIs('pos.order.*') ? 'active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600"><i class="fas fa-table w-5 text-center"></i><span class="hidden md:inline">Create Order</span></a>
      <a href="#" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600"><i class="fas fa-cog w-5 text-center"></i><span class="hidden md:inline">Settings</span></a>
    </nav>

    <!-- logout -->
    <div class="mt-auto pt-4 border-t border-slate-200/60">
      <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:text-rose-600 transition"><i class="fas fa-sign-out-alt w-5 text-center"></i><span class="hidden md:inline">Logout</span></a>
    </div>
  </aside>

  

  <!-- MAIN -->
  <main class="flex-1 flex flex-col min-w-0 h-full overflow-hidden">

    <!-- TOP NAV -->
    <header class="bg-white/70 glass border-b border-white/40 px-6 py-3 flex items-center justify-between flex-shrink-0">
      <div class="flex items-center gap-4 w-full md:w-auto">
        <i class="fas fa-bars text-slate-400 text-xl md:hidden"></i>
        <div class="relative flex-1 md:flex-none">
          <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
          <input type="text" placeholder="Search..." class="w-full md:w-64 pl-9 pr-4 py-2 bg-slate-100/70 rounded-xl text-sm border border-transparent focus:border-[#25D366] focus:bg-white focus:outline-none transition placeholder:text-slate-400">
        </div>
      </div>
      <div class="flex items-center gap-4">
        <i class="fas fa-bell text-slate-500 text-xl hover:text-[#128C7E] transition"></i>
        <div class="flex items-center gap-2 border-l border-slate-200 pl-4">
          <span class="text-sm font-semibold text-slate-700 hidden sm:block">{{Auth::guard('pos')->user()->name}}</span>
        </div>
      </div>
    </header>
