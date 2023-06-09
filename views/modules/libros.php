<?php 
    
    require_once 'controllers/libros.controllers.php';
    $listaLibros = ControllersUsuarios::getLibros();
    foreach($listaLibros as $libro){
?>
    <div class="col-md-3">
        <div class="card">
            <div class="aspect-ratio">
                <img class="img-fluid" src="admin/views/img/<?php echo $libro['imagen']; ?>">
            </div>
            <div class="card-body">
                <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
                <a name="" id="" class="btn btn-primary" href="https://goalkicker.com" role="button">Ver más</a>
            </div>
        </div>
    </div>
    <?php } ?>