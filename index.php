
<html>
    <head>
        <title>Registro de Egresados</title>
    </head>
    <body align="center">
    <font face="Courier">
        <h1>REGISTRO EGRESADOS <br> -INICIO-</h1>
        <h2>LOGIN ADMINISTRADOR</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <table align="center">
                <tbody>
                    <tr>
                        <td>
                            <label for="usuario"> Nombre de Usuario:</label>
                        </td>
                        <td>
                            <input type="text" name="usuario" required>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                        <label for="contrasena" >Contraseña:</label>
                        </td>
                        <td>
                            <input type="password" id="contrasena"name="contrasena" required>
                        </td>
                    </tr>
                    
                </tbody>
                <tfoot align="center">
                    <tr>
                        <td colspan="2">
                        <button type="submit" name="iniciar sesion">Conectar</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <form action="invitado.php"method="POST">
                <label for="invitado"><b>CONTINUAR COMO INVITADO: </b></label>
                <button type="submit" name="invitado">Aceptar</button>
        </form>
        <?php
            include './config.php';
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuario"]) && isset($_POST["contrasena"]))
            {
                $usuario = $_POST["usuario"];
                $_SESSION['user'] = $usuario;
                $contrasena = $_POST["contrasena"];
                $sql_verificar = "SELECT usuario,contrasena FROM administrador WHERE usuario = ?";
                if($consulta_verificar_guardar = mysqli_prepare($conexion,$sql_verificar)){
                    if(mysqli_stmt_bind_param($consulta_verificar_guardar,"s",$usuario)){
                        if(mysqli_stmt_execute($consulta_verificar_guardar)){
                            if($result = mysqli_stmt_get_result($consulta_verificar_guardar)){
                                if ($result){
                                    if (mysqli_num_rows($result)>0){
                                            header("Location: administrador.php");
                                            exit();
                                    }else{
                                        echo "Usuario o Contraseña Incorrectos";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        ?>
    </font></body>
</html>
