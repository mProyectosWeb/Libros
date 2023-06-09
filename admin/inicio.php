<?php require_once '../admin/views/templates/header2.php'; ?>

<div class="col-md-12">
    <div class="jumbotron">
        <h1 class="display-3">Bienvenido <?php echo $nombreUsuario; ?></h1>
        <p class="lead">Administrador de libror</p>
        <hr class="my-2">
        <p>Más información</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="seccion/productos.php" role="button">Administrar libros</a>
        </p>
    </div>
</div>

<?php require_once '../admin/views/templates/footer.php'; ?>