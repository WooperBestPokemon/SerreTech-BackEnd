@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>
                @foreach($user as $users)
                <th>Bonjour : {{ $users["name"] }}</th>
                @if($users["role"] == 'admin' || $users["permission"] >= '3')
                <h3>Insertion de zone</h3>
                    <form action = "{{route('addzonePost')}}" method = "post">
                        @csrf
                        @method('POST')
                        <label>Nom : </label>
                        <input required type="text" maxlength='200' id="name" name="name"><br>

                        <label>Description : </label>
                        <input type="text" maxlength='200' id="description" name="description"><br>


                        <label>Choisir le type de plante :</label>
                            <select required name="typeFood" id="typeFood">
                                <option value="" disabled selected>Plantes</option>
                                @foreach($allPlant as $allPlants)
                                <option value='{{ $allPlants->idPlant }}'>{{ $allPlants->plantName }}</option>
                                @endforeach
                            </select><br>

                        <label>Choisir la serre :</label>
                            <select required name="idGreenhouse" id="idGreenhouse">
                               <option value="" disabled selected>Serres</option>
                               @foreach($greenhouse as $greenhouses)
                                <option value='{{ $greenhouses["idGreenHouse"] }}'>{{ $greenhouses["name"] }} - {{ $greenhouses["description"] }}</option>
                                @endforeach
                            </select><br>
                        <label>Image :</label>
                            <input href="#" name="img" type="url" placeholder="Url du produit" maxlength='999'>
                            <br>
                        <input type = 'submit' value = "Ajouter"/>
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
