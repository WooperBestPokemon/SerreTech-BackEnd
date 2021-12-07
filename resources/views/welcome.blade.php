@include('layouts.navbar')
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                    <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
                </div>

                <br>
                        @foreach($user as $users)

                        <th>Bonjour : {{ $users["name"] }}</th>
                        </br>
                        @if($users["role"] == 'admin' || $users["permission"] >= '1')
                        <a href='{{route("admin")}}'> Admin
                        </a> </br>
                        @else
                        <p>Vous n'avez pas les permissions requises afin d'acceder a ce site</p>
                        @endif
                    @endforeach
                    </div>

            </div>
