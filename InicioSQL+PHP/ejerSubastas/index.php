<?php       //ESTA PAGINA LA HICE AL PRINCIPIO, CUANDO NO TENIA EL FICHERO DE FUNCIONES CREADO X ESO SE VE TAN FEA.
    require('cabecera.php');
    include 'funciones.php';    //Se lo pongo ahora para una funcicion.
    echo "<h1>Items disponibles</h1>";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $consulta = "SELECT * FROM ITEMS WHERE ID_CAT = $id";
        $ejecutar = $con -> query($consulta);
    }else {
        $consulta = "SELECT * FROM ITEMS";
        $ejecutar = $con -> query($consulta);
    }
    echo "<table>";
    echo "<tr>";
        echo "<th>IMAGEN</th>";
        echo "<th>ITEM</th>";
        echo "<th>PUJAS</th>";
        echo "<th>PRECIO</th>";
        echo "<th>PUJAS HASTA</th>";
    echo "</tr>";

    //PILLO LAS IDS Y VOY HACIENDO LAS CONSULTAS.
    if ($ejecutar) {
        while ($fila = mysqli_fetch_assoc($ejecutar)){
            $item_id = $fila['id'];
            //CONSULTAS
            $consultaImg = "SELECT IMAGEN FROM IMAGENES WHERE ID_ITEM = $item_id";
            $resultImg = mysqli_query($con, $consultaImg);
            //CANTIDAD
            $consultaPujas = "SELECT COUNT(*) FROM PUJAS WHERE ID_ITEM = $item_id";
            $resultPujas = mysqli_query($con, $consultaPujas);
            //PRECIO
            $consultaPrecio = "SELECT PRECIOPARTIDA FROM ITEMS WHERE ID = $item_id";
            $resultPrecio = mysqli_query($con, $consultaPrecio);
            //FECHAFIN
            $consultaFechaFin = "SELECT FECHAFIN FROM ITEMS WHERE ID = $item_id";
            $resultFechaFin = mysqli_query($con, $consultaFechaFin);
            //SI EL NUMERO DE PUJAS ES 0 SACAMOS EL PRECIO MAXIMO
            $consultaMaxCantidad = "SELECT MAX(CANTIDAD) FROM PUJAS WHERE ID_ITEM = $item_id";
            $resultMaxCantidad = mysqli_query($con, $consultaMaxCantidad);
            echo "<tr>";
            //SACAMOS LOS RESULTADOS.
            $imagen = mysqli_fetch_assoc($resultImg);
            $fecha = mysqli_fetch_assoc($resultFechaFin);
            $precio = mysqli_fetch_assoc($resultPrecio);
            $pujas = mysqli_fetch_assoc($resultPujas);
            $precioMax = mysqli_fetch_assoc($resultMaxCantidad);
                //SI TODO DEVUELVE ALGO SIGNIFICA QUE QUEREMOS MOSTRAR LA IMAGEN.
                if ($imagen != null) {
                    echo "<td> <img src='imagenes/".$imagen['IMAGEN'].".jpg' width = '150'></td>";
                    
                    // APARTADO PARA EL BOTON EDITAR | ESTA COMENTADO XK ME QUEDE AQUI.
                    //if(isset($_SESSION['usuario']) == true) {
                    //    $idUser = $_SESSION['id'];   
                    //    $todoBn = esSuyo($idUser, $item_id);
                    //    if ($todoBn == true) {
                    //        echo "<td><a href='itemdetalles.php?id=$item_id'>".$fila['nombre']."</a><a href='editaritem.php?id=$item_id'> [EDITAR] </a></td>";
                    //    }
                    //}else {
                        echo "<td><a href='itemdetalles.php?id=$item_id'>".$fila['nombre']."</a></td>";
                    //}


                    if ($pujas != null && $pujas['COUNT(*)'] != 0) {
                        echo "<td>".$pujas['COUNT(*)']."</td>";
                        echo "<td>".$precioMax['MAX(CANTIDAD)']."€</td>";
                    }else {
                        echo "<td>0</td>";
                        echo "<td>".$precio['PRECIOPARTIDA']."€</td>";
                    }
                    echo "<td>".$fecha['FECHAFIN']."</td>";
                }else {
                    echo "<td>NO IMAGEN</td>";

                    // APARTADO PARA EL BOTON EDITAR | ESTA COMENTADO XK ME QUEDE AQUI.
                    //if(isset($_SESSION['usuario']) == true) {
                    //    $idUser = $_SESSION['id'];   
                    //    $todoBn = esSuyo($idUser, $item_id);
                    //    if ($todoBn == true) {
                    //        echo "<td><a href='itemdetalles.php?id=$item_id'>".$fila['nombre']."</a><a href='editaritem.php?id=$item_id'> [EDITAR] </a></td>";
                    //    }
                    //}else {
                        echo "<td><a href='itemdetalles.php?id=$item_id'>".$fila['nombre']."</a></td>";
                    //}
                    if ($pujas != null && $pujas['COUNT(*)'] != 0) {
                        echo "<td>".$pujas['COUNT(*)']."</td>";
                        echo "<td>".$precioMax['MAX(CANTIDAD)']."€</td>";
                    }else {
                        echo "<td>0</td>";
                        echo "<td>".$precio['PRECIOPARTIDA']."€</td>";
                    }
                    echo "<td>".$fecha['FECHAFIN']."</td>";
                }
            echo "</tr>";
        }
        echo "</table>";
    }
    

    
?>