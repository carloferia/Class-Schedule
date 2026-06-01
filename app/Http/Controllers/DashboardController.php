<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $base = Expense::where('user_id', $userId)->whereNotNull('day_of_week');

        $totalSchedules = (clone $base)->count();
        $scheduledCount = (clone $base)->where('status', 'Scheduled')->count();
        $rescheduledCount = (clone $base)->where('status', 'Rescheduled')->count();
        $absentCount = (clone $base)->where('status', 'Teacher Absent')->count();

        $todayName = now()->format('l');
        $todaySchedules = (clone $base)
            ->where('day_of_week', $todayName)
            ->orderBy('start_time')
            ->get();

        $nextSchedules = (clone $base)
            ->orderByRaw("CASE day_of_week WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 ELSE 7 END")
            ->orderBy('start_time')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
            'totalSchedules',
            'scheduledCount',
            'rescheduledCount',
            'absentCount',
            'todayName',
            'todaySchedules',
            'nextSchedules',
        ));
    }
}
