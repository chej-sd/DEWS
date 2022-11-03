<?php 
include 'cabecera.php';
include 'funciones.php';
if (!isset($_SESSION['usuario'])) {
    $_SESSION['ultimaPagina'] = $_SERVER["REQUEST_URI"];
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    //NOMBRE
    $nombreItem = ucfirst(obtenerNombre($id));      //Pedimos el nombre a la función que previamante hemos hecho y pasamos la primera letra a mayusculas.
    echo "<h1>$nombreItem</h1>";
    //SUBTITULO NUMERO DE PUJAS | PRECIO ACTUAL | FECHA FIN PARA PUJAR
    $numPujas = obtenerCantidadPujas($id);
    $precioMax = obtenerPrecioMax($id);
    $fechaFin = obtenerFechaFin($id);
    echo "<p><strong>Número de pujas: </strong>$numPujas <strong> - Precio Actual: </strong>$precioMax € <strong>- Fechafin para pujar: </strong>$fechaFin</p>";
    //IMAGENES
    $arrImg = obtenerArrImg($id);
    echo "<tr>";
    if ($arrImg != null) {
        foreach ($arrImg as $imagen) {
            if ($imagen != null) {
                echo "<td><img src='./$imagen' width = '250' height='250'> </td> ";
            }
        }
    }else {
        echo "<td>NO SE ENCONTRARON IMAGENES</td>";
    }
    echo "</tr>";
    //DESCRIPCION
    $descripcion = ucfirst(obtenerDescripcion($id));    
    echo "<p>$descripcion</p>";
}
//PUJAR
echo "<h1>Puja por este item</h1>";
if (!isset($_SESSION['usuario'])) { 
    echo "<p>Para pujar por este item, <a href='login.php'>registrate!</a></p>";
    
}else { 
    echo "<form action='itemdetalles.php?id=$id' method='post'>";
    echo "<p>Añade tu puja en el cuadro inferior:</p>";
    echo "<table>";
        echo "<tr>";
            echo "<td> <input type='number' name='puja' required> </td>";
            echo "<td> <input type='submit' name='submitPuja' value='¡Puja!''></td>";
            $user = $_SESSION['id']; //SACO EL USER DE NUEVO POR SI NO ESTABA REGISTRADO, EL METODO USA EL ID DE UN ARTICULO PARA PILLAR EL ID DEL USUARIO Y DE AHÍ PILLAR EL NAME
            $idUser = $_SESSION['id'];
            $id_item = $id;
            $pujasDiaUser = obtenerTotalPujasUserAlDia($idUser, $id_item);
            if (isset( $_POST['submitPuja'] )) {
                //SI PUJA POR UN PRECIO MENOR
                $precioMax = obtenerPrecioMax($id);
                if ($precioMax > $_POST['puja']) {
                    echo "<td style='color:red'>¡Puja muy baja!</td>";
                }elseif ($pujasDiaUser > 3) {
                    echo "<td style='color:red'>Límite de 3 pujas por día</td>";
                }else {
                    $precio = $_POST['puja'];
                    $seInserto = insertarPuja($id, $idUser, $precio);
                    if ($seInserto == false) {
                        echo "La puja no se pudo insertar.";
                    }
                }
                header('Location: itemdetalles.php?id='.$id);
            }
            echo "</tr>";
            echo "</table></form>";
            echo "<h1>Historial de puja</h1>";
            $arrPujasUserPrecio = obtenerUserPrecioPuja($id);   //SACA LOS NOMBRES DE LOS USUARIOS Y LOS PRECIOS DE LO PUJADO MEDIANTE EL METDO QUE HE HECHO.
            echo "<ul>";
            foreach ($arrPujasUserPrecio as $pujaUserPrecio) { 
                echo "<li>$pujaUserPrecio</li>";
            }
            echo "</ul>";
            
        
}


?>








