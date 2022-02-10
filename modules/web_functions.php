<?php

class WebFunctions {
  function redireccionar($ruta){
    echo '<script type="text/javascript">';
    echo 'location.href ="'.$this->direct_sistema().'/'.$ruta.'";';
    echo '</script>';
  }

  function direct_sistema(){
    $url_sistema = explode("/",$_SERVER["REQUEST_URI"]);
    $directorio_sistema = "/".$url_sistema[1];
    return $directorio_sistema;
  }

  function directorio_carpetas(){
    $root_sistema = $_SERVER["DOCUMENT_ROOT"];
    $url_sistema = explode("/",$_SERVER["REQUEST_URI"]);
    $directorio_folder = $root_sistema."/".$url_sistema[1];
    return $directorio_folder;
  }

  function direct_paginas(){
    $directorio = $this->direct_sistema()."/views/";
    return $directorio;
  }
  
}
?>