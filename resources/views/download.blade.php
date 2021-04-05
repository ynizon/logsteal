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
        <link href="/css/all.css" rel="stylesheet">

        <script>
            function dl(){
                var str = "";
                var z = 9999999;
                while(z--)
                    str += String.fromCharCode((Math.random() * 1234567)^0xF0F0F0F0);
                var b = new Blob([str]);
                var a = document.createElement("a");
                a.href=URL.createObjectURL(b);
                a.download="file.zip";
                a.click();
                document.getElementById("spin").style.display = "none";
            }
        </script>
    </head>
    <body>
    <div class="position-ref full-height" style="padding-top:50px">
            <div class="content">
                <div class="title m-b-md">
                    Download
                </div>

                <div style="padding:50px;" class="row">
                    <div class="col-md-12">
                        <button onclick='document.getElementById("spin").style.display = "";dl();'>Download</button>
                        <br/>
                        <i id="spin" class="fa fa-sync fa-spin" style="display:none"></i>
                    </div>
                    <div class="col-md-12">
				        <img src="http://nojsstats.appspot.com/{{env('GA_UA')}}/{{env('URL_WEBSITE')}}" />
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
