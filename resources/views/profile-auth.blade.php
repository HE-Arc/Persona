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

                <hr>
                <!-- div affichant les donuts charts -->
                <div class="panel-body" id="donutchart_personality"></div>
                <div class="panel-body" id="donutchart_quality"></div>
            </div>
        </div>
    </div>
</div>

<!-- script pour le donuts charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        //CHART DES PERSONALITES
        //transforme le tableau PHP en objet JSON pour le google chart
        var nb_friends_personality = {!! json_encode($nb_friends_personality) !!};

        //création de la table de data avec le type et le titre de chaque colone
        var data_personality = new google.visualization.DataTable();
        data_personality.addColumn('string', 'Personality');
        data_personality.addColumn('number', 'number of friends');

        //boucle remplissant le tableau de données pour le google chart des personalités
        for (var key in nb_friends_personality){
            data_personality.addRows([[key, nb_friends_personality[key]]]);
        }

        //option appliquées sur le chart des personalités
        var options_personality = {
            title: 'Personalities of my friends',
            pieHole: 0.25,
        };

        //"magie" google pour afficher le chart d'après le tableau de data et les options dans l'élement div ayant comme id donutchart_personality
        var chart = new google.visualization.PieChart(document.getElementById('donutchart_personality'));
        chart.draw(data_personality, options_personality);


        //CHART DES QUALITES
        //transforme le tableau PHP en objet JSON pour le google chart
        var nb_friends_quality = {!! json_encode($nb_friends_quality_name) !!};

        //création de la table de data avec le type et le titre de chaque colone
        var data_quality = new google.visualization.DataTable();
        data_quality.addColumn('string', 'Quality');
        data_quality.addColumn('number', 'number of friends sharing this quality');

        //boucle remplissant le tableau de données pour le google chart des qualités
        for (var key in nb_friends_quality){
            data_quality.addRows([[key, nb_friends_quality[key]]]);
        }

        //option appliquées sur le chart des qualités
        var options_quality = {
            title: 'Qualities of my friends',
            pieHole: 0.25,
        };

        //"magie" google pour afficher le chart d'après le tableau de data et les options dans l'élement div ayant comme id donutchart_personality
        var chart_quality = new google.visualization.PieChart(document.getElementById('donutchart_quality'));
        chart_quality.draw(data_quality, options_quality);
    }
</script>
@endsection
