@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Statistik Kehadiran Bulan {{ now()->translatedFormat('F Y') }}</h4>

    <canvas id="attendanceChart" height="100"></canvas>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('attendanceChart').getContext('2d');

    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($data->keys()) !!},
            datasets: [{
                label: 'Jumlah Kehadiran',
                data: {!! json_encode($data->values()) !!},
                backgroundColor: [
                    '#4caf50', // hadir
                    '#ff9800', // izin
                    '#f44336', // alfa
                    '#2196f3', // sakit
                    '#9e9e9e'  // lainnya
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1
                }
            }
        }
    });
</script>
@endsection
