<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Log</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
               color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
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

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    </head>
    <body>
    <div class="position-ref full-height" style="padding-top:50px">
            <div class="content">
                <div class="title m-b-md">
                    Informations
                </div>

                <div style="padding:50px;" class="row">
                    <div class="col-md-6">
                        @include('map', [$latitude, $longitude])
                    </div>
                    <div class="col-md-6">
                        <ul style="width:300px">
                        @foreach($connections as $connection)
                            <li>
                                {{ $connection->created_at }}
                                <ul>
                                    @foreach (json_decode($connection->info,true) as $key=>$value)
                                        <li>{{$key}} : {{$value}}</li>
                                    @endforeach
                                </ul>
                                <hr/>
                            </li>
                        @endforeach
                        </ul>
                    </div>

                    <div class="col-md-12">
                    {{ $connections->links() }}
                        <br/>
				        <img src="http://nojsstats.appspot.com/{{env('GA_UA')}}/{{env('URL_WEBSITE')}}" />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
