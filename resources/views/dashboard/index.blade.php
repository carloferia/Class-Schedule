@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="mb-1">Dashboard</h4>
        <div class="text-muted">Welcome, {{ Auth::user()->name }}.</div>
    </div>
    <a href="{{ route('expenses.index') }}" class="btn-main">
        <i class="bi bi-calendar-plus"></i> Manage Schedules
    </a>
</div>

<div class="row g-3 mb-3">
    <div class="col-6 col-lg-3">
        <div class="card-simple p-3">
            <div class="text-muted small">Total Schedules</div>
            <div class="fs-4 fw-bold">{{ $totalSchedules }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-simple p-3">
            <div class="text-muted small">Scheduled</div>
            <div class="fs-4 fw-bold text-success">{{ $scheduledCount }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-simple p-3">
            <div class="text-muted small">Rescheduled</div>
            <div class="fs-4 fw-bold text-warning">{{ $rescheduledCount }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-simple p-3">
            <div class="text-muted small">Users</div>
            <div class="fs-4 fw-bold text-primary">{{ $totalUsers }}</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-5">
        <div class="card-simple p-3">
            <div class="card-header-simple px-0 pt-0">Status Report</div>
            <canvas id="statusChart" height="220"></canvas>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card-simple p-3">
            <div class="card-header-simple px-0 pt-0">Schedule Summary</div>
            <canvas id="summaryChart" height="220"></canvas>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card-simple">
            <div class="card-header-simple">Today - {{ $todayName }}</div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Section</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todaySchedules as $schedule)
                            <tr>
                                <td>{{ $schedule->description }}</td>
                                <td>{{ $schedule->section }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($schedule->start_time)->format('g:i A') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">No classes today.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card-simple">
            <div class="card-header-simple">
                <span>Upcoming Schedule</span>
                <a href="{{ route('expenses.index') }}" class="btn-light-line btn-sm">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Section</th>
                            <th>Room</th>
                            <th>Day</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nextSchedules as $schedule)
                            @php $statusClass = 'status-' . str_replace(' ', '-', strtolower($schedule->status ?? 'Scheduled')); @endphp
                            <tr>
                                <td>{{ $schedule->description }}</td>
                                <td>{{ $schedule->section }}</td>
                                <td>{{ $schedule->room }}</td>
                                <td>{{ $schedule->day_of_week }}</td>
                                <td><span class="badge-status {{ $statusClass }}">{{ $schedule->status ?? 'Scheduled' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No schedules yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const statusData = [{{ $scheduledCount }}, {{ $rescheduledCount }}, {{ $absentCount }}];

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Scheduled', 'Rescheduled', 'Teacher Absent'],
        datasets: [{
            data: statusData,
            backgroundColor: ['#198754', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});

new Chart(document.getElementById('summaryChart'), {
    type: 'bar',
    data: {
        labels: ['Users', 'Total Schedules', 'Scheduled', 'Rescheduled'],
        datasets: [{
            label: 'Records',
            data: [{{ $totalUsers }}, {{ $totalSchedules }}, {{ $scheduledCount }}, {{ $rescheduledCount }}],
            backgroundColor: ['#0d6efd', '#6f42c1', '#198754', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
