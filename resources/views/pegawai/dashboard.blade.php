@extends('pegawai.layout.master')
@section('title', ' - Pegawai Dashboard')

<style>
    .stats-card {
        transition: transform 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }

    .progress-bar {
        transition: width 1s ease-in-out;
    }

    .chart-container {
        min-height: 350px;
    }

    .latest-item {
        transition: background-color 0.3s ease;
    }

    .latest-item:hover {
        background-color: rgba(0,0,0,0.02);
    }
</style>

@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard Pegawai EduStaff</h1>
                    <p class="text-muted mb-0">Welcome back, {{ auth()->user()->nama_user }}</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-muted">
                        <i class="far fa-calendar-alt"></i> {{ now()->format('l, d F Y') }}
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    @include('pegawai.layout.sweetalert')

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Pegawai Card -->
        <div class="col-xl-2 col-md-4">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-primary text-white rounded-circle p-3">
                                <i class="fas fa-users fa-fw"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Pegawai</h6>
                            <h4 class="mb-0">{{ number_format($total_pegawai) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($pegawai_change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $pegawai_change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($pegawai_change) }}%
                            </span>
                        @endif
                        <span class="text-muted ms-2">dari minggu lalu</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Operator Card -->
        <div class="col-xl-2 col-md-4">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-secondary text-white rounded-circle p-3">
                                <i class="fas fa-user-tie fa-fw"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Operator</h6>
                            <h4 class="mb-0">{{ number_format($total_operator) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($operator_change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $operator_change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($operator_change) }}%
                            </span>
                        @endif
                        <span class="text-muted ms-2">dari minggu lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- User Card -->
        <div class="col-xl-2 col-md-4">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-success text-white rounded-circle p-3">
                                <i class="fas fa-user fa-fw"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total User</h6>
                            <h4 class="mb-0">{{ number_format($total_user) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($user_change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $user_change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($user_change) }}%
                            </span>
                        @endif
                        <span class="text-muted ms-2">dari minggu lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Prestasi Card -->
        <div class="col-xl-2 col-md-4">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-info text-white rounded-circle p-3">
                                <i class="fas fa-trophy fa-fw"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Prestasi</h6>
                            <h4 class="mb-0">{{ number_format($total_prestasi) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($prestasi_change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $prestasi_change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($prestasi_change) }}%
                            </span>
                        @endif
                        <span class="text-muted ms-2">dari minggu lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Jabatan Card -->
        <div class="col-xl-2 col-md-4">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-danger text-white rounded-circle p-3">
                                <i class="fas fa-briefcase fa-fw"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Jabatan</h6>
                            <h4 class="mb-0">{{ number_format($total_jabatan) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($jabatan_change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $jabatan_change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($jabatan_change) }}%
                            </span>
                        @endif
                        <span class="text-muted ms-2">dari minggu lalu</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- TugasTambahan Card -->
        <div class="col-xl-2 col-md-4">
            <div class="card stats-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0">
                            <div class="stats-icon bg-warning text-white rounded-circle p-3">
                                <i class="fas fa-book fa-fw"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Tugas</h6>
                            <h4 class="mb-0">{{ number_format($total_tugas) }}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        @if($tugas_change > 0)
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> {{ $tugas_change }}%
                            </span>
                        @else
                            <span class="text-danger">
                                <i class="fas fa-arrow-down"></i> {{ abs($tugas_change) }}%
                            </span>
                        @endif
                        <span class="text-muted ms-2">dari minggu lalu</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar cards for other stats -->
        <!-- ... -->
    </div>

    <!-- Main Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Employee Growth Chart -->
        <div class="col-xl-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Penambahan Pegawai</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div id="employeeGrowthChart" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Status Distribution Chart -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Status Kepegawaian</h5>
                </div>
                <div class="card-body">
                    <div id="statusPegawaiDistributionChart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Gender Distribution -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Pengelompokan Jenis Kelamin</h5>
                </div>
                <div class="card-body">
                    <div id="genderChart" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Age Distribution -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Pengelompokan Usia</h5>
                </div>
                <div class="card-body">
                    <div id="ageChart" class="chart-container"></div>
                </div>
            </div>
        </div>

        <!-- Education Distribution -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Tingkat Pendidikan</h5>
                </div>
                <div class="card-body">
                    <div id="educationChart" class="chart-container"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Data Row -->
    <div class="row g-4">
        <!-- Latest Employees -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pegawai Terbaru</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($pegawai_terbaru as $pegawai)
                        <div class="list-group-item latest-item">
                            <div class="d-flex align-items-center">
                                <img src="{{ $pegawai->foto_pegawai ? asset('foto_profil/'.$pegawai->foto_pegawai) : asset('images/foto_profil/default.png') }}" 
                                     alt="{{ $pegawai->nama_pegawai }}" 
                                     class="w-px-40 h-auto rounded-circle me-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $pegawai->nama_pegawai }}</h6>
                                    <small class="text-muted">
                                        {{ $pegawai->jabatan->nama_jabatan ?? 'No Position' }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted d-block">{{ $pegawai->created_at->diffForHumans() }}</small>
                                    <span class="badge bg-{{ $pegawai->status_kepegawaian == 'ASN' ? 'success' : 'warning' }}">
                                        {{ $pegawai->status_kepegawaian }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Achievements -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Prestasi Terbaru</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($prestasi_terbaru as $prestasi)
                        <div class="list-group-item latest-item">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="achievement-icon bg-warning-soft rounded-circle p-2">
                                        <i class="fas fa-trophy text-warning"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">{{ $prestasi->nama_prestasi }}</h6>
                                    <small class="text-muted">
                                        {{ $prestasi->pegawai->nama_pegawai }}
                                    </small>
                                </div>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($prestasi->tgl_dicapai)->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Positions -->
        <div class="col-xl-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Jabatan Terbaru</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($jabatan_terbaru as $jabatan)
                        <div class="list-group-item latest-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $jabatan->nama_jabatan }}</h6>
                                    <small class="text-muted">
                                        {{ $jabatan->pegawai_count }} pegawai
                                    </small>
                                </div>
                                <span class="badge bg-info">{{ $jabatan->golongan }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Department Analysis -->
    <div class="row g-4 mt-1">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Analisis Jabatan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>Total Pegawai</th>
                                    <th>Rata-rata Usia</th>
                                    <th>Rasio Gender (Pria/Wanita)</th>
                                    <th>Tingkat Jabatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chart_jabatan_distribution as $dept)
                                <tr>
                                    <td>{{ $dept['name'] }}</td>
                                    
                                    <!-- Total Pegawai -->
                                    <td>
                                        {{ $dept['total'] }}
                                        <small class="text-muted">
                                            ({{ number_format(($dept['total'] / $total_pegawai) * 100, 1) }}%)
                                        </small>
                                    </td>
                                    
                                    <td>
                                        {{ isset($dept['average_age']) ? round($dept['average_age']) . ' tahun' : '-' }}
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ isset($dept['gender_ratio']['male']) ? number_format($dept['gender_ratio']['male'], 1) : 0 }}%;" aria-valuenow="{{ isset($dept['gender_ratio']['male']) ? number_format($dept['gender_ratio']['male'], 1) : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ isset($dept['gender_ratio']['male']) ? number_format($dept['gender_ratio']['male'], 1) . '%' : '0%' }} L
                                            </div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ isset($dept['gender_ratio']['female']) ? number_format($dept['gender_ratio']['female'], 1) : 0 }}%;" aria-valuenow="{{ isset($dept['gender_ratio']['female']) ? number_format($dept['gender_ratio']['female'], 1) : 0 }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ isset($dept['gender_ratio']['female']) ? number_format($dept['gender_ratio']['female'], 1) . '%' : '0%' }} P
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <!-- Status Jabatan -->
                                    <td>
                                        @php
                                            $level = ['5' => 'bg-primary', '4' => 'bg-info', '3' => 'bg-success', '2' => 'bg-warning', '1' => 'bg-danger'];
                                            $golongan = ['V' => 'bg-primary', 'IV' => 'bg-info', 'III' => 'bg-success', 'II' => 'bg-warning', 'I' => 'bg-danger'];
                                        @endphp
                                        @if(isset($dept['level']))
                                            <span class="badge {{ $level[$dept['level']] }}">Level {{ $dept['level'] }}</span>
                                        @endif
                                        |
                                        @if(isset($dept['golongan']))
                                            <span class="badge {{ $golongan[$dept['golongan']] }}">{{ $dept['golongan'] }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Employee Growth Chart
    var employeeGrowthOptions = {
        series: [{
            name: 'Total Pegawai',
            data: {!! json_encode(array_values($chart_weekly_pegawai)) !!}
        }],
        chart: {
            type: 'area',
            height: 300,
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'smooth',
            width: 2
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3
            }
        },
        xaxis: {
            categories: {!! json_encode(array_keys($chart_weekly_pegawai)) !!},
            labels: {
                formatter: function(value) {
                    return value;
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return Math.round(value);
                }
            }
        },
        colors: ['#4e73df']
    };

    var employeeGrowthChart = new ApexCharts(document.querySelector("#employeeGrowthChart"), employeeGrowthOptions);
    employeeGrowthChart.render();

    // Status Pegawai Distribution Chart
    var statusPegawaiDistributionOptions = {
        series: {!! json_encode($chart_status_pegawai['data']->values()) !!},
        chart: {
            type: 'donut',
            height: 350
        },
        labels: {!! json_encode($chart_status_pegawai['labels']->values()) !!},
        colors: ['#00cc41', '#ead800', '#36b9cc', '#f6c23e'],
        legend: { position: 'bottom' },
        stroke: {
            width: 5,
            colors: '#fff',
        },
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return parseInt(val) + '%';
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            offsetY: -5,
                            fontSize: '1rem',
                            fontFamily: 'Public Sans',
                            color: '#004ba0',
                            fontWeight: 'bold',
                        },
                        value: {
                            show: true,
                            fontSize: '1.8rem',
                            fontFamily: 'Public Sans',
                            color: '#004ba0',
                            fontWeight: 'bold',
                            offsetY: 16,
                            formatter: function (val) {
                                return parseInt(val);
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '1rem',
                            fontFamily: 'Public Sans',
                            color: '#004ba0',
                            fontWeight: 'bold',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                }, 0);
                            }
                        }
                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 200 },
                legend: { position: 'bottom' }
            }
        }]
    };

    // Render Chart
    var statusPegawaiDistributionChart = new ApexCharts(
        document.querySelector("#statusPegawaiDistributionChart"), 
        statusPegawaiDistributionOptions
    );
    statusPegawaiDistributionChart.render();


    // Gender Distribution Chart
    var genderChartOptions = {
        series: {!! json_encode($chart_jenis_kelamin['data']->values()) !!},
        chart: {
            type: 'donut',
            height: 350
        },
        colors: ['#0077fe', '#fe008f'],
        labels: {!! json_encode($chart_jenis_kelamin['labels']->values()) !!},
        fill: { opacity: 0.8 },
        stroke: { width: 1 },
        legend: { position: 'bottom' },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            show: true,
                            offsetY: -5,
                            fontSize: '1rem',
                            fontFamily: 'Public Sans',
                            color: '#004ba0',
                            fontWeight: 'bold',
                        },
                        value: {
                            show: true,
                            fontSize: '1.8rem',
                            fontFamily: 'Public Sans',
                            color: '#004ba0',
                            fontWeight: 'bold',
                            offsetY: 16,
                            formatter: function (val) {
                                return parseInt(val);
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '1rem',
                            fontFamily: 'Public Sans',
                            color: '#004ba0',
                            fontWeight: 'bold',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => {
                                    return a + b
                                }, 0);
                            }
                        }
                    }
                }
            }
        },
    };

    var genderChart = new ApexCharts(document.querySelector("#genderChart"), genderChartOptions);
    genderChart.render();

    // Age Distribution Chart
    var ageChartOptions = {
        series: [{
            name: 'Pegawai',
            data: {!! json_encode(array_values($chart_age_distribution)) !!}
        }],
        chart: {
            type: 'bar',
            height: 300
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                horizontal: true,
            }
        },
        dataLabels: { enabled: true },
        xaxis: {
            categories: {!! json_encode(array_keys($chart_age_distribution)) !!},
        },
        colors: ['#36b9cc']
    };

    var ageChart = new ApexCharts(document.querySelector("#ageChart"), ageChartOptions);
    ageChart.render();

    // Education Distribution Chart
    var educationChartOptions = {
        series: {!! json_encode(array_values($chart_education_distribution)) !!},
        chart: {
            type: 'pie',
            height: 350,
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        labels: {!! json_encode(array_keys($chart_education_distribution)) !!},
        colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
        legend: { position: 'bottom' },
        stroke: { width: 1 },
        responsive: [
            {
                breakpoint: 500,
                options: {
                    chart: { width: 250 },
                    legend: { position: 'bottom' }
                }
            }
        ]
    };
    var educationChart = new ApexCharts(document.querySelector("#educationChart"), educationChartOptions);
    educationChart.render();
});
</script>
