<?php 
    echo form_open(site_url('CHome/loadPrestamosLibro'));
    //echo "<form action='".site_url()."/CHome/loadPrestamosLibro/' method='post'>";
    echo "<label for='libros'>Escoge un libro </label>";
    echo "<select name='libros' id='libros'>";
    foreach ($librosTitulo as $titulo) {
        echo "<option value='".$titulo['TITULO']."'>".$titulo['TITULO']."</option>";
    }
    echo "</select>";
    echo " <input type='submit' value='VER PRESTAMOS'>";
    echo form_close(); 
?>