<?php 
if (count($librosPrestados)>0) { 
    echo "<h1>LIBROS PRESTADOS</h1>";
    echo "<ul>";
        foreach ($librosPrestados as $libroPrestado) {
            foreach ($libroPrestado as $libro) {
                echo "<li>".$libro."</li>";
            }
            
        }
    echo "</ul>";
}
if (count($librosNoPrestados)>0) { 
    echo "<h1>LIBROS NO PRESTADOS</h1>";
    echo "<ul>";
        foreach ($librosNoPrestados as $libroNoPrestado) {
            foreach ($libroNoPrestado as $libro) {
                echo "<li>".$libro."</li>";
            }
        }
    echo "</ul>";
}
?> 