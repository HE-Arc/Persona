<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Persona</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: black;
                color: snow;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                background-size: cover;
                background: url({{ secure_asset('welcome.jpg') }}) no-repeat center center fixed;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .bottom-left {
                position: absolute;
                left: 10px;
                bottom: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links, a {
                text-shadow: 0px 1px 8px rgba(0, 0, 0, 0.4);
                color: snow;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-transform: uppercase;
                text-decoration: none;
            }

            .fadein {
                animation: fadein 4s ease-in-out forwards;
            }

            .moveup {
                animation: moveup 3s ease-out forwards;
            }

            @keyframes fadein {
                from {opacity: 0;} to {opacity: 1;}
            }

            @keyframes moveup {
                from {opacity: 0;} to {opacity: 1;}
                from {margin-bottom: 0px;} to {margin-bottom: 15px;}
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links fadein">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title moveup">
                    {{ config('app.name', 'Laravel') }}
                </div>

                <div class="links moveup">
                    <b>your new home</b>
                </div>
                <div class="bottom-left links fadein">
                    <a href="https://www.klassencreate.ca/">Background image © 2017 Klassen Create</a>
                </div>
            </div>
        </div>
    </body>
</html>
