<?php 
require('cabecera.php');
if (isset($_POST['submitRegistro'])) {
    
    $usuario = $_POST['usuario'];
    $ejecutar = $con -> query("SELECT * FROM USUARIOS WHERE USERNAME = $usuario");
    if (!$ejecutar) {
        $nombreCompleto = $_POST['nombreCompleto'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $result = mysqli_query($con, "SELECT MAX(id) FROM USUARIOS");
        $extraido= mysqli_fetch_array($result);
        $id = intval($extraido['MAX(id)']) + 1;     // SACAMOS EL NUMERO DE ID MÁS GRANDE Y LE SUMAMOS UNO PARA LA SIGUIENTE TUPLA.
        //STRING ALEATORIO
        $char_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; //CARACTERES PERMITIDOS
        $stringAleatorio = generar_string($char_permitidos, 16);
        
        //INSETAMOS LA TUPLA
        $sql = "INSERT INTO USUARIOS VALUES ('$id', '$usuario', '$nombreCompleto', '$password', '$email','$stringAleatorio', 0 , 1)";
        if (($resp = mysqli_query($con, $sql)) === false) {
            die(mysqli_error($con));
        }else {
            
            header('Location: verificacion.php?email=' . $email . '&cadenaVerf=' . $stringAleatorio);
        }
    
    }
    
}
function generar_string($input, $strength) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
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
    <div id="error">
    </div>
    <h1>REGISTRO</h1>
    <p>Para registrarse en <?php echo foroname ?>, rellena el siguiente formulario</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
        <table>
            <tr>
                <td>Usuario</td> 
                <td><input type="text" name="usuario" required></td>
            </tr>
            <tr>
                <td>Nombre completo</td> 
                <td><input type="text" name="nombreCompleto" required></td>
            </tr>
            <tr>
                <td>Password</td> 
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td>Password (de nuevo)</td> 
                <td><input type="password" name="passwordDeNuevo" required></td>
            </tr>
            <tr>
                <td>Email</td> 
                <td><input type="text" name="email" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submitRegistro" id="boton" value="Régistrate" >  </td>
            </tr>
        </table>
    </form>
    <script src="js/veriRegistro.js" language="Javascript"></script>
</body>
</html>