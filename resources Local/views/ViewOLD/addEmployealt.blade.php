@include('layouts.navbar')

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>
                <div>

                <th>Bonjour : {{ $user->name }}</th>
                @if($user->role == 'admin' || $user->permission >= '4')
                <h3>Insertion d'employé</h3>
                    <form action = "{{route("addEmployePost")}}" method = "post">
                        @csrf
                        @method("POST")
                        <label>Nom : </label>
                        <input required maxlength='200' type="text" id="name" name="name"><br>

                        <label>Email : </label>
                        <input required type="email" maxlength='200' id="email" name="email"><br>

                        <label>Mot de passe : </label>
                        <input required maxlength='200' type="text" id="password" name="password"><br>

                        <label>Permission : </label>
                        <select required name="permission" id="permission">
                            <option value="0">Aucun droit</option>
                            <option value="1">Peut voir les objets</option>
                            <option value="2">Peut modifier les objets</option>
                            <option value="3">Peut ajouter/modifier les objets</option>
                            <option value="4">Peut ajouter/modifier des employés et objects</option>
                            <option value="5">Admin</option>
                        </select><br>


                        <input  type="hidden" maxlength='200' id="idCompany" value='{{ $user->idCompany }}' name="idCompany">


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

