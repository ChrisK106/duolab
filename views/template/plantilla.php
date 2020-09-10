<?php

$url_sistema = explode("/", $_SERVER["REQUEST_URI"]);
$directorio_sistema = "/" . $url_sistema[1];
$root_sistema = $_SERVER['DOCUMENT_ROOT'] . $directorio_sistema;

if (isset($_GET["url"])) {
    
    //CABECERA DEL SISTEMA
    include($root_sistema . "/views/template/header.php");

    $url = explode("/", $_GET["url"]);

    $url_complete = "";

    if(array_key_exists(2,$url)){
        $folder = $url[1];
        $pagname = $url[2];
        $url_complete = $folder . "/" . $pagname;
    } else {
        $pagname = $url[1];
        $url_complete = $pagname;
    }

    include($root_sistema . "/views/" . $url_complete . ".php");

    //PIE DE PAGINA DEL SISTEMA
    include($root_sistema . "/views/template/footer.php");

    $funciones = new Funciones();
    $ruta_file_js = $funciones->direct_sistema()."/ajax/".$pagname.".js";

    //RUTA RELATIVA DEL ARCHIVO AJAX
    $ruta_rel_file = $funciones->directorio_carpetas()."/ajax/".$pagname.".js";

    //VALIDAR SI ARCHIVO JS EXISTE
    if(file_exists($ruta_rel_file)){
      echo '<script src="'.$ruta_file_js.'"></script>';
    }

} else {
    include($root_sistema . "/views/login-sistema.php");
}