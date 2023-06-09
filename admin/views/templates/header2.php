<?php
    $url = "http://localhost/libros/";
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location:modules/inicio.php");
    }else{
        if($_SESSION['usuario']=="ok"){
            $nombreUsuario=$_SESSION["nombreUsuario"];
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand navbar-light bg-light">
                    <div class="nav navbar-nav">
                        <a class="nav-link active" href="inicio">Administrador<span class="sr-only">(current)</span></a>
                        <a class="nav-link" href="inicio">Inicio</a>
                        <a class="nav-link" href="productos">Libros</a>
                        <a class="nav-link" href="cerrar">Cerrar sesion</a>
                        <a class="nav-link" href="<?php echo $url; ?>" target="_blank">Ver sitio web</a>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
        <br>
        <div class="row">