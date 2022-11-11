<?php
    echo "<table>";
        echo "<tr>";
            echo "<th>LIBROS PRESTADOS EL DÍA $elDia</th>";
            if (count($arrTitulosDia) <= 0 ) {
                echo "<td>";
                    echo "<p style='color:red;'>NO HAY PRESTAMOS</p>";
                echo "</td>";
            }
            foreach ($arrTitulosDia as $titulo) {
                    echo "<td>";
                        echo "<p style='color:green;'>".$titulo['TITULO']."</p>";
                    echo "</td>";
                
            }
        echo "</tr>";
    echo "</table>";
?>