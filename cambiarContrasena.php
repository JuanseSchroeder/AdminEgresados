<html>
    <head>
        <title>LISTADO EGRESADOS</title>
    </head>
    <body align="center"><font face="Courier">
    <h1>ADMINISTRADOR <br> -CAMBIAR CONTRASEÑA-</h1>
        <form action="administrador.php" method="POST">
            <table align="center">
                <tr >
                    <td ><b>Volver a Menu Administrador:</b></td>
                    <td ><input type="submit" name="submit" value="Volver"></td>
                </tr>
            </table>
        
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <table align="center">
                <tbody>
                <tr>
                    <td>
                    <label for="old_pass">Contraseña Anterior:</label>
                    </td>
                    <td>
                    <input type="password" id="old_pass" name="old_pass" required>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label for="new_pass">Contraseña Nueva:</label>
                    </td>
                    <td>
                    <input type="password" id="new_pass" name="new_pass" required>
                    </td>
                </tr>
                </tbody>


                <tfoot>
                    <tr>
                        <td align='center'colspan='2'>
                        <button type="submit" name="cambiar">Cambiar</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <?php
            include './config.php';
            
            

            if (isset($_POST["new_pass"]) && (isset($_POST["old_pass"]))){
                
                
                $new = $_POST["new_pass"];
                $old = $_POST["old_pass"];

                $sql_old_pass = "UPDATE administrador SET contrasena = (?) WHERE contrasena = (?) AND usuario = (?)";

                $consulta_cambiar = mysqli_prepare($conexion,$sql_old_pass);

                mysqli_stmt_bind_param($consulta_cambiar,"sss",$new,$old,$_SESSION['user']);
                
                (mysqli_stmt_execute($consulta_cambiar));
                

                $result = mysqli_stmt_get_result($consulta_cambiar);
            } 
        ?>
    </font></body>