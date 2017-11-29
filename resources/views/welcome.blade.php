<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Persona</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $(".fade-in").hide(0).fadeIn({queue: false, duration: 3000});
                $(".m-b-md").animate({'margin-bottom': '+=15px'}, 3000);
            });
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: snow;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
                background: url({{ secure_asset('welcome.jpg') }}) no-repeat center center fixed;
                -webkit-background-size: cover; /* pour anciens Chrome et Safari */
                background-size: cover; /* version standardisée */
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
                opacity: 0.7;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links {
                text-shadow: 0px 1px 8px rgba(0, 0, 0, 0.4);
                color: snow;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-transform: uppercase;
            }

            .links > a {
                text-shadow: 0px 1px 8px rgba(0, 0, 0, 0.4);
                color: snow;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-transform: uppercase;
                text-decoration: none;
            }

            .m-b-md {
                margin-bottom: 0px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links fade-in">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md fade-in">
                    {{ config('app.name', 'Laravel') }}
                </div>

                <div class="links m-b-md fade-in">
                    <b>your new home</b>
                </div>
                <div class="bottom-left links fade-in">
                    <a href="https://www.klassencreate.ca/">Background image © 2017 Klassen Create</a>
                </div>
            </div>
        </div>
    </body>
</html>
