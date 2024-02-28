<!DOCTYPE html>
<html lang="en">
    <head>
        @include ('head')
        <title>Spec G |  404 - Page Not Found</title>
        <!-- Styles -->
        <style>
            .title {
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 100;
                font-size: 36px;
                padding: 20px 20px 0px 20px;
            }
            .message {
                font-size: 20px;
                padding: 0px 20px 20px 20px;
                font-weight: bold;
            }
        </style>
    </head>
    <body class="vh-100 webpage">
        @include ('navbar')
        <div class="container">
            <div class="row col-md-10 mx-auto">
                <div class="col-sm-4 text-center align-self-center">
                    <img src="{{asset('/images/404.png')}}" class="img-fluid" alt="Error 404 image"/>    
                </div>
                <div class="col-sm-8 align-self-center">
                    <p class="title">Error 404: Page Not Found</p>
                    <p class="message">
                        Oops! We can't seem to find the page you're looking for.&nbsp;<i class="bi-emoji-frown ms-1"></i><br />
                        <a href="/home" role="button" class="btn btn-primary btnMain rounded-pill mt-3 px-5">Go to Spec G Home</a>
                    </p>
                </div>
               
            </div>
        </div>
    </body>
</html>