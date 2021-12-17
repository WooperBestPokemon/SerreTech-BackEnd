<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="{{asset('public/assets/img/favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Cegep Serre-Tech Admin Panel</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{asset('public/assets/css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{asset('public/assets/css/light-bootstrap-dashboard.css?v=1.4.0')}}" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="{{asset('http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('http://fonts.googleapis.com/css?family=Roboto:400,700,300')}}" rel='stylesheet' type='text/css'>
    <link href="{{asset('public/assets/css/pe-icon-7-stroke.css')}}" rel="stylesheet" />

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-image="{{asset('public/assets/img/sidebarleaf.png')}}">

        <!--

            Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
            Tip 2: you can also add an image using data-image tag

        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <img src="{{asset('public/assets/img/logo1.png')}}" class="img-fluid" alt="Responsive image" style="padding-left:85px"></br>
                <label style="padding-left:80px; font-weight:normal;">{{ $user->name }}</label>
            </div>
            @if($user->role == 'admin' || $user->permission >= '1')
                <ul class="nav">
                    <li class="active">
                        <a href="{{route("admin")}}">
                            <i class="pe-7s-monitor"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{route("adminGreenHouse")}}">
                            <i class="pe-7s-leaf"></i>
                            <p>Serres</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{route("adminZone")}}">
                            <i class="pe-7s-ticket"></i>
                            <p>Zones</p>
                        </a>
                    </li>
                    <li class="active">
                        <a href="{{route("adminSensor")}}">
                            <i class="pe-7s-usb"></i>
                            <p>Capteurs</p>
                        </a>
                    </li>
                    @if( $user->role == 'admin' || $users->permission >= '4')
                        <li class="active">
                            <a href="{{route('employe')}}">
                                <i class="pe-7s-users"></i>
                                <p>Gestion utilisateurs</p>
                            </a>
                            @endif
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
                    @if( $user->role == 'admin' ||$users->permission >= '3')
                        <button type="button" class="btn btn-info btn-sml btn-round"><i class="pe-7s-leaf"></i><a  href="{{route('addgreenhouse')}}"> Ajouter Serre</a></button>
                        <button type="button" class="btn btn-info btn-sml btn-round"><i class="pe-7s-ticket"></i><a  href="{{route('addzone')}}"> Ajouter Zone</a></button>
                        <button type="button" class="btn btn-info btn-sml btn-round"><i class="pe-7s-usb"></i><a  href="{{route('addsensor')}}"> Ajouter Capteur</a></button>
                    @endif
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown nav-item">
                            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="pe-7s-bell"></i>
                                <span class="notification">{{$notifCount}}</span>
                                <span class="d-lg-none"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach($notif as $notifs)
                                    <a class="dropdown-item" href="">{{$notifs["codeErreur"]}}-{{$notifs["description"]}}-Capteur:{{$notifs["idSensor"]}} </a><br>
                                @endforeach
                            </ul>
                        <li>
                            @include('layouts.logout')
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="form-group">
                    @if($user->role == 'admin' || $user->permission >= '3')
                        <h3>Informations de la nouvelle serre</h3>
                        <form action = "{{route("addgreenhousePost")}}" method = "post">
                            @csrf
                            @method("POST")
                            <label>Nom : </label>
                            <input class="form-control" required maxlength='200' type="text" id="name" name="name"><br>

                            <label>Description : </label>
                            <input class="form-control" type="text" maxlength='200' id="description" name="description"><br>


                            <label>Image :</label>
                            <input class="form-control" href="#" name="img" type="url" placeholder="Url du produit" maxlength='999'>
                            <br>
                            <input class="btn btn-default" type='submit' value="Ajouter"/>
                        </form>
                    </div>
                </div>
                @else
                    <p>Vous n'avez pas les permissions requises afin d'acceder a cette page</p>
                    <a style="text-decoration: underline;" href="{{route("admin")}}">Retour a l'acceuil</­a>
                @endif
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
@else
    <p>Vous n'avez pas les permissions requises afin d'acceder a ce site</p>
@endif

</body>

<!--   Core JS Files   -->
<script src="{{asset('public/assets/js/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/js/bootstrap.min.js')}}" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="{{asset('public/assets/js/chartist.min.js')}}"></script>

<!--  Notifications Plugin    -->
<script src="{{asset('public/assets/js/bootstrap-notify.js')}}"></script>
</html>

