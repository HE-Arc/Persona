@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="">My Profile</span>

                    <a href="{{ route('profile-edit', Auth::user()->alias) }}" class="pull-right"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>

                </div>
                <div class="panel-body">
                    @include('profile-common')
                </div>
                <div class="panel-body" id="donutchart"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var nb_friends_personality = {!! json_encode($nb_friends_personality) !!};

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Personality');
        data.addColumn('number', 'number of friends');

        for (var key in nb_friends_personality){
            data.addRows([[key, nb_friends_personality[key]]]);
        }

        var options = {
            title: 'Number of friends by personality',
            pieHole: 0.25,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));

        chart.draw(data, options);
    }
</script>
@endsection
