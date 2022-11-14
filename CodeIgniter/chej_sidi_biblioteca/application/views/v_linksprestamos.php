<?php
        echo "<ul>"; 
        foreach ($prestamo as $fila)    {
            $numero = $fila['IDPRESTAMO'];
            $fecha = $fila['FECHA']; 
            $titulo = $fila['TITULO'];  
            echo "<li>Prestamo del libro $titulo Nº $numero: $fecha <a href='".base_url()."index.php/CHome/guardarLibrosADevolver/$numero'>Devolver</a></li>";

        }
        echo "</ul>";
        $librosAEliminar = $this->session->userdata("elimLib");
        if ($librosAEliminar != null) {
            print_r($librosAEliminar);
        }
        echo "<br><a href='".base_url()."index.php/CHome/borrarLibrosSesion/'>GRABAR DEVOLUCIONES</a>";
        $librosBorrados = $this->session->userdata("contLibBorrados");
        if ($librosBorrados != null || $librosBorrados != 0) {
            echo "<br>Se han realizado $librosBorrados devoluciones";
        }
?>