<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Light Bootstrap Dashboard by Creative Tim</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{asset('assets/css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{asset('assets/css/light-bootstrap-dashboard.css?v=1.4.0')}}" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="{{asset('http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('http://fonts.googleapis.com/css?family=Roboto:400,700,300')}}" rel='stylesheet' type='text/css'>
    <link href="{{asset('assets/css/pe-icon-7-stroke.css')}}" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-image="{{asset('assets/img/sidebarleaf.png')}}">

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <img src="{{asset('assets/img/logo1.png')}}" class="img-fluid" alt="Responsive image" style="padding-left:85px">
            </div>

            <ul class="nav">
                <li class="active">
                    <a href="dashboard.html">
                        <i class="pe-7s-monitor"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="active">
                    <a href="dashboard.html">
                        <i class="pe-7s-leaf"></i>
                        <p>Serres</p>
                    </a>
                </li>
                <li class="active">
                    <a href="dashboard.html">
                        <i class="pe-7s-ticket"></i>
                        <p>Zones</p>
                    </a>
                </li>
                <li class="active">
                    <a href="dashboard.html">
                        <i class="pe-7s-usb"></i>
                        <p>Capteurs</p>
                    </a>
                </li>
                <li class="active">
                    <a href="dashboard.html">
                        <i class="pe-7s-users"></i>
                        <p>Gestion utilisateurs</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-sml btn-round" href="#"><i class="pe-7s-leaf"></i> Ajouter Serre</button>
                    <button type="button" class="btn btn-default btn-sml btn-round" href="#"><i class="pe-7s-ticket"></i> Ajouter Zone</button>
                    <button type="button" class="btn btn-default btn-sml btn-round" href="#"><i class="pe-7s-usb"></i> Ajouter Capteur</button>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown nav-item">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="pe-7s-bell"></i>
                                <span class="notification">5</span>
                                <span class="d-lg-none"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <a class="dropdown-item" href="#">Notification 1</a>
                                <a class="dropdown-item" href="#">Notification 2</a>
                                <a class="dropdown-item" href="#">Notification 3</a>
                                <a class="dropdown-item" href="#">Notification 4</a>
                                <a class="dropdown-item" href="#">Another notification</a>
                            </ul>
                        <li>
                            <a href="">
                                Log out
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <table class="table">
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>

                            <th></th>
                        </tr>
                        @foreach($greenhouse as $greenhouses)
                            <tr>
                                <th>{{ $greenhouses["idGreenHouse"] }}</th>
                                <th>{{ $greenhouses["name"] }}</th>
                                <th>{{ $greenhouses["description"] }}</th>
                                {{--                            <th><a href='/serre/{{ $greenhouses["idGreenHouse"] }}'>Detail</a></th>--}}
                                <th><a href="{{route('editgreenhouse',$greenhouses["idGreenHouse"])}}">Modifier</a></th>
                                <th><form action="{{route('deletegreenhouse',$greenhouses["idGreenHouse"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">

                            </a>
                        </li>

                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="#">Cegep Serre-Tech</a>
                </p>
            </div>
        </footer>

    </div>
</div>


</body>

<!--   Core JS Files   -->
<script src="{{asset('assets/js/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="{{asset('assets/js/chartist.min.js')}}"></script>

<!--  Notifications Plugin    -->
<script src="{{asset('assets/js/bootstrap-notify.js')}}"></script>
</html>
