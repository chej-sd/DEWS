<?php 
    echo "<form action='".site_url()."/CHome/verPrestamos/$genero' method='post'>";
    echo "<table>";
    echo "<tr>";
        echo "<th></th>";
        echo "<th>LIBRO</th>";
        echo "<th>AUTOR</th>";
    echo "</tr>";
    foreach ($titulosYLibros as $fila)    {
        $titulo = $fila['titulo'];
        $nomAutor = $fila['nombre'];
        $idLibro = $fila['idlibro'];
        echo "<tr>";
            echo "<td><input type='checkbox'  name='cbox[]' id='$idLibro' value='$idLibro'></td>";
            echo "<td>$titulo</td>";
            echo "<td>$nomAutor</td>";
        echo "</tr>";
    }
    echo "<tr>";
        echo "<td colspan='3'><input type='submit' value='PRESTAR LIBROS'></td>";
    echo "</tr>";
    echo "</table>";
    echo "</form>";
?>