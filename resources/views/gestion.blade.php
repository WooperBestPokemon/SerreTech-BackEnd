@include('layouts.navbar')

<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
        </div>
        <div>

            <th>Bonjour : {{ $user->name }}</th>
            @if($user->role == 'admin' || $user->permission >= '1')
                <h1> GESTION </h1>

                <div style='border:1px solid black;'>
                    @if( $user->role == 'admin' ||$users->permission >= '3')
                        <h3>Ajout</h3>
                        <a href="{{route('addgreenhouse')}}" class="btn btn-primary">Ajouter Serre</a> </br>
                        <a href="{{route('addzone')}}" class="btn btn-primary">Ajouter zone</a> </br>
                        <a href="{{route('addsensor')}}" class="btn btn-primary">Ajouter capteur</a> </br>
                    @endif


                    <h3>Consultation</h3>
                    <a href="{{route('adminGestion')}}" class="btn btn-primary">Consulation</a> </br>


                    @if( $user->role == 'admin' || $users->permission >= '4')
                        <h3>User</h3>
                        <a href="{{route('addEmploye')}}" class="btn btn-primary">Ajouter</a> </br>
                        <a href="{{route('employe')}}" class="btn btn-primary">Gerer</a> </br>
                    @endif
                </div>
        </div>
        <div>
            <a style="text-decoration: underline;" href="{{route("home")}}">Acceuil</a>
        </div>
        @else
            <p>Vous n'avez pas les permissions requises afin d'acceder a ce site</p>
        @endif

    </div>
</div>
