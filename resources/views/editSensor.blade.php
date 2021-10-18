@include('layouts.navbar')
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">


            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://cdn.discordapp.com/attachments/481230407933755409/891021680602910751/Items.png" alt="Logo best team">
                </div>

                <div>
                <h3>Modification de capteur</h3>

                    <form action = "{{route("editsensorPut",$sensors->idSensor)}}" method = "post">
                        @csrf
                        @method('PUT')
                        <label>Nom : </label>
                        <input required maxlength='200' type="text" id="name" value='{{ $sensors->name }}' name="name"><br>

                        <label>Description : </label>
                        <input type="text" maxlength='200' id="description" value='{{ $sensors->description }}' name="description"><br>

                        <label>Type de données : </label>
                        <input type="text" required maxlength='200' id="typeData" name="typeData"><br>

                        <label>Choisir la zone :</label>
                            <select required name="idZone" id="idZone">
                                <option value="{{ $sensors->idZone }}" selected>Zones</option>
                                @foreach($zone as $zones)
                                <option value='{{ $zones["idZone"] }}'>{{ $zones["name"] }}</option>
                                @endforeach
                            </select>
                            <br>
                        <input type = 'submit' value = "Modifier capteur"/>
                    </form>
                </div>

                <div>
                <a style="text-decoration: underline;" href="{{route("admin")}}">Acceuil</a>
                </div>

            </div>
        </div>
    </body>
</html>
