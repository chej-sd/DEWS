<?php 
session_start();
require('cabecera.php');
include_once("config.php"); //INCLUIMOS EL ARCHIVO "config.php" PARA PODER USAR SUS VARIABLES.
if (isset($_POST['submitLogin'])) {
    $user = $_POST['usuario'];
    $psswd = $_POST['password'];
    $existe = false;
    //CONSULTAS
    $sql = "SELECT * FROM usuarios WHERE username = '".$user."' && password = '".$psswd."'";
    $result = mysqli_query($con, $sql);
    if (!$result) {
        echo mysqli_error($con);
    }
    while ($fila = mysqli_fetch_assoc($result)) {
        $existe = true;
        if ($fila['username'] == $user && $fila['password'] == $psswd && $fila['activo'] == 1) {
            $_SESSION['usuario'] = $user;
            $_SESSION['id'] = $fila['id'];
            if (isset($_SESSION['ultimaPagina'])) {
                header('Location: ' .$_SESSION['ultimaPagina']);
            }else {
                header('Location: index.php');
            }
        }else{
            echo "<p>Esta cuenta no esta verificada. Te hemos enviado un email para verificarte.</p>";
        }
    }
    if (!$existe) {
        echo "<p>Login incorrecto. Inténtalo de nuevo!</p>";
    }
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registro</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
    <table>
        <tr>
            <td>Usuario</td> 
            <td><input type="text" name="usuario" required></td>
        </tr>
        <tr>
            <td>Password</td> 
            <td><input type="password" name="password" required></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submitLogin" value="Login!">  </td>
        </tr>
    </table>
    </form>
    <p>No tienes una cuenta? <a href="registro.php"> <strong>Registrate</strong></a>!</p>
</body>
</html>