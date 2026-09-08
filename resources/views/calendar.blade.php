@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-4"><div><p class="text-sm font-medium text-slate-500">OPERASIONAL</p><h2 class="text-2xl font-bold tracking-tight">Kalender Jadwal</h2></div>@if(auth()->user()->isAdmin())<a href="{{ route('schedules.create') }}" class="rounded-lg bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-700">+ Buat Jadwal</a>@endif</div>
<div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:p-6"><div class="mb-6 flex flex-col gap-3 sm:flex-row"><select id="division" class="rounded-lg border-slate-300 px-3 py-2 text-sm focus:border-slate-800 focus:ring-slate-800"><option value="">Semua Divisi</option>@foreach(\App\Models\Division::where('is_active',true)->get() as $division)<option value="{{ $division->id }}">{{ $division->name }}</option>@endforeach</select><input id="search" class="rounded-lg border-slate-300 px-3 py-2 text-sm focus:border-slate-800 focus:ring-slate-800" placeholder="Cari judul, lokasi, PIC..." type="search"></div><div id="calendar"></div></div>

<div id="schedule-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/50 p-4" role="dialog" aria-modal="true" aria-labelledby="modal-title"><div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl"><div class="flex items-start justify-between border-b border-slate-100 p-5"><div><p id="modal-division" class="text-xs font-bold uppercase tracking-wider text-slate-500"></p><h3 id="modal-title" class="mt-1 text-xl font-bold"></h3></div><button id="close-modal" type="button" class="grid h-9 w-9 place-items-center rounded-full text-xl text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Tutup">×</button></div><dl id="modal-detail" class="grid gap-3 p-5 text-sm"></dl><div class="flex justify-end gap-3 border-t border-slate-100 p-5"><button id="close-modal-footer" type="button" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Tutup</button></div></div></div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const division = document.getElementById('division'), search = document.getElementById('search'), modal = document.getElementById('schedule-modal');
    const closeModal = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); };
    document.getElementById('close-modal').addEventListener('click', closeModal); document.getElementById('close-modal-footer').addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => { if (event.target === modal) closeModal(); }); document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeModal(); });
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth', locale: 'id', firstDay: 1, height: 'auto', expandRows: false,
        headerToolbar: { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
        buttonText: { today: 'Hari ini', month: 'Bulan', week: 'Minggu', day: 'Hari' },
        slotMinTime: '06:00:00', slotMaxTime: '23:30:00', nowIndicator: true,
        eventTimeFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        events: (info, success, failure) => fetch(`{{ route('events') }}?division_id=${division.value}&search=${encodeURIComponent(search.value)}`).then(r => r.json()).then(success).catch(failure),
        eventClick: (info) => fetch(`/schedule-details/${info.event.id}`).then(r => r.json()).then(schedule => {
            document.getElementById('modal-division').textContent = schedule.division; document.getElementById('modal-title').textContent = schedule.title;
            const rows = [['Tanggal', schedule.date], ['Waktu', `${schedule.start_time} – ${schedule.end_time}`], ['Lokasi', schedule.location || '—'], ['PIC', schedule.pic || '—'], ['Status', schedule.status], ['Keterangan', schedule.description || '—'], ['Dibuat oleh', schedule.creator]];
            const detail = document.getElementById('modal-detail'); detail.replaceChildren(); rows.forEach(([label, value]) => { const row=document.createElement('div'), term=document.createElement('dt'), desc=document.createElement('dd'); row.className='grid grid-cols-3 gap-3'; term.className='font-semibold text-slate-500'; term.textContent=label; desc.className='col-span-2 text-slate-800'; desc.textContent=value; row.append(term,desc); detail.append(row); }); modal.classList.remove('hidden'); modal.classList.add('flex');
        })
    });
    calendar.render(); division.addEventListener('change', () => calendar.refetchEvents()); let timer; search.addEventListener('input', () => { clearTimeout(timer); timer=setTimeout(() => calendar.refetchEvents(), 250); });
});
</script>
@endsection
