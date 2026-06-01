@extends('layouts.app')
@section('title', 'Schedules')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Class Schedules</h4>
        <div class="text-muted">Manage your sections, rooms, time, and attendance status.</div>
    </div>
    <button class="btn-main" data-bs-toggle="modal" data-bs-target="#scheduleModal" onclick="openAddSchedule()">
        <i class="bi bi-plus-lg"></i> Add Schedule
    </button>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-md-3">
        <div class="card-simple p-3">
            <div class="text-muted small">Total Schedules</div>
            <div class="fs-4 fw-bold">{{ $expenses->total() }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card-simple p-3">
            <div class="text-muted small">Teachers</div>
            <div class="fs-4 fw-bold">{{ $thisMonthAmount }}</div>
        </div>
    </div>
</div>

<div class="card-simple">
    <div class="card-header-simple">
        <span>Schedule List</span>
        <form method="GET" action="{{ route('expenses.index') }}" class="d-flex gap-2 flex-wrap">
            <select name="day" class="form-select form-select-sm" style="width:130px;">
                <option value="">All Days</option>
                @foreach($categories as $day)
                    <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" style="width:150px;">
                <option value="">All Status</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ $status }}</option>
                @endforeach
            </select>
            <input type="text" name="search" class="form-control form-control-sm" style="width:180px;"
                   placeholder="Search subject" value="{{ request('search') }}">
            <button type="submit" class="btn-light-line btn-sm">Filter</button>
        </form>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Section</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Room</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($expenses as $schedule)
                    @php
                        $day = $schedule->day_of_week ?? $schedule->category;
                        $start = $schedule->start_time ? \Illuminate\Support\Carbon::parse($schedule->start_time)->format('g:i A') : 'TBA';
                        $end = $schedule->end_time ? \Illuminate\Support\Carbon::parse($schedule->end_time)->format('g:i A') : 'TBA';
                        $statusClass = 'status-' . str_replace(' ', '-', strtolower($schedule->status ?? 'Scheduled'));
                    @endphp
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $schedule->description }}</div>
                            <div class="small text-muted">{{ $schedule->teacher ?? Auth::user()->name }}</div>
                        </td>
                        <td>{{ $schedule->section ?? 'BSIT 2-F' }}</td>
                        <td>{{ $day }}</td>
                        <td>{{ $start }} - {{ $end }}</td>
                        <td>{{ $schedule->room ?? 'Room 104' }}</td>
                        <td><span class="badge-status {{ $statusClass }}">{{ $schedule->status ?? 'Scheduled' }}</span></td>
                        <td class="text-end" style="white-space:nowrap;">
                            <button class="btn btn-sm btn-outline-success"
                                onclick="openEditSchedule(
                                    {{ $schedule->id }},
                                    '{{ addslashes($schedule->description) }}',
                                    '{{ $day }}',
                                    '{{ addslashes($schedule->section ?? '') }}',
                                    '{{ addslashes($schedule->room ?? '') }}',
                                    '{{ $schedule->start_time ? \Illuminate\Support\Carbon::parse($schedule->start_time)->format('H:i') : '' }}',
                                    '{{ $schedule->end_time ? \Illuminate\Support\Carbon::parse($schedule->end_time)->format('H:i') : '' }}',
                                    '{{ addslashes($schedule->status ?? 'Scheduled') }}',
                                    '{{ addslashes($schedule->teacher ?? Auth::user()->name) }}',
                                    '{{ addslashes($schedule->notes ?? '') }}'
                                )">
                                Edit
                            </button>
                            @if(($schedule->status ?? 'Scheduled') !== 'Cancelled')
                            <form method="POST" action="{{ route('expenses.update', $schedule->id) }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="description" value="{{ $schedule->description }}">
                                <input type="hidden" name="day_of_week" value="{{ $day }}">
                                <input type="hidden" name="section" value="{{ $schedule->section ?? '' }}">
                                <input type="hidden" name="room" value="{{ $schedule->room ?? '' }}">
                                <input type="hidden" name="start_time" value="{{ $schedule->start_time ? \Illuminate\Support\Carbon::parse($schedule->start_time)->format('H:i') : '' }}">
                                <input type="hidden" name="end_time" value="{{ $schedule->end_time ? \Illuminate\Support\Carbon::parse($schedule->end_time)->format('H:i') : '' }}">
                                <input type="hidden" name="status" value="Cancelled">
                                <input type="hidden" name="teacher" value="{{ $schedule->teacher ?? Auth::user()->name }}">
                                <input type="hidden" name="notes" value="{{ $schedule->notes ?? '' }}">
                                <button type="submit" class="btn btn-sm btn-outline-warning"
                                    onclick="return confirm('Mark this schedule as cancelled?')">
                                    Cancel
                                </button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('expenses.destroy', $schedule->id) }}" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Delete this schedule permanently?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No schedules yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($expenses->hasPages())
        <div class="p-3 border-top d-flex justify-content-end">
            {{ $expenses->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="scheduleForm">
                @csrf
                <input type="hidden" name="_method" id="scheduleMethod" value="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleTitle">Add Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Rizal" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label">Section</label>
                            <input type="text" name="section" id="section" class="form-control" placeholder="BSIT 2-F" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Room</label>
                            <input type="text" name="room" id="room" class="form-control" placeholder="Room 104" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Day</label>
                            <select name="day_of_week" id="day_of_week" class="form-select" required>
                                @foreach($categories as $day)
                                    <option value="{{ $day }}">{{ $day }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Start</label>
                            <input type="time" name="start_time" id="start_time" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">End</label>
                            <input type="time" name="end_time" id="end_time" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Teacher</label>
                        <input type="text" name="teacher" id="teacher" class="form-control" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Note</label>
                        <textarea name="notes" id="notes" class="form-control" rows="2" placeholder="Optional note for reschedule or absence"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const modal = new bootstrap.Modal(document.getElementById('scheduleModal'));

function openAddSchedule() {
    document.getElementById('scheduleTitle').textContent = 'Add Schedule';
    document.getElementById('scheduleForm').action = "{{ route('expenses.store') }}";
    document.getElementById('scheduleMethod').value = 'POST';
    document.getElementById('scheduleForm').reset();
    document.getElementById('teacher').value = "{{ Auth::user()->name }}";
}

function openEditSchedule(id, subject, day, section, room, start, end, status, teacher, notes) {
    document.getElementById('scheduleTitle').textContent = 'Edit Schedule';
    document.getElementById('scheduleForm').action = `/expenses/${id}`;
    document.getElementById('scheduleMethod').value = 'PUT';
    document.getElementById('description').value = subject;
    document.getElementById('day_of_week').value = day;
    document.getElementById('section').value = section;
    document.getElementById('room').value = room;
    document.getElementById('start_time').value = start;
    document.getElementById('end_time').value = end;
    document.getElementById('status').value = status;
    document.getElementById('teacher').value = teacher;
    document.getElementById('notes').value = notes;
    modal.show();
}
</script>
@endpush
