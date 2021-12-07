<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="mystyle.css">
    <div style='display :flex; justify-content: center; align-content: center;'>
        <img style="width: 200px;" src="https://media.discordapp.net/attachments/481230407933755409/908441532594528376/MicrosoftTeams-image_2.png?width=376&height=423" alt="Logo">
    </div>
</head>

<html>
<body>

    <div>
        <div id="AlertHeader" style='display :flex; justify-content: center; align-content: center;'>
            <h2>Alertes pour les capteurs</h2>
        </div>
    </div>

    <div id="Notification" style='display :flex; justify-content: center; align-content: center;'>
        <table style='border: 1px solid black;'>
            <tr>
                <th style='border: 1px solid black;'>Description</th>
                <th style='border: 1px solid black;'>Statut de l'alerte</th>
                <th style='border: 1px solid black;'>Code d'erreur</th>
                <th style='border: 1px solid black;'>Id Capteurs</th>
            </tr>
            @foreach($notification as $notifications)
                <tr>
                    <td style='text-align: center'> {{ $notifications["description"] }} </td>
                    <td style='text-align: center'> {{ $notifications["alerteStatus"] }} </td>
                    <td class="alerteStatus" style='text-align: center' > {{ $notifications["alerteStatus"] }} </td>
                    <td style='text-align: center'> {{ $notifications["codeErreur"] }} </td>
                    <td style='text-align: center'> {{ $notifications["idSensor"] }} </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

<footer>
    <div id="footer" style='display :flex; justify-content: center; align-content: center;'>
        <p>CEGEP SERRE TECH</p>
    </div>
</footer>
</html>

<script>
    window.onload = function changeColor(){
        let status = document.querySelectorAll('.alerteStatus');

        status.forEach(function(state){
            if( state.innerText === '1'){
                state.style.backgroundColor = 'green';
                state.style.color = 'white';
                state.textContent = 'Terminé';
            }
            else if ( state.innerText === '0')
            {
                state.style.backgroundColor = 'red';
                state.style.color = 'white';
                state.textContent = 'En cours';
            }
        })
        console.log(status.innerText);
    }
</script>
