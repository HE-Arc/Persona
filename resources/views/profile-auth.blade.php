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
                <div class="panel-body" id="donutchart_personality"></div>
                <div class="panel-body" id="donutchart_quality"></div>
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
        var data_personality = new google.visualization.DataTable();
        data_personality.addColumn('string', 'Personality');
        data_personality.addColumn('number', 'number of friends');

        for (var key in nb_friends_personality){
            data_personality.addRows([[key, nb_friends_personality[key]]]);
        }

        var options_personality = {
            title: 'Number of friends by personality',
            pieHole: 0.25,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart_personality'));

        chart.draw(data_personality, options_personality);

        var nb_friends_quality = {!! json_encode($nb_friends_quality_name) !!};

        // Create the data table.
        var data_quality = new google.visualization.DataTable();
        data_quality.addColumn('string', 'Quality');
        data_quality.addColumn('number', 'number of friends sharing this quality');

        for (var key in nb_friends_quality){
            data_quality.addRows([[key, nb_friends_quality[key]]]);
        }

        var options_quality = {
            title: 'Number of friends sharing their qualities',
            pieHole: 0.25,
        };

        var chart_quality = new google.visualization.PieChart(document.getElementById('donutchart_quality'));

        chart_quality.draw(data_quality, options_quality);
    }
</script>
@endsection
