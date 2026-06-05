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

<div class="row g-3 dashboard-charts">
    <div class="col-12 col-lg-5">
        <div class="card-simple p-3">
            <div class="card-header-simple px-0 pt-0">Status Report</div>
            <div class="chart-box">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-7">
        <div class="card-simple p-3">
            <div class="card-header-simple px-0 pt-0">Schedule Summary</div>
            <div class="chart-box">
                <canvas id="summaryChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <div class="card-simple p-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="fw-bold">Upcoming Schedule</div>
            <a href="{{ route('expenses.index') }}" class="btn btn-outline-primary btn-sm">View All</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .dashboard-charts .card-simple {
        min-height: 270px;
    }

    .chart-box {
        height: 215px;
        position: relative;
    }

    @media (max-height: 850px) {
        .content {
            padding-top: 18px;
            padding-bottom: 12px;
        }

        .dashboard-charts .card-simple {
            min-height: 235px;
        }

        .chart-box {
            height: 180px;
        }
    }
</style>
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
        maintainAspectRatio: false,
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
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
