<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Division;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function events(Request $request)
    {
        $schedules = Schedule::query()->with('division')
            ->when($request->integer('division_id'), fn ($query, $id) => $query->where('division_id', $id))
            ->when($request->string('search')->trim()->value(), function ($query, $search) {
                $query->where(fn ($item) => $item->where('title', 'like', "%{$search}%")->orWhere('location', 'like', "%{$search}%")->orWhere('pic', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"));
            })->get();

        return $schedules->map(fn (Schedule $schedule) => [
            'id' => $schedule->id, 'title' => $schedule->title,
            'start' => $schedule->schedule_date->format('Y-m-d').'T'.$schedule->start_time,
            'end' => $schedule->schedule_date->format('Y-m-d').'T'.$schedule->end_time,
            'backgroundColor' => $schedule->division->color, 'borderColor' => $schedule->division->color,
            'textColor' => in_array($schedule->division->code, ['SEC', 'CR']) ? '#1f2937' : '#ffffff',
        ]);
    }

    public function index() { return view('schedules.index', ['schedules' => Schedule::with('division')->latest('schedule_date')->paginate(15)]); }
    public function create() { return view('schedules.form', ['schedule' => new Schedule, 'divisions' => Division::where('is_active', true)->get()]); }
    public function store(StoreScheduleRequest $request) { $this->authorize('create', Schedule::class); Schedule::create($request->validated() + ['created_by' => $request->user()->id]); return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dibuat.'); }
    public function edit(Schedule $schedule) { $this->authorize('update', $schedule); return view('schedules.form', ['schedule' => $schedule, 'divisions' => Division::where('is_active', true)->get()]); }
    public function update(UpdateScheduleRequest $request, Schedule $schedule) { $this->authorize('update', $schedule); $schedule->update($request->validated()); return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.'); }
    public function destroy(Schedule $schedule) { $this->authorize('delete', $schedule); $schedule->delete(); return back()->with('success', 'Jadwal berhasil dihapus.'); }
    public function show(Schedule $schedule) { $this->authorize('view', $schedule); $schedule->load('division', 'creator'); return response()->json(['id'=>$schedule->id,'division'=>$schedule->division->name,'title'=>$schedule->title,'date'=>$schedule->schedule_date->translatedFormat('d F Y'),'start_time'=>substr($schedule->start_time,0,5),'end_time'=>substr($schedule->end_time,0,5),'location'=>$schedule->location,'pic'=>$schedule->pic,'status'=>$schedule->status,'description'=>$schedule->description,'creator'=>$schedule->creator->name]); }
}
