<?php
include_once("config.php");
//CREAMOS CONEXION CON LA BASE DE DATOS.
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
mysqli_select_db($con, DB_DATABASE);
//Obtener categorias
function obtenerDiasMeses() {
    $diasMeses = array (
        "enero" => 31,
        "febrero" => 28,
        "marzo" => 31,
        "abril" => 30,
        "mayo" => 31,
        "junio" => 30,
        "julio" => 31,
        "agosto" => 31,
        "septiembre" => 30,
        "octubre" => 30,
        "noviembre" => 30,
        "diciembre" => 31
    );
    return $diasMeses;
}
function pos1h($id){   
    GLOBAL $con; 
    $fecha = new DateTime(obtenerFechaFin($id));
    $fecha = $fecha -> modify("+1 hours");
    $txt = date_format($fecha,'Y-m-d H:i:s');
    $consultaItem = "UPDATE ITEMS SET FECHAFIN = '$txt' WHERE ID = $id";
    if (($resp = mysqli_query($con, $consultaItem)) === false) {
        die(mysqli_error($con));
    }else {
        echo "<script>console.log('Todo perfe, se le sumo 1h.');</script>";
        return true;
    }
}
function pos1d($id){      
    GLOBAL $con; 
    $fecha = new DateTime(obtenerFechaFin($id));
    $fecha -> modify("+1 day");
    $fechaAux = $fecha -> format("Y-m-d H:i:s");
    $consultaItem = "UPDATE ITEMS SET FECHAFIN = '$fechaAux' WHERE ID = $id";
    if (($resp = mysqli_query($con, $consultaItem)) === false) {
        die(mysqli_error($con));
    }else {
        echo "<script>console.log('Todo perfe, se le sumo 1d.');</script>";
        return true;
    }
}
function bajarPrecio($id, $valor){
    GLOBAL $con; 
    $precioActual = obtenerPrecioPartida($id);
    $precioActual -= $valor;
    $consultaItem = "UPDATE ITEMS SET PRECIOPARTIDA = $precioActual WHERE ID = $id";
    if (($resp = mysqli_query($con, $consultaItem)) === false) {
        die(mysqli_error($con));
    }else {
        echo "<script>console.log('Item actualizado (bajada de precio).');</script>";
        return true;
    }
}
function subirPrecio($id, $valor){
    GLOBAL $con; 
    $precioActual = obtenerPrecioPartida($id);
    $precioActual += $valor;
    $consultaItem = "UPDATE ITEMS SET PRECIOPARTIDA = $precioActual WHERE ID = $id";
    if (($resp = mysqli_query($con, $consultaItem)) === false) {
        die(mysqli_error($con));
    }else {
        echo "<script>console.log('Item actualizado (subida de precio).');</script>";
        return true;
    }
}
function obtenerCategorias() {
    GLOBAL $con; 
    $consultaCat = "SELECT CATEGORIA FROM TEMAS";
    $resultCat = mysqli_query($con, $consultaCat);
    $arrCat = [];
    foreach($resultCat as $fila){ 
        array_push($arrCat, $fila['CATEGORIA']);
    }
    return $arrCat;
}
function obtenerPujasItem($id) {
    GLOBAL $con; 
    $consultaPujas = "SELECT COUNT(*) FROM PUJAS WHERE ID_ITEM = $id";
    $resultPujas = mysqli_query($con, $consultaPujas);
    $pujas = mysqli_fetch_assoc($resultPujas);
    if ($pujas['COUNT(*)'] > 0) {
        return true;
    }
    return false;
}
function obtenerCantidadPujas($id) {
    GLOBAL $con; 
    $consultaPujas = "SELECT COUNT(*) FROM PUJAS WHERE ID_ITEM = $id";
    $resultPujas = mysqli_query($con, $consultaPujas);
    $pujas = mysqli_fetch_assoc($resultPujas);
    return $pujas['COUNT(*)'];
}
function obtenerTotalPujasUserAlDia($idUser, $idItem) {
    GLOBAL $con; 
    $consultaPujas = "SELECT COUNT(*) FROM PUJAS WHERE ID_USER = $idUser  AND fecha = date_format(sysdate(),'%Y-%m-%d') AND ID_ITEM = $idItem";
    $resultPujas = mysqli_query($con, $consultaPujas);
    $pujas = mysqli_fetch_assoc($resultPujas);
    return $pujas['COUNT(*)'];
}
function insertarPuja($id_item, $id_user, $precio) { 
    GLOBAL $con; 
    $idPuja = sacarMaxIdPuja() + 1; //SACO LA ID QUE LE VOY A ASIGNAR A LA NUEVA PUJA
    $fechaActual = date('Y-m-d');
    $consultaPujas = "INSERT INTO PUJAS VALUES ('$idPuja', '$id_item', '$id_user', '$precio', '$fechaActual')";
    if (($resp = mysqli_query($con, $consultaPujas)) === false) {
        die(mysqli_error($con));
    }else {
        echo "<script>console.log('La puja ha sido insertada.');</script>";
        return true;
    }
}
function esSuyo($id_user,$id_item) {
    GLOBAL $con; 
    $consulta = "SELECT * FROM ITEMS WHERE ID = $id_item AND ID_USER = '$id_user'";
    if (($resp = mysqli_query($con, $consulta)) === false) {
        die(mysqli_error($con));
    }else {
        return true;
    }
}
function eliminaImg($nomImg) {
    GLOBAL $con; 
    $consulta = "DELETE FROM IMAGENES WHERE IMAGEN='$nomImg'";
    if (mysqli_query($con, $consulta)) {
        return true;
    }else {
        return false;
    }
}
function subirImgBBDD ($nom,$id_item) {
    GLOBAL $con; 
    $sacoMaxId = sacarMaxIdImg();
    $sacoMaxId ++;
    $consultaImg = "INSERT INTO IMAGENES VALUES ('$sacoMaxId', '$id_item', '$nom')";
    if (($resp = mysqli_query($con, $consultaImg)) === false) {
        echo "<script>console.log('No se pudo insertar la imagen.');</script>";
        return false;
    }else {
        return true;
    }
}
function insertarItem($id_item, $id_cat, $id_user, $nom, $precio, $desc, $fecha) { 
    GLOBAL $con; 
    $consultaItem = "INSERT INTO ITEMS VALUES ('$id_item', '$id_cat', '$id_user', '$nom', '$precio', '$desc', '$fecha')";
    if (($resp = mysqli_query($con, $consultaItem)) === false) {
        return false;
    }else {
        echo "<script>console.log('El item ha sido insertado.');</script>";
        return true;
    }
}
function sacarIdCatNombre($nomCat) {
    GLOBAL $con; 
    $consulta = "SELECT ID FROM CATEGORIAS WHERE CATEGORIA = '$nomCat'";
    $result= mysqli_query($con, $consulta);
    $idCat = mysqli_fetch_assoc($result);
    return $idCat['ID'];
}
function sacarMaxIdItem() {
    GLOBAL $con; 
    $consulta = "SELECT MAX(ID) FROM ITEMS";
    $result= mysqli_query($con, $consulta);
    $idMax = mysqli_fetch_assoc($result);
    return $idMax['MAX(ID)'];
}
function sacarMaxIdPuja() {
    GLOBAL $con; 
    $consulta = "SELECT MAX(ID) FROM PUJAS";
    $result= mysqli_query($con, $consulta);
    $idMax = mysqli_fetch_assoc($result);
    return $idMax['MAX(ID)'];
}
function sacarMaxIdImg() {
    GLOBAL $con; 
    $consulta = "SELECT MAX(ID) FROM IMAGENES";
    $result= mysqli_query($con, $consulta);
    $idMax = mysqli_fetch_assoc($result);
    return $idMax['MAX(ID)'];
}
function obtenerUserPrecioPuja($id) {
    GLOBAL $con; 
    $consultaCantUserPujas = "SELECT SUM(CANTIDAD), ID_USER FROM PUJAS WHERE ID_ITEM = $id GROUP BY ID_USER";
    $result = mysqli_query($con, $consultaCantUserPujas);
    $arrUserPrecios = [];
    foreach($result as $fila){
        $nombre = obtenerUsernameConId($fila['ID_USER']);
        array_push($arrUserPrecios, "$nombre - ".$fila['SUM(CANTIDAD)']."€");
    }
    return $arrUserPrecios;
}
function obtenerTotalPujasUser($id, $username) {
    GLOBAL $con; 
    $consultaPujas = "SELECT COUNT(*) FROM PUJAS, USUARIOS WHERE ID_USER = $id AND USERNAME = $username";
    $resultPujas = mysqli_query($con, $consultaPujas);
    $pujas = mysqli_fetch_assoc($resultPujas);
    return $pujas['COUNT(*)'];
}
function obtenerUsernameConId($id){
    GLOBAL $con; 
    $consultaUsername = "SELECT USERNAME FROM USUARIOS WHERE ID = (SELECT ID_USER FROM ITEMS WHERE ID = $id) ";
    $resultUsername = mysqli_query($con, $consultaUsername);
    $nombre = mysqli_fetch_assoc($resultUsername);
    return $nombre['USERNAME'];
}
function obtenerIdUserConId($id){
    GLOBAL $con; 
    $consultaUsername = "SELECT ID FROM USUARIOS WHERE ID = (SELECT ID_USER FROM ITEMS WHERE ID = $id) ";
    $resultUsername = mysqli_query($con, $consultaUsername);
    $nombre = mysqli_fetch_assoc($resultUsername);
    return $nombre['ID'];
}
function obtenerPrecioPartida($id) {
    GLOBAL $con; 
    $consulta = "SELECT PRECIOPARTIDA FROM ITEMS WHERE ID = $id";
    $resultPrecio = mysqli_query($con, $consulta);
    $precioPart = mysqli_fetch_assoc($resultPrecio);
    return $precioPart['PRECIOPARTIDA'];
}
function obtenerPrecioMax($id) {
    GLOBAL $con; 
    $consultaMaxCantidad = "SELECT MAX(CANTIDAD) FROM PUJAS WHERE ID_ITEM = $id";
    $resultMaxCantidad = mysqli_query($con, $consultaMaxCantidad);
    $precioMax = mysqli_fetch_assoc($resultMaxCantidad);
    return $precioMax['MAX(CANTIDAD)'];
}
function obtenerFechaFin($id) {
    GLOBAL $con; 
    $consultaFechaFin = "SELECT FECHAFIN FROM ITEMS WHERE ID = $id";
    $resultFechaFin = mysqli_query($con, $consultaFechaFin);
    $fecha = mysqli_fetch_assoc($resultFechaFin);
    return $fecha['FECHAFIN'];
}
function obtenerContImg($id) {
    GLOBAL $con; 
    $consultaImg = "SELECT COUNT(IMAGEN) FROM IMAGENES WHERE ID_ITEM = $id";
    $resultImg = mysqli_query($con, $consultaImg);
    $cont = mysqli_fetch_assoc($resultImg);
    return $cont['COUNT(IMAGEN)'];
}
function obtenerArrImg($id) {
    GLOBAL $con; 
    $rutas = array();
    $consultaImg = "SELECT IMAGEN FROM IMAGENES WHERE ID_ITEM = $id";
    $resultImg = mysqli_query($con, $consultaImg);
    while ($imagen = mysqli_fetch_row($resultImg)) {
        if ($imagen == null) {
            array_push($rutas, null);
        }else {
            array_push($rutas, "imagenes/".$imagen[0].".jpg");
        }
    }
    return $rutas;
}
function obtenerDescripcion($id) {
    GLOBAL $con; 
    $consultaDesc = "SELECT DESCRIPCION FROM ITEMS WHERE ID = $id";
    $resultDesc = mysqli_query($con, $consultaDesc);
    $descripcion = mysqli_fetch_assoc($resultDesc);
    return $descripcion['DESCRIPCION'];

}
function obtenerNombre($id) {
    GLOBAL $con; 
    $consultaDesc = "SELECT NOMBRE FROM ITEMS WHERE ID = $id";
    $resultDesc = mysqli_query($con, $consultaDesc);
    $descripcion = mysqli_fetch_assoc($resultDesc);
    return $descripcion['NOMBRE'];
}
?>