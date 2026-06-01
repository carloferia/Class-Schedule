<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    private array $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    private array $statuses = ['Scheduled', 'Rescheduled', 'Teacher Absent', 'Cancelled'];

    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Expense::where('user_id', $userId)->whereNotNull('day_of_week');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('description', 'like', "%$s%");
        }

        if ($request->filled('day')) {
            $query->where('day_of_week', $request->day);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dayOrder = "CASE day_of_week WHEN 'Monday' THEN 1 WHEN 'Tuesday' THEN 2 WHEN 'Wednesday' THEN 3 WHEN 'Thursday' THEN 4 WHEN 'Friday' THEN 5 WHEN 'Saturday' THEN 6 ELSE 7 END";
        $expenses = $query->orderByRaw($dayOrder)->orderBy('start_time')->paginate(10)->withQueryString();

        $totalAmount = Expense::where('user_id', $userId)->whereNotNull('day_of_week')->count();
        $thisMonthAmount = Expense::where('user_id', $userId)->whereNotNull('day_of_week')->distinct('teacher')->count('teacher');

        $categories = $this->days;
        $statuses = $this->statuses;

        return view('expenses.index', compact('expenses', 'totalAmount', 'thisMonthAmount', 'categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'in:' . implode(',', $this->days)],
            'room'        => ['required', 'string', 'max:50'],
            'section'     => ['required', 'string', 'max:50'],
            'status'      => ['required', 'in:' . implode(',', $this->statuses)],
            'start_time'  => ['required', 'date_format:H:i'],
            'end_time'    => ['required', 'date_format:H:i', 'after:start_time'],
            'teacher'     => ['nullable', 'string', 'max:255'],
            'notes'       => ['nullable', 'string', 'max:500'],
        ]);

        Expense::create([
            'user_id'     => Auth::id(),
            'description' => $request->description,
            'category'    => $request->day_of_week,
            'day_of_week' => $request->day_of_week,
            'room'        => $request->room,
            'section'     => $request->section,
            'status'      => $request->status,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'teacher'     => $request->teacher ?: Auth::user()->name,
            'amount'      => 1,
            'date'        => now()->toDateString(),
            'notes'       => $request->notes,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Subject "' . $request->description . '" added to the schedule.');
    }

    public function update(Request $request, Expense $expense)
    {
        // Ensure the expense belongs to the logged-in user
        abort_if($expense->user_id !== Auth::id(), 403);

        $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'in:' . implode(',', $this->days)],
            'room'        => ['required', 'string', 'max:50'],
            'section'     => ['required', 'string', 'max:50'],
            'status'      => ['required', 'in:' . implode(',', $this->statuses)],
            'start_time'  => ['required', 'date_format:H:i'],
            'end_time'    => ['required', 'date_format:H:i', 'after:start_time'],
            'teacher'     => ['nullable', 'string', 'max:255'],
            'notes'       => ['nullable', 'string', 'max:500'],
        ]);

        $expense->update([
            'description' => $request->description,
            'category'    => $request->day_of_week,
            'day_of_week' => $request->day_of_week,
            'room'        => $request->room,
            'section'     => $request->section,
            'status'      => $request->status,
            'start_time'  => $request->start_time,
            'end_time'    => $request->end_time,
            'teacher'     => $request->teacher ?: Auth::user()->name,
            'notes'       => $request->notes,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        abort_if($expense->user_id !== Auth::id(), 403);

        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', 'Schedule entry deleted.');
    }
}
