<?php 
include 'cabecera.php';
include 'funciones.php';
if (!isset($_SESSION['usuario'])) {
    $_SESSION['ultimaPagina'] = $_SERVER["REQUEST_URI"];
    header('Location: login.php');
}

if (isset($_POST['submitNewItem'])) {
    $mes = $_POST['meses'];
    $dias = $_POST['dias'];
    $todoCorrecto = true;
    $arrDiasMes = obtenerDiasMeses();
    /*switch ($mes) {   //Esto era para comprobar que me introduzca un dia y mes correctos.
        case '1':
            $maxDia = $arrDiasMes['enero'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '2':
            $maxDia = $arrDiasMes['febrero'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;   
        case '3':
            $maxDia = $arrDiasMes['marzo'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break; 
        case '4':
            $maxDia = $arrDiasMes['abril'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '5':
            $maxDia = $arrDiasMes['mayo'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break; 
        case '6':
            $maxDia = $arrDiasMes['junio'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '7':
            $maxDia = $arrDiasMes['julio'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '8':
            $maxDia = $arrDiasMes['agosto'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '9':
            $maxDia = $arrDiasMes['septiembre'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '10':
            $maxDia = $arrDiasMes['octubre'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '11':
            $maxDia = $arrDiasMes['noviembre'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
        case '12':
            $maxDia = $arrDiasMes['diciembre'];
            if ($maxDia < $dias) {
                echo "<p style='color:red;'>ERROR: El més y el día no concuerdan.</p>";
            }
            $todoCorrecto = false;
            break;
    }*/
    echo $todoCorrecto;
    print_r($todoCorrecto);
    
    if ($todoCorrecto == true) {
        //Sacamos el id del user, el id de categoria, el id del nuevo item
        $idUser = $_SESSION['id'];
        $idItem = sacarMaxIdItem() + 1;
        $idCat = sacarIdCatNombre($_POST['categorias']);
        $nomItem = $_POST['nombre'];
        $precioPart = $_POST['precio'];
        $desc = $_POST['areTxt'];
        $fechaFin = $_POST['anos']."-".$_POST['meses']."-".$_POST['dias']." ".$_POST['horas'].":".$_POST['mins'].":00";
        $bn = insertarItem($idItem,$idCat,$idUser,$nomItem,$precioPart,$desc,$fechaFin);
        if ($bn == false) {
            echo "<p style='color:red;'>ERROR: No se pudo insertar el nuevo item en la bbdd.</p>";
        }else {
            echo "<p style='color:green;'>Se ha insertado correctamente.</p>";
            header('Location: editaritem.php?id='.$idItem);
        }
    }else {
        "<p style='color:red;'> Algo ha salido mal...</p>";
    }
}
echo "<h1>Añade nuevo item</h1>";
echo "<form action='newitem.php' method='post'>";
echo "<table>";
//Categoria
$arrCat = obtenerCategorias();  //Llamamos al metodo que nos devuelve todas las categorias.
    echo "<tr>";
        echo "<td>Categoría</td>";
        echo "<td>";
            echo "<select name='categorias' id='categorias>";
                foreach ($arrCat as $categoria) {
                    echo "<option value='$categoria'>$categoria</option>";
                }
            echo "</select>";
        echo "</td>";
    echo "</tr>";
    //Nombre
    echo "<tr>";
        echo "<td>Nombre</td>";
        echo "<td>";
            echo "<input type='text' id='nombre' name='nombre' maxlength='50' required>"; //Max length a 50 como en la bbdd.
        echo "</td>";
    echo "</tr>";
    //Descripcion
    echo "<tr>";
        echo "<td>Descripcion</td>";
        echo "<td>";
            echo "<textarea id='areTxt' name='areTxt' rows='10' cols='42' maxlength='200' required></textarea>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td>Fecha de fin para pujas</td>";
        echo "<td>";
            echo "<table>";
                echo "<tr>";
                    echo "<td>Día</td>";
                    echo "<td>Mes</td>";
                    echo "<td>Año</td>";
                    echo "<td>Hora</td>";
                    echo "<td>Minutos</td>";
                echo "</tr>";
                    //Dias
                    echo "<td>";
                        echo "<select name='dias' id='dias>";
                            for ($i=0; $i <= 31; $i++) { 
                                echo "<option value='$i'>$i</option>";
                            }
                                
                        echo "</select>";
                    echo "</td>";
                    //Mes
                    echo "<td>";
                        echo "<select name='meses' id='meses>";
                            for ($i=0; $i <= 12; $i++) { 
                                echo "<option value='$i'>$i</option>";
                            }
                                
                        echo "</select>";
                    echo "</td>";
                    //Año
                    echo "<td>";
                    $anoActual = date("Y");
                        echo "<select name='anos' id='anos>";
                        for ($i=$anoActual; $i <= ($anoActual + 5); $i++) { 
                            echo "<option value='$i'>$i</option>";
                        }
                        echo "</select>";
                    echo "</td>";
                    //Hora
                    echo "<td>";
                        echo "<select name='horas' id='horas>";
                            for ($i=0; $i <= 23; $i++) { 
                                echo "<option value='$i'>$i</option>";
                            }
                                
                        echo "</select>";
                    echo "</td>";
                    //Minutos
                    echo "<td>";
                        echo "<select name='mins' id='mins>";
                            for ($i=0; $i <= 59; $i++) { 
                                echo "<option value='$i'>$i</option>";
                            }
                                
                        echo "</select>";
                    echo "</td>";
                echo "<tr>";
                echo "</tr>";
            echo "</table>";
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
    //Precio
    echo "<td>Precio</td>";
    echo "<td>";
            echo "<input type='number' id='precio' name='precio' required>"; 
        echo "</td>";
    echo "</tr>";
    echo "<tr>";
        echo "<td colspan='2'><input type='submit' name='submitNewItem' value='Enviar!' style='width:500px;'></td>";
    echo "</tr>";
echo "</table> </form>";
?>