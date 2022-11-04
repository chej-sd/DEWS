<?php 
require('cabecera.php');
    if (isset($_GET['email']) && isset($_GET['cadenaVerf'])) {
        //LO VERIFICO AQUI YA QUE NO DA TIEMPO PARA HACER EL TEMA DEL EMAIL.
        $sql = "UPDATE USUARIOS SET ACTIVO=1, FALSO=0 WHERE EMAIL = '" . $_GET['email']."'";
        $result = $con->query($sql);
        if ($result === true) {
            echo "<p>Se ha verificado tu cuenta. Puedes entrar pinchando en <strong><a href='login.php'>log in</a></strong></p>";
        }else{
            echo "<p>No se puede verificar dicha cuenta</p>";
            die(mysqli_error($con));
        }
    }
?>