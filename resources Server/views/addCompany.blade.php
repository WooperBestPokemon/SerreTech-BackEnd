@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>

                <th>Bonjour : {{ $user->name }}</th>
                @if($user->role == 'admin')
                <h3>Création de la compagnie</h3>
                    <form action = "{{route("addCompanyPost")}}" method = "post">
                        @csrf
                        @method("POST")

                        <label>Nom de la compagnie : </label>
                        <input required maxlength='200' type="text" id="nameCompany" name="nameCompany"><br>


                        <h6>Création du compte admin</h6><br>

                        <label>Nom : </label>
                        <input required maxlength='200' type="text" id="name" name="name"><br>

                        <label>Email : </label>
                        <input required type="email" maxlength='200' id="email" name="email"><br>

                        <label>Mot de passe : </label>
                        <input required maxlength='200' type="text" id="password" name="password"><br>

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

            </div>
        </div>
    </body>
</html>

