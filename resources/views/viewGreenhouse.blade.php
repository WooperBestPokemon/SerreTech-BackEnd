@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>
                @foreach($user as $users)
                <th>Bonjour : {{ $users["name"] }}</th>
                @endforeach
                
                <h5>Tableau de la serre</h5>
                <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>
                            <th>image</th>
                        </tr>
                    @foreach($greenhouse as $greenhouses)
                        <tr>
                            <th>{{ $greenhouses->idGreenhouse }}</th>
                            <th>{{ $greenhouses->name }}</th>
                            <th>{{ $greenhouses->description }}</th>
                            <th><img src="{{ $greenhouses->img }}"></th>
                        </tr>
                    @endforeach
                    </table>

                    <h5>Tableau des zones présentes dans la serre</h5>
                    <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>
                            <th>type de plante</th>
                            <th>Détails</th>
                        </tr>
                    @foreach($zone as $zones)
                        <tr>
                            <th>{{ $zones->idZone }}</th>
                            <th>{{ $zones->name }}</th>
                            <th>{{ $zones->description }}</th>
                            <th>{{ $zones->typeFood }}</th>
                            <th><form action='/zone/{{ $zones->idZone }}'>
                            <input type=submit value='Détails'></th>
                        </form>
                        </tr>
                    @endforeach
                    </table>
                </div>

                <div>
                        <a style="text-decoration: underline;" href="https://pcst.xyz">Acceuil</a>
                </div>

            </div>
        </div>
    </body>
</html>
