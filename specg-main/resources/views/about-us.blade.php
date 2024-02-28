<!DOCTYPE html>
<html>
    <head>
        @include ('head')
        <title>Spec G | Clients</title>
    </head>
    <body class="vh-100 webpage">
        @include ('navbar')
        <div class="col-md-10 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-3 ms-4">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">About Us</li>
                </ol>
            </nav>
            <h1 class="text-center mb-3">About Us</h1>
            <div class="square col-md-10 mx-auto">
                <div>
                    <img src="{{ asset('/images/team1.jpg') }}" class="float-start img-fluid me-3 mb-3" style="max-width: 490px"/>
                </div>
                <p style="font-size: 18px"> 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In the year 2013, Spec G Construction Services was formed and registered with the Department of Trade and Industry. The company started with Engr. Gail Raul Q. Dumalag, a registered Civil Engineer, as the proprietor and Mr. Emmanuel George O. Chua, a Management graduate, as the manager. <br /><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;In 2014, Ar. Joel B. Jucom, a registered Architect, Mechanical Engineer, and Master Plumber, joined the company as the Architect. Since then, the company has been rendering architectural designs and construction services. Architect, Mechanical Engineer, Master Plumber Joel B. Jucom and Civil Engineer Gail Raul Q. Dumalag has been working together since 2014 and has materialized every clients' concept of what their dream structure is ever since. Spec G Construction Services aims to provide the needs of every client and make its creations pleasing and cost-justifiable. Due to the company's competent workforce and drive to always be the best, it has won the 2018 design for the PHCCI Commercial Building as well as the PHCCI Siquijor Branch Building, an achievement that is unparalleled among its competitors. Although physically located at 150 San Jose Ext., Taclobo, Dumaguete City, the scope of the company's services are broad and can go beyond Negros Oriental.
                </p>
            </div>
            <div class="col-sm-10 mx-auto bg-light mb-5">
                <h3 class="ps-5 pt-4 mb-0">What we offer</h3>
                <div class="container text-center">
                    <div class="row fs-1 pt-2">
                        <div class="col px-5 pb-5">
                            <i class="bi-hammer"></i><br />
                            Construction
                        </div>
                        <div class="col px-5 pb-5">
                            <i class="bi-rulers"></i><br />
                            Plan
                        </div>
                        <div class="col px-5 pb-5">
                            <i class="bi-wrench-adjustable"></i><br />
                            Renovate
                        </div>
                        <div class="col px-5 pb-5">
                            <i class="bi-palette-fill"></i><br />
                            Design
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light mb-5 col-md-10 mx-auto">
                <div class="card-body">
                    <h3 class="mb-3">Contact Us</h3>
                    <i class="bi-building-fill mb-2">150 San Jose Ext., Brgy. Taclobo, Dumaguete City, Negros Oriental</i><br />
                    <i class="bi-telephone-fill mb-2">(035) 422-8949</i><br />
                    <i class="bi-envelope-fill mb-2">inquiry@specgconstruction.com</i><br />
                    <i class="bi-facebook mb-2"><a href="https://www.facebook.com/SpecGConstruction" target="_blank">@SpecGConstruction</a></i>
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('load', function() {
               //for nav active
                $('#nav-home').removeClass('active');
                $('#nav-home').removeAttr('aria-current');
                $('#nav-home').prop('href','/home');
                $('#nav-client').removeClass('active');
                $('#nav-client').removeAttr('aria-current');
                $('#nav-client').prop('href','/client-list');
                $('#nav-task').removeClass('active');
                $('#nav-task').removeAttr('aria-current');
                $('#nav-task').prop('href','/task-list');
                $('#nav-about').addClass('active');
                $('#nav-about').prop('aria-current','page');
                $('#nav-about').removeAttr('href');
                //end for nav active
            });
        </script>
    </body>
</html>
