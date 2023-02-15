<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
        <tr>
            <td>
                <h3>RECUPERA TU CONTRASEÑA</h3>
            </td>
        </tr>
        <tr>
            <td>
                Estimado {{$user_name}}
            </td>
        </tr>
        <tr>
            <td>
                Para restablecer tu contraseña haz clic sobre el siguiente vínculo.
            </td>
        </tr>
        <tr>
            <td>
                <a href="{{$url}}">Enlace</a>
            </td>
        </tr>
        <tr>
            <td>
                Si el vínculo aparece roto, cópialo y pégalo en la barra de direcciones de tu navegador.
            </td>
        </tr>
    </table>
</body>
</html>
