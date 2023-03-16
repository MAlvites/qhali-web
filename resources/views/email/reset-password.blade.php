<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restablecer contraseña</title>
    <style>
        .reset-button {
            box-sizing:border-box;
            font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
            border-radius:4px;
            color:#fff !important;
            display:inline-block;
            overflow:hidden;
            text-decoration:none;
            background-color:#2d3748;
            border-bottom:8px solid #2d3748;
            border-left:18px solid #2d3748;
            border-right:18px solid #2d3748;
            border-top:8px solid #2d3748;
        }
        .text-color {
            color: #718096;
        }
        .title-color {
            color: #2d3748;
        }
    </style>
</head>
<body>
    <h2 class="title-color">Hola</h2>
    <div class="text-color">Está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.</div>
    <div style="margin-top: 10px;">
        <a href="{{$url}}" class="reset-button" target="_blank" >Reestablecer contraseña</a>
    </div>
</body>
</html>