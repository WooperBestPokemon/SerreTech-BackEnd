@include('layouts.navbar')
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">


            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://cdn.discordapp.com/attachments/481230407933755409/891021680602910751/Items.png" alt="Logo best team">
                </div>

                <div>
                <h3>Modification de serre</h3>

                    <form action = "{{route('editgreenhousePut',$idGreenHouse)}}" method = "post">
                        @csrf
                        @method('PUT')
                        <label>Nom : </label>
                        <input required maxlength='200' type="text" id="name" value='{{ $name}}' name="name"><br>

                        <label>Description : </label>
                        <input type="text" maxlength='200' id="description" value='{{ $description }}' name="description"><br>
                        <label>Image :</label>
                            <input value='{{ $img }}' name="img" type="url" placeholder="Url du produit" maxlength='999'>
                            <br>
                            <img style="width: 500px; height: 500px" src="{{ $img }}">
                            <br>
                        <input type = 'submit' value = "Modifier greenhouse"/>
                    </form>
                </div>

                <div>
                <a style="text-decoration: underline;" href="/">Acceuil</a>
                </div>

            </div>
        </div>
    </body>
</html>
