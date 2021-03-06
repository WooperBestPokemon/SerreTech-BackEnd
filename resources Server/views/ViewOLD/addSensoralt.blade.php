@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>
                <th>Bonjour : {{ $user->name }}</th>
                @if($user->role == 'admin' || $user->permission >= '3')
                <h3>Insertion de capteurs</h3>
                    <form action = "{{route("addsensorPost")}}" method = "post">
                        @csrf
                        @method('POST')
                        <label>Nom : </label>
                        <input required maxlength='200' type="text" id="name" name="name"><br>

                        <label>Description : </label>
                        <input type="text" maxlength='200' id="description" name="description"><br>

                        <label>Type de données : </label>
                        <select required name="typeData" id="typeData">
                            <option value="luminosite">Luminosité</option>
                            <option value="temperature">Température</option>
                            <option value="humidite">Humidité</option>
                            <option value="humidite du sol">Humidité du sol</option>
                        </select><br>

                        <label>Choisir la zone :</label>
                            <select required name="idZone" id="idZone">
                                <option value="" disabled selected>Zones</option>
                                @foreach($zone as $zones)
                                <option value='{{ $zones["idZone"] }}'>{{ $zones["name"] }} - {{ $zones["description"] }}</option>
                                @endforeach
                            </select><br>
                        <input type = 'submit' value = "Ajouter"/>
                    </form>
                </div>

                <div>
                <a style="text-decoration: underline;" href="{{route("admin")}}">Acceuil</a>
                </div>
                @else
                    <p>Vous n'avez pas les permissions requises afin d'acceder a cette page</p>
                   <a style="text-decoration: underline;" href="{{route("admin")}}">Retour a l'acceuil</­a>
                @endif
            </div>
        </div>
    </body>
</html>
