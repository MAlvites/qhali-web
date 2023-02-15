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
                <h3>Usuario: {{$user_name}}</h3>
            </td>
        </tr>
        <tr>
            <td>
                Estimado,
            </td>
        </tr>
        <tr>
            <td>
                {!! $content !!}
            </td>
        </tr>
    </table>
</body>
</html>
