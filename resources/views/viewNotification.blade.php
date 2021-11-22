<!DOCTYPE html>
<head>
    <link rel="stylesheet" href="mystyle.css">
</head>

<html>
<body>

    <div>
        <div id="AlertHeader" style='display :flex; justify-content: center; align-content: center;'>
            <h2>Alerte pour les capteurs</h2>
        </div>
    </div>

    <div id="Notification" style='display :flex; justify-content: center; align-content: center;'>
        <table style='border: 1px solid black;'>
            <tr>
                <th style='border: 1px solid black;'>Description</th>
                <th style='border: 1px solid black;'>Statut de l'alerte</th>
                <th style='border: 1px solid black;'>Id Capteurs</th>
            </tr>
            @foreach($notification as $notifications)
                <tr>
                    <td style='text-align: center'> {{ $notifications["description"] }} </td>
                    <td style='text-align: center'> {{ $notifications["alerteStatus"] }} </td>
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
