<?php
    
    if(isset($_GET['ruta'])){
        
        $ruta = $_GET['ruta'];
        
        if(
            $ruta == "main" ||
            $ruta == "libros" ||
            $ruta == "nosotros"
        ){
            include "header.php";
            include "views/modules/{$ruta}.php";
            include "footer.php";
        }
    }else{
        include "header.php";
        include "views/modules/main.php";
        include "footer.php";
    }
?>