<?php
    include 'funciones.php';    //Para la funcion que hice.
    if (isset($_GET['img']) && isset($_GET['idItem'])) {   //Esto lo pongo x seacaso pero va a entrar si o si, si no, no llegaría aquí.
        $idItem = $_GET['idItem'];
        //La imagen nos la da en ruta completa hay que acortarla.
        $imagen = $_GET['img'];
        $imagen = explode("/", $imagen);    
        $imgAux = $imagen[1];   //sjdhsjhdj.jpg
        $imgAux = explode(".", $imgAux);
        $imgFinal = $imgAux[0]; //sjdhsjhdj sin el jpg      //Se podria hacer con un substring pero weno.
        $todoBn = eliminaImg($imgFinal);
        if ($todoBn == null){
            echo "aaaa todo mal";
        }
        if ($todoBn) {
            header('Location: editaritem.php?'.$idItem);
        }
    }
    echo "fallo al entrar al get.";
?>