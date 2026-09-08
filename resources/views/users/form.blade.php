@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <p class="text-sm font-medium text-slate-500">ADMINISTRASI</p>
        <h2 class="text-2xl font-bold tracking-tight">{{ $user->exists ? 'Edit User' : 'Tambah User' }}</h2>
    </div>

    <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" class="max-w-xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        @csrf
        @if($user->exists)
            @method('PUT')
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-700"><ul class="list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <label class="mb-4 block text-sm font-medium">Nama
            <input name="name" value="{{ old('name', $user->name) }}" class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5" required>
        </label>
        <label class="mb-4 block text-sm font-medium">Email
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5" required>
        </label>
        <label class="mb-4 block text-sm font-medium">Role
            <select name="role" class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5" required>
                <option value="user" @selected(old('role', $user->role ?: 'user') === 'user')>User</option>
                <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
            </select>
        </label>
        <p class="mb-3 text-sm font-semibold text-slate-700">{{ $user->exists ? 'Ganti password (opsional)' : 'Password' }}</p>
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block text-sm font-medium">Password
                <input type="password" name="password" class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5" @unless($user->exists) required @endunless>
            </label>
            <label class="block text-sm font-medium">Konfirmasi password
                <input type="password" name="password_confirmation" class="mt-1.5 w-full rounded-lg border-slate-300 p-2.5" @unless($user->exists) required @endunless>
            </label>
        </div>
        @if($user->exists)<p class="mt-2 text-xs text-slate-500">Kosongkan password jika tidak ingin mengubahnya.</p>@endif
        <div class="mt-6"><button class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-700">{{ $user->exists ? 'Simpan Perubahan' : 'Simpan User' }}</button><a href="{{ route('users.index') }}" class="ml-3 text-sm text-slate-600">Batal</a></div>
    </form>
@endsection
