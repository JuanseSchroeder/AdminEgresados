<html>
    <head>
        <title>LISTADO EGRESADOS</title>
    </head>
    <body align="center"><font face="Courier">
    <h1>ADMINISTRADOR <br> -LISTADO EMAILS-</h1>
        <form action="administrador.php" method="POST">
            <table align="center">
                <tr >
                    <td ><b>Volver a Menu Administrador:</b></td>
                    <td ><input type="submit" name="submit" value="Volver"></td>
                </tr>
            </table>
        
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> "method="post">
            <table align="center" border='1'>
                <thead align='center'>
                    <tr>
                        <td colspan='2'>
                        <b>Agregar/Modificar Email:</b>
                        </td>
                    </tr>
                </thead>
                <tbody align='center'>
                <tr>
                    <td>
                        <label for="id_new_email">ID Email:</label>
                    </td>
                    <td>
                        <input type="text" id="id_new_email" name="id_new_email" required>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label for="new_email">Email:</label>
                    </td>
                <td>
                    <input type="email" id="new_email" name="new_email" required>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td align='center'colspan='2'>
                        <button type="submit" name="agregar">Agregar/Modificar</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table align='center' border='1'>
                <thead >
                    <tr>
                        <td align='center' colspan='2'>
                        <b>
                            Eliminar Email
                        </b>
                        </td>
                    </tr>
                </thead>

                <tbody align='center'>
                <tr>
                    <td>
                        <label for="id_email_eliminar">ID Email:</label>
                    </td>
                    <td>
                        <input type="text" id="id_email_eliminar" name="id_email_eliminar" required>
                    </td>
                </tr>
                </tbody>

                <tfoot>
                    <tr>
                        <td align='center'colspan='2'>
                        <button type="submit" name="eliminar">Eliminar</button>
                        </td>
                    </tr>
                </tfoot>

            </table>
        </form>

        <?php
            include './config.php';

            /* CARGAR EMAILS */

            if (isset($_POST["id_new_email"]) && isset($_POST["new_email"])) {

                $id_new_email = $_POST["id_new_email"];
                $email = $_POST["new_email"];
            
                $sql_guardar_email = "INSERT INTO emails (id_email, email) VALUES (?, ?) ON DUPLICATE KEY UPDATE email = VALUES(email)";
                
                if ($consulta_guardar_email = mysqli_prepare($conexion, $sql_guardar_email)) {
                    
                    
                    mysqli_stmt_bind_param($consulta_guardar_email, "is", $id_new_email, $email);
                    
                    
                    mysqli_stmt_execute($consulta_guardar_email);
                    
                    
                    mysqli_stmt_close($consulta_guardar_email);
                } else {
                    echo "Error al preparar la consulta: " . mysqli_error($conexion);
                }
            }
            

            /* ELIMINAR EMAILS */

            if (isset($_POST["id_email_eliminar"])){

                $id_email_eliminar = $_POST["id_email_eliminar"];

                $sql_eliminar_email = "DELETE FROM emails WHERE id_email = (?)";

                $consulta_eliminar_email = mysqli_prepare($conexion,$sql_eliminar_email);

                mysqli_stmt_bind_param($consulta_eliminar_email,"i",$id_email_eliminar);
                
                mysqli_stmt_execute($consulta_eliminar_email);


                $result = mysqli_stmt_get_result($consulta_eliminar_email);
            } 



            /* MIS EMAILS */

            $sql_emails = "SELECT * FROM emails;";

            $consulta_emails= mysqli_prepare($conexion,$sql_emails);
            
            mysqli_stmt_execute($consulta_emails);
            
            $result = mysqli_stmt_get_result($consulta_emails);
            
            echo " <table border='1' align='center'>";
            if ($result){
                if (mysqli_num_rows($result)>0){

                    echo "<thead><tr><td colspan='2' align='center'><font color='#008000'><b>MIS EMAILS</b></font></td></tr></thead>";
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tbody align='center'>";
                        echo "<tr>";
                        echo "<td>ID:</td>";
                        echo "<td>".$row['id_email']."</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td>EMAIL: </td>";
                        echo "<td>". $row['email'] ."</td>";
                        echo "</tr>";
                        echo "<tr><td colspan='2' bgcolor='#008000'></td></tr>";
                    }
                    
                }
            }
        ?>
    </font></body>