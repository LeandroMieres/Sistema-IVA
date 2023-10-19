<?php
require_once("./config/app.php");
require_once("./autoload.php");
require_once("./APP/View/inc/session.php");

if(isset($_GET['views'])) {
    $url = explode("/", $_GET['views']);
}else{
    $url = ["login"];
}
?>
<!-- VISUALIZAR EN PANTALLA -->
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once("./APP/View/inc/head.php"); ?>
</head>
<body>
    <?php

    use APP\Controller\VistaControlador;

    $VistaControlador = new VistaControlador();
    $vista = $VistaControlador->ControlVistaControlador($url[0]); // EN LA POSICION CERO MUESTRA LAS VISTAS

    if($vista == "login" || $vista == "404"){
        require_once("./APP/View/Content/".$vista.".php");
    }else{
        /* INGRESAR PARTES DE COGIDOS ACA */

        require_once($vista);
    } 
    require_once("./APP/View/inc/script.php");
    ?>
</body>
</html>