@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>
                @foreach($user as $users)
                <th>Bonjour : {{ $users["name"] }}</th>
                @if($users["role"] == 'admin' || $users["permission"] >= '4')
                <h1> Gestion des employés</h1>

                    <div style='border:1px solid black;'>
                        <h3>Consulter</h3>
                        <h5>Gestion des employés</h5>
                    <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Modifier</th>
                            <th></th>
                            <th></th>
                        </tr>
                    @foreach($employe as $employes)
                        <tr>
                            <th>{{ $employes["idProfile"] }}</th>
                            <th>{{ $employes["name"] }}</th>
                            <th>{{ $employes["email"] }}</th>
                            <th>**********</th>
                            <th>{{ $employes["role"] }}</th>
                            <th><a href="{{route('editEmploye',$employes["idProfile"])}}">Modifier</a></th>
                            @if($users["role"] == 'admin')
                            <th><form action="{{route('deleteuser',$employes["idProfile"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
                            @endif
                        </tr>
                    @endforeach
                    </table>
                </div>

                <div>
                <a style="text-decoration: underline;" href="{{route("admin")}}">Acceuil</a>
                </div>
                @else
                        <p>Vous n'avez pas les permissions requises afin d'acceder a cette page</p>
                        <a style="text-decoration: underline;" href="{{route("admin")}}">Retour a l'acceuil</a>
                @endif
                @endforeach
            </div>
        </div>
    </body>
</html>
