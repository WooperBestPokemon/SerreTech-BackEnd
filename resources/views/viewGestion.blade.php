@include('layouts.navbar')
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://cdn.discordapp.com/attachments/481230407933755409/891021680602910751/Items.png" alt="Logo best team">
                </div>

                <div>
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

                    <h5>Tableau des zones</h5>
                    <table style='border:1px solid black;'>
                        <tr style="font-weight: bold;">
                            <th>ID</th>
                            <th>NOM</th>
                            <th>description</th>
                            <th>type de plante</th>
{{--                            <th>Nom serre</th>--}}

                            <th></th>
                        </tr>
                    @foreach($zone as $zones)
                        <tr>
                            <th>{{ $zones["idZone"] }}</th>
                            <th>{{ $zones["name"] }}</th>
                            <th>{{ $zones["description"] }}</th>
                            <th>{{ $zones["typeFood"] }}</th>
{{--                            <th>{{ $zones["nameGreenhouse"] }}</th>--}}
{{--                            <th><a href='/serre/{{ $greenhouses["idGreenHouse"] }}'>Detail</a></th>--}}
                            <th><a href="{{route('editzone',$zones["idZone"])}}">Modifier</a></th>
                            <th><form action="{{route('deletezone',$zones["idZone"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
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
                        </tr>
                    @foreach($sensor as $sensors)
                        <tr>
                            <th>{{ $sensors["idSensor"]  }}</th>
                            <th>{{ $sensors["name"] }}</th>
                            <th>{{ $sensors["description"]  }}</th>
                            <th>{{ $sensors["typeData"]  }}</th>

                            <th><a href="{{route('editsensor',$sensors["idSensor"])}}">Modifier</a></th>
                            <th><form action="{{route('deletesensor',$sensors["idSensor"])}}" method="post" onclick="return confirm('Êtes-vous sur?')"><input class="btn btn-default" type="submit" value="Effacer" /> @method('delete') @csrf </form></th>
                        </form>
                        </tr>
                    @endforeach
                    </table>



                    </div>
                </div>

                <div>
                <a style="text-decoration: underline;" href="{{route("admin")}}">Acceuil</a>
                </div>

            </div>
        </div>
    </body>
</html>
