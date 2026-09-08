<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <title>Kalender Kerja</title>

    <link rel="shortcut icon" type="image/png/jpg" href="../images/urecel-factory-support.png">
    <style>
        .nav-link{display:flex;align-items:center;border-radius:.6rem;padding:.7rem .8rem;color:#cbd5e1;font-weight:500}.nav-link:hover,.nav-link.active{background:#1e293b;color:#fff}.fc{--fc-border-color:#e2e8f0;--fc-button-bg-color:#0f172a;--fc-button-border-color:#0f172a;--fc-button-hover-bg-color:#334155;--fc-today-bg-color:#fffbeb}.fc .fc-toolbar-title{font-size:1.25rem;font-weight:700;color:#0f172a}.fc .fc-button{box-shadow:none;text-transform:capitalize}.fc .fc-event{border:0;border-radius:5px;padding:2px 4px;font-size:.75rem;font-weight:600;cursor:pointer}.fc .fc-timegrid-event{min-height:24px}.fc .fc-scrollgrid{border-radius:.5rem;overflow:hidden}.fc .fc-daygrid-day-frame{min-height:112px}
    </style>
    @livewireStyles
</head>
<body class="bg-slate-100 text-slate-800 antialiased">
<div class="min-h-screen">
    <div id="nav-backdrop" class="fixed inset-0 z-40 hidden bg-slate-950/50 md:hidden"></div>
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 -translate-x-full bg-slate-950 px-4 py-6 text-white shadow-2xl transition-transform duration-200 md:translate-x-0 md:shadow-none">
        <div class="mb-9 flex items-center gap-3 px-2"><img src="{{ asset('images/urecel-factory-support.png') }}" alt="Urecel QuickDry Factory Support" class="h-12 w-12 shrink-0 rounded-full bg-white/10 object-contain p-0.5"><div class="min-w-0 flex-1"><p class="text-lg font-bold tracking-tight">Kalender Kerja</p><p class="mt-1 text-xs capitalize text-slate-400">{{ auth()->user()->role }}</p></div><button id="close-nav" type="button" aria-label="Tutup menu" class="grid h-9 w-9 place-items-center rounded-lg text-2xl text-slate-300 hover:bg-slate-800 md:hidden">×</button></div>
        <nav class="space-y-1"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a><a class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}" href="{{ route('calendar') }}">Kalender</a>@if(auth()->user()->isAdmin())<a class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}" href="{{ route('schedules.index') }}">Jadwal</a><a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">User</a>@endif<form method="POST" action="{{ route('logout') }}" class="pt-4">@csrf<button class="nav-link w-full text-left">Logout</button></form></nav>
    </aside>
    <main class="min-w-0 p-5 md:ml-64 md:p-8"><div class="mb-5 flex items-center gap-3 md:hidden"><button id="open-nav" type="button" aria-label="Buka menu" class="grid h-10 w-10 place-items-center rounded-lg bg-slate-900 text-xl text-white shadow-sm">☰</button><span class="font-semibold text-slate-700">Kalender Kerja</span></div>@yield('content')</main>
</div>
@livewireScripts
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('sidebar'), backdrop = document.getElementById('nav-backdrop');
        const open = () => { sidebar.classList.remove('-translate-x-full'); backdrop.classList.remove('hidden'); document.body.classList.add('overflow-hidden'); };
        const close = () => { sidebar.classList.add('-translate-x-full'); backdrop.classList.add('hidden'); document.body.classList.remove('overflow-hidden'); };
        document.getElementById('open-nav').addEventListener('click', open); document.getElementById('close-nav').addEventListener('click', close); backdrop.addEventListener('click', close);
        document.addEventListener('keydown', event => { if (event.key === 'Escape') close(); });
    });
</script>
</body></html>
