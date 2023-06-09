<?php 
    require_once './models/libros.models.php';

    class ControllersUsuarios{
        public static function getLibros(){
            return Modelslibros::getLibros();
        }
    }


?>