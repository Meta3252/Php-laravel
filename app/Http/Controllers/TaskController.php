<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->filled(['start_date', 'end_date'])) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('startTime', [$startDate, $endDate]);
        }

        $tasks = $query->orderBy('startTime')->get();

        $summary = null;
        if ($request->filled('month')) {
            try {
                $startOfMonth = Carbon::createFromFormat('Y-m', $request->month)->startOfMonth();
                $endOfMonth = $startOfMonth->copy()->endOfMonth();

                $allowedStatuses = ['ดำเนินการ', 'เสร็จสิ้น', 'ยกเลิก'];

                $summary = Task::whereBetween('startTime', [$startOfMonth, $endOfMonth])
                    ->whereIn('status', $allowedStatuses)
                    ->select('status', DB::raw('COUNT(*) as count'))
                    ->groupBy('status')
                    ->pluck('count', 'status')
                    ->toArray();

                foreach ($allowedStatuses as $status) {
                    if (!isset($summary[$status])) {
                        $summary[$status] = 0;
                    }
                }
            } catch (\Exception $e) {
                $summary = null;
            }
        }

        return view('tasks.index', compact('tasks', 'summary'));
    }



    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'startTime' => 'required|date',
            'endTime' => 'required|date|after_or_equal:startTime',
            'status' => 'required',
        ]);

        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'type' => 'required',
            'name' => 'required',
            'startTime' => 'required|date',
            'endTime' => 'required|date|after_or_equal:startTime',
            'status' => 'required',
        ]);

        $task = Task::findOrFail($id);
        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }

    public function destroy($id)
    {
        Task::destroy($id);
        return redirect()->route('tasks.index')->with('success', 'ลบข้อมูลสำเร็จ');
    }
}
