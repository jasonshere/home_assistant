@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
        <h4 class="card-title">Temperature</h4>
        <canvas id="lineChart" style="height:250px"></canvas>
    </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
   $(function() {
    /* ChartJS
    * -------
    * Data and config for chartjs
    */
    'use strict';
    var d;
    $.getJSON('/temperature.json', function(res){
        if(res.code == 1) {
            d = res.data['Melbourne-RMIT']
            var data = {
                labels: d.labels,
                datasets: [{
                    label: 'Melbourne-RMIT',
                    data: d.data,
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                    ],
                    borderWidth: 1
                }]
            };
        
            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                legend: {
                    display: false
                },
                elements: {
                    point: {
                        radius: 0
                    }
                }
            };
        
            if ($("#lineChart").length) {
                var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
                var lineChart = new Chart(lineChartCanvas, {
                    type: 'line',
                    data: data,
                    options: options
                });
            }
        }
    });   
   });
    
</script>
@endpush