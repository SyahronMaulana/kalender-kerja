<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Masuk · Kalender Kerja</title>
</head>
<body class="grid min-h-screen place-items-center bg-slate-100 p-5 text-slate-800">
    <form method="POST" action="{{ route('login.store') }}" class="w-full max-w-md rounded-2xl bg-white p-8 shadow-xl shadow-slate-300/40 ring-1 ring-slate-200">
        @csrf
        <div class="mb-7 text-center">
            <img src="{{ asset('images/urecel-factory-support.png') }}" alt="Urecel QuickDry Factory Support" class="mx-auto h-28 w-28 object-contain">
            <h1 class="mt-4 text-2xl font-bold tracking-tight">Kalender Kerja</h1>
            <p class="mt-1 text-sm text-slate-500">Masuk untuk melihat jadwal operasional.</p>
        </div>
        @error('email')<p class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ $message }}</p>@enderror
        <label class="mb-4 block text-sm font-semibold">Email
            <input class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5 focus:border-slate-800 focus:ring-slate-800" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
        </label>
        <label class="mb-5 block text-sm font-semibold">Password
            <input class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5 focus:border-slate-800 focus:ring-slate-800" type="password" name="password" required autocomplete="current-password">
        </label>
        <button class="w-full rounded-lg bg-slate-900 p-2.5 font-semibold text-white transition hover:bg-slate-700">Masuk</button>
    </form>
</body>
</html>
