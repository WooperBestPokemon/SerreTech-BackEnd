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
                        <h3>Consulter</h3>
                        <h5>Tableau des serres</h5>
                    <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>
                            <th></th>
                            <th></th>
                        </tr>
                    @foreach($greenhouse as $greenhouses)
                        <tr>
                            <th>{{ $greenhouses["idGreenHouse"] }}</th>
                            <th>{{ $greenhouses["name"] }}</th>
                            <th>{{ $greenhouses["description"] }}</th>
                            @if($user->role == 'admin' || $users["permission"] >= '2')
                                <th><a href="{{route('editgreenhouse',$greenhouses["idGreenHouse"])}}">Modifier</a></th>
                            @endif
                            @if($user->role == 'admin')
                            <th><form action="{{route('deletegreenhouse',$greenhouses["idGreenHouse"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
                            @endif
                        </tr>
                    @endforeach
                    </table>

                    <h5>Tableau des zones</h5>
                    <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>
                            <th>type de plante</th>
                            <th></th>
                            <th></th>
                        </tr>
                    @foreach($zone as $zones)
                        <tr>
                            <th>{{ $zones["idZone"] }}</th>
                            <th>{{ $zones["name"] }}</th>
                            <th>{{ $zones["description"] }}</th>
                            <th>{{ $zones["typeFood"] }}</th>
                            @if($user->role == 'admin' || $user->permission >= '2')
                            <th><a href="{{route('editzone',$zones["idZone"])}}">Modifier</a></th>
                            @endif
                            @if($user->role == 'admin')
                            <th><form action="{{route('deletezone',$zones["idZone"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
                            @endif
                        </form>
                        </tr>
                    @endforeach
                    </table>

                    <h5>Tableau des capteurs</h5>
                    <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>
                            <th>type de données</th>
                            <th></th>
                            <th></th>
                        </tr>
                    @foreach($sensor as $sensors)
                        <tr>
                            <th>{{ $sensors["idSensor"]  }}</th>
                            <th>{{ $sensors["name"] }}</th>
                            <th>{{ $sensors["description"]  }}</th>
                            <th>{{ $sensors["typeData"]  }}</th>

                            @if($user->role == 'admin' || $user->permission >= '2')
                            <th><a href="{{route('editsensor',$sensors["idSensor"])}}">Modifier</a></th>
                            @endif
                            @if($user->role == 'admin')
                            <th><form action="{{route('deletesensor',$sensors["idSensor"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
                            @endif
                        </form>
                        </tr>
                    @endforeach
                    </table>

                    </div>
                </div>
            <br>
                <div>
                    <a style="text-decoration: underline;" href="{{route("admin")}}">Acceuil</a>
                </div>
                @else
                        <p>Vous n'avez pas les permissions requises afin d'acceder a cette page</p>
                        <a style="text-decoration: underline;" href="{{route("admin")}}">Retour a l'acceuil</a>
                @endif

            </div>
        </div>
    </body>
</html>
