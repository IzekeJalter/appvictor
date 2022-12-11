<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    <title>email</title>
</head>
<body>
    <h1>Bienvenido {{$nombre}}</h1>
    <h2>Verifica tu correo electronico</h2>
    <p>Da click para recibir tu codigo de verificacion</p>
    <a href="{{$url}}">
   enviar
    </a>
</body>
</html>