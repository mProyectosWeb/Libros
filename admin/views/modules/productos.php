<?php

include_once '../admin/config/conexion.php';
?>
<?php
$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : "";
$image = (isset($_FILES['imagen']['name'])) ? $_FILES['imagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";
#echo __DIR__ . "/views/img/";
// echo $id."<br>";
// echo $nombre."<br>";
 echo $image."<br>";
// echo $accion."<br>";
//INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES ('1', 'Libro de PHP', '1.png');

switch ($accion) {
    case "Agregar":
        if (empty(trim($_POST['nombre']))) {
            $mensaje = "Los campos no deben estar vacios";
        } else {
            $sentenciaSQL = $conexion->prepare("INSERT INTO libros (nombre,imagen) VALUES (:nombre,:imagen);");
            $sentenciaSQL->bindParam(':nombre', $nombre);

            $fecha = new DateTime();
            $nombreArchivo = ($image != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["imagen"]["tmp_name"];
            if ($tmpImagen != "") {
                move_uploaded_file($tmpImagen, "../admin/views/img/" . $nombreArchivo);
            }
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->execute();
            header("Location:".SERVER_URL."productos");
        }
        break;
    case "Modificar":
        //echo "Se presiono el boton modificar";
        $sentenciaSQL = $conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciaSQL->bindParam(':nombre', $nombre);
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();

        if (!empty($image)) {
            $fecha = new DateTime();
            $nombreArchivo = ($image != "") ? $fecha->getTimestamp() . "_" . $_FILES["imagen"]["name"] : "imagen.jpg";
            $tmpImagen = $_FILES["imagen"]["tmp_name"];

            move_uploaded_file($tmpImagen, "../../img/" . $nombreArchivo);

            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $id);
            $sentenciaSQL->execute();
            $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
                if (file_exists("../../img/" . $libro["imagen"])) {
                    unlink("../../img/" . $libro["imagen"]);
                }
            }

            $sentenciaSQL = $conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam(':id', $id);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");
        break;
    case "Cancelar":

        $id = "";
        $nombre = "";
        $image = "";
        $accion = "Agregar";

        break;
    case "Seleccionar":
        //echo "Se presiono el boton seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $nombre = $libro['nombre'];
        $image = $libro['imagen'];

        break;
    case "Borrar":
        //echo "Se presiono el boton borrar";
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($libro["imagen"]) && ($libro["imagen"] != "imagen.jpg")) {
            if (file_exists("../../img/" . $libro["imagen"])) {
                unlink("../../img/" . $libro["imagen"]);
            }
        }



        $sentenciaSQL = $conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id', $id);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM libros");
$sentenciaSQL->execute();
$listaLibros = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos del Libro
        </div>
        <div class="card-body">
            <?php if (isset($mensaje)) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php } ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="id">Clave:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $id; ?> " name="id" id="id" placeholder="Clave del producto">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $nombre; ?> " name="nombre" id="nombre" placeholder="Nombre del libro">
                </div>
                <div class="form-group">
                    <label for="nombre">Imagen:</label>
                    <br>
                    <?php if (!empty($image)) { ?>
                        <img class="img-thumbnail rounded" src="views/img/<?php echo $image ?>" width="70" alt="">
                    <?php } ?>
                    <input type="file" class="form-control" name="imagen" id="imagen" placeholder="imagen">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar" class="btn btn-success">Agregar</button>
                    <?php if ($accion == "Seleccionar") { ?>
                        <button type="submit" name="accion" value="Modificar" class="btn btn-warning">Modificar</button>
                        <button type="submit" name="accion" value="Cancelar" class="btn btn-info">Cancelar</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaLibros as $libro) { ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td>
                        <img class="img-thumbnail rounded" src="views/img/<?php echo $libro["imagen"]; ?>" width="70" alt="">
                        <!-- <?php echo $libro['imagen'] ?> -->
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="id" id="id" value="<?php echo $libro['id']; ?>">
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>