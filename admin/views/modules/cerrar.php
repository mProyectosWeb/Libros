<?php
    session_start();
    session_destroy();
    header("Location:". SERVER_URL ."");
    exit();
?>