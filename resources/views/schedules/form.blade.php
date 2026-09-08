@extends('layouts.app')

@section('content')
    <h2 class="mb-5 text-2xl font-bold">{{ $schedule->exists ? 'Edit' : 'Buat' }} Jadwal</h2>

    <form method="POST" class="max-w-2xl rounded-xl bg-white p-6 shadow" action="{{ $schedule->exists ? route('schedules.update', $schedule) : route('schedules.store') }}">
        @csrf
        @if ($schedule->exists)
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label class="mb-3 block">Divisi
            <select name="division_id" class="mt-1 w-full rounded border p-2" required>
                @foreach ($divisions as $division)
                    <option value="{{ $division->id }}" @selected(old('division_id', $schedule->division_id) == $division->id)>{{ $division->name }}</option>
                @endforeach
            </select>
        </label>

        <label class="mb-3 block">Judul
            <input name="title" value="{{ old('title', $schedule->title) }}" class="mt-1 w-full rounded border p-2" required>
        </label>
        <label class="mb-3 block">Tanggal
            <input type="date" name="schedule_date" value="{{ old('schedule_date', $schedule->schedule_date?->format('Y-m-d')) }}" class="mt-1 w-full rounded border p-2" required>
        </label>
        <div class="grid gap-3 sm:grid-cols-2">
            <label class="mb-3 block">Jam mulai
                <input type="time" name="start_time" value="{{ substr(old('start_time', $schedule->start_time ?? ''), 0, 5) }}" class="mt-1 w-full rounded border p-2" required>
            </label>
            <label class="mb-3 block">Jam selesai
                <input type="time" name="end_time" value="{{ substr(old('end_time', $schedule->end_time ?? ''), 0, 5) }}" class="mt-1 w-full rounded border p-2" required>
            </label>
        </div>
        <label class="mb-3 block">Lokasi
            <input name="location" value="{{ old('location', $schedule->location) }}" class="mt-1 w-full rounded border p-2">
        </label>
        <label class="mb-3 block">PIC
            <input name="pic" value="{{ old('pic', $schedule->pic) }}" class="mt-1 w-full rounded border p-2">
        </label>
        <label class="mb-4 block">Status
            <select name="status" class="mt-1 w-full rounded border p-2" required>
                @foreach (['scheduled' => 'Scheduled', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $schedule->status ?: 'scheduled') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>
        <label class="mb-5 block">Keterangan
            <textarea name="description" rows="4" class="mt-1 w-full rounded border p-2">{{ old('description', $schedule->description) }}</textarea>
        </label>
        <button class="rounded bg-slate-900 px-4 py-2 text-white">Simpan Jadwal</button>
        <a href="{{ route('schedules.index') }}" class="ml-3 text-slate-600">Batal</a>
    </form>
@endsection
