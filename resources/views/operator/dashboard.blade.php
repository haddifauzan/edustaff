@extends('operator.layout.master')
@section('title', ' - Operator Dashboard')

@section('content')
<h1>DASHBOARD OPERATOR</h1>

<div class="row">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Grafik Pengajuan Perubahan</h4>
      </div>
      <div class="card-body">
        <div id="chart-pengajuan"></div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Grafik Pengajuan Prestasi</h4>
      </div>
      <div class="card-body">
        <div id="chart-prestasi"></div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Grafik Pengajuan Perubahan
    var pengajuanOptions = {
      series: [{
        name: 'Jumlah Pengajuan',
        data: [10, 15, 7, 12, 5, 20, 8, 18, 22, 9, 24, 21]
      }],
      chart: {
        type: 'bar',
        height: 350
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '50%',
          endingShape: 'rounded'
        },
      },
      dataLabels: {
        enabled: false
      },
      xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
      },
      colors: ['#36a2eb'],
      title: {
        text: 'Pengajuan Perubahan',
        align: 'center'
      }
    };

    var pengajuanChart = new ApexCharts(document.querySelector("#chart-pengajuan"), pengajuanOptions);
    pengajuanChart.render();

    // Grafik Pengajuan Prestasi
    var prestasiOptions = {
      series: [44, 55, 13, 43],
      chart: {
        type: 'donut',
        height: 350
      },
      labels: ['Prestasi 1', 'Prestasi 2', 'Prestasi 3', 'Prestasi 4'],
      title: {
        text: 'Pengajuan Prestasi',
        align: 'center'
      },
      legend: {
        position: 'bottom'
      },
      colors: ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728']
    };

    var prestasiChart = new ApexCharts(document.querySelector("#chart-prestasi"), prestasiOptions);
    prestasiChart.render();
  });
</script>

{{-- SweetAlert --}}
@include('operator.layout.sweetalert')
@endsection
