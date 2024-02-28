<!DOCTYPE html>
<html lang="en">
    <head>
        @include ('head')
        <title>Spec G | @yield('code') - @yield('title')</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
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

            .content {
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 100;
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px 20px 0px 20px;
            }
        </style>
    </head>
    <body class="vh-100">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div>
                    <p class="title">@yield('message')</p>
                    <a href="/home" role="button" class="btn btn-primary btnMain rounded-pill mt-3 px-5">Go to Spec G Home</a> 
                </div>
            </div>
        </div>
    </body>
</html>
