@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://cdn.discordapp.com/attachments/481230407933755409/891021680602910751/Items.png" alt="Logo best team">
                </div>

                <div>
                    <h1> GESTION </h1>

                    <div style='border:1px solid black;'>
                        <h3>Ajout</h3>
                        <a href="{{route('addgreenhouse')}}" class="btn btn-primary">Ajouter Serre</a> </br>
                        <a href="{{route('addzone')}}" class="btn btn-primary">Ajouter zone</a> </br>
                        <a href="{{route('addsensor')}}" class="btn btn-primary">Ajouter capteur</a> </br>

                        <h3>Consultation</h3>
                        <a href="{{route('adminGestion')}}" class="btn btn-primary">Consulation</a> </br>

                    </div>
                </div>

                <div>
                <a style="text-decoration: underline;" href="{{route("home")}}">Acceuil</a>
                </div>

            </div>
        </div>
