<?php 
include 'cabecera.php';
include 'funciones.php';
if (isset($_GET['id'])) {   //PARA QUE ME GUARDE EL ID DEL IETM EN SESION.
    $id = $_GET['id'];
    $_SESSION['idItem'] = $_GET['id'];
}
//SACO EL ID DEL ITEM
$id = $_SESSION['idItem'];
//SACO A VER SI HAY PUJAS DE ESE ITEM
$hayPujas = obtenerPujasItem($id);
if ($hayPujas == false) {   //SI NO TIENE PUJAS LE MOSTRAMOS ESTE APARTADO
    $nomItem = obtenerNombre($id);
$precioPartida = obtenerPrecioPartida($id);
$fechaFin = new DateTime(obtenerFechaFin($id));
$fechaFin = date_format($fechaFin, 'd/M/Y H:iA');    //SACO LA FECHA Y LE DOY FORMATO, LA A ES PARA AM/PM
if (isset($_POST['submitBajar'])) { //PARA BAJAR EL PRECIO
    $valor = $_POST['restSum'];
    $todoBn = bajarPrecio($id, $valor); //LLAMO AL METODO PARA QUE ME LO ACTUALICE EN LA BBDD.
    if ($todoBn == true) {
        $precioPartida -= $valor;
    }
}
if (isset($_POST['submitSubir'])) { //PARA SUBIR EL PRECIO
    $valor = $_POST['restSum'];
    $todoBn = subirPrecio($id, $valor); //LLAMO AL METODO PARA QUE ME LO ACTUALICE EN LA BBDD.
    if ($todoBn == true) {
        $precioPartida += $valor;
    }
}
if (isset($_POST['submitPos1h'])) {
    $todoBn = pos1h($id);
    if ($todoBn == true) {
        $x = new DateTime(obtenerFechaFin($id));
        $fechaFin = $x -> format('Y-m-d H:i:sA');
    }
}
if (isset($_POST['submitPos1d'])) {
    $todoBn = pos1d($id);
    if ($todoBn == true) {
        $x = new DateTime(obtenerFechaFin($id));
        $fechaFin = $x -> format('Y-m-d H:i:sA');
    }
}
?>
<h1><?php echo $nomItem; ?></h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <table>
        <tr>
            <td><strong>Precio de salida: </strong> <?php echo $precioPartida; ?>€</td> 
            <td>
                <input type="number" name="restSum" required>
                <input type="submit" name="submitBajar" value="BAJAR">
                <input type="submit" name="submitSubir" value="SUBIR">
            </td>
        </tr>
        <tr>
            <td><strong>Fecha fin para pujar: </strong> <?php echo $fechaFin; ?></td> 
            <td>
                <input type="submit" name="submitPos1h" value="POSPONER 1 HORA">
                <input type="submit" name="submitPos1d" value="POSPONER 1 DIA">
            </td>
        </tr>
    </table>
    </form>
<?php 
}
?>
<h1>Imagenes actuales</h1>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
    <table>
        <tr>
            <td>Imagen a subir</td>
            <td><input name="archivo" id="archivo" type="file" required/></td>
        </tr>
        <tr>
            <td><input type="submit" name="subir" value="Subir imagen"/></td>
            
        </tr>
    </table>
</form>
<?php 
$numImgs = obtenerContImg($id);
if ($numImgs == 0) {
    echo "<p>No hay imágenes del item.</p>";
}else {
    $arrImgs = obtenerArrImg($id);
    echo "<table>";
    foreach ($arrImgs as $imagen) {
        if ($imagen != null) {
            echo "<tr>";
            echo "<td><img src='./$imagen' width = '250' height='250'></td>";
            echo "<td><a href='eliminaImg.php?img=$imagen&idItem=$id'>[BORRAR]</a></td> ";
            echo "</tr>";
        }
    }
    echo "</table>";
}

//SUBIMOS LA IMGEN
if (isset($_POST['subir'])) {
    //Recogemos el archivo enviado por el formulario
    $imagen = $_FILES['archivo']['name'];
    $ruta = "./imagenes/" . $_FILES['archivo']['name']; 
    $resultado = @move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta);
    if($resultado)
    {
        $imagen = explode(".", $imagen);
        $imagen = $imagen[0];
        $todoBn = subirImgBBDD($imagen,$id);
        if ($todoBn != null) {
            header('Location: editaritem.php?'.$id);    //Refresco la pagina para ver la imagen.
        }else {
            echo "<p style='color:red;'>error en sql</p>";
        }

    }
}
?>



