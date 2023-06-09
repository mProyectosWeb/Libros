<?php
    
    if(isset($_GET['ruta'])){
        
        $ruta = $_GET['ruta'];
        
        if(
            $ruta == "inicio" ||
            $ruta == "productos" ||
            $ruta == "cerrar" 
        ){
            include "header2.php";
            include "views/modules/$ruta.php";
            include "footer.php";
        }else{
            echo "Ocurrio un error";
        }
    }else{
        include "views/modules/login.php";
    }
?>