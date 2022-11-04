<?php 
    session_start();
    include_once("config.php"); //INCLUIMOS EL ARCHIVO "config.php" PARA PODER USAR SUS VARIABLES.
    //CREAMOS CONEXION CON LA BASE DE DATOS.
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASS);
    mysqli_select_db($con, DB_DATABASE);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo foroname?></title>
</head>
<body>
<div id="header">
        <h1>SUBASTAS CHEJ</h1>
</div>
    <div id="menu">
        <a href="index.php">Home</a>
        <?php
            if(isset($_SESSION['usuario']) == true) {
                echo "<a href='logout.php'>Logout</a>";
            }
            else {
                echo "<a href='login.php'>Login</a>";
            }
        ?>
        <?php
            //if(isset($_SESSION['usuario']) == true) { LO QUITO PK SI NO EL EJERCICIO NO TIENE SENTIDO
                echo "<a href='newitem.php'> Nuevo Item</a>";
            //}
        ?>
    </div>
    <div id="container">
        <div id="bar">
            <?php require("barra.php") ?>
        </div>
        <div id="main">
</body>
</html>