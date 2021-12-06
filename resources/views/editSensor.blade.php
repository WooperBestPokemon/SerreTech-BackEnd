@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>
                @foreach($user as $users)
                <th>Bonjour : {{ $users["name"] }}</th>
                @if($users["role"] == 'admin' || $users["permission"] >= '2')
                <h3>Modification de capteur</h3>

                    <form action = "{{route("editsensorPut",$sensors->idSensor)}}" method = "post">
                        @csrf
                        @method('PUT')
                        <label>Nom : </label>
                        <input required maxlength='200' type="text" id="name" value='{{ $sensors->name }}' name="name"><br>

                        <label>Description : </label>
                        <input type="text" maxlength='200' id="description" value='{{ $sensors->description }}' name="description"><br>

                        <label>Type de données : </label>
                        <select required name="typeData" id="typeData">
                            <option value="{{ $sensors->typeData }}" selected>Type de données</option>
                            <option value="luminosite">Luminosité</option>
                            <option value="temperature">Température</option>
                            <option value="humidite">Humidité</option>
                            <option value="humidite du sol">Humidité du sol</option>
                        </select><br>

                        <label>Choisir la zone :</label>
                            <select required name="idZone" id="idZone">
                                <option value="{{ $sensors->idZone }}" selected>Zones</option>
                                @foreach($zone as $zones)
                                <option value='{{ $zones["idZone"] }}'>{{ $zones["name"] }}</option>
                                @endforeach
                            </select>
                            <br>
                        <input type = 'submit' value = "Modifier"/>
                    </form>
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
