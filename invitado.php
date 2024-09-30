<html>
    <head>
        <title>Invitado</title>
    </head>
    <?php
        include './config.php';
    ?>
    <body align="center"><font face="Courier">
        <h1>INVITADO - REGISTRO EGRESADOS</h1>
        <form action="index.php" method="POST">
            <table align="center">
                <tr >
                    <td ><b>Volver a Inicio:</b></td>
                    <td ><input type="submit" name="submit" value="Volver"></td>
                </tr>
            </table>
        
        </form>
        <h2>CARGAR/MODIFICAR INFO DE EGRESADO</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table align="center">
                <tbody>
                <tr>
                    <td align="center" valign="top"><label for="nombre">Nombre:</label></td>
                    <td><input type="text" id="nombre" name="nombre" required><br><br></td>
                </tr>
                <tr>
                    <td align="center" valign="top"><label for="apellido">Apellido:</label></td>
                    <td><input type="text" id="apellido" name="apellido" required><br><br></td>
                </tr>
                
                <tr>
                    <td align="center" valign="top"><label for="carrera">Carrera:</label></td>
                    <td>
                        <select name='carrera'>
                        <?php
                        
                            $sql_mostrar_carreras= "SELECT id,carrera FROM carreras";

                            $consulta_mostrar_carreras = mysqli_prepare($conexion,$sql_mostrar_carreras);

                            mysqli_stmt_execute($consulta_mostrar_carreras);

                            $result = mysqli_stmt_get_result($consulta_mostrar_carreras);

                            if (mysqli_num_rows($result)>0){
                                while ($row = mysqli_fetch_assoc($result) ){
                                    echo "<option value=". $row['carrera'].">".$row['carrera']."</option>";
                                }
                            }
                        ?>
                        </select>
                    </td>
                </tr>
            
                <tr>
                <td align="center" valign="top"><label for="nro_matricula">Nro. de matrícula:</label></td>
                <td><input type="text" id="nro_matricula" name="nro_matricula" required><br><br></td>
                </tr>
                
                <tr>
                    <td align="center" valign="top"><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" required><br><br></td>
                </tr>
                
                <tr>
                    <td align="center" valign="top"><label for="telefono">Teléfono:</label></td>
                    <td><input type="text" id="telefono" name="telefono" required><br><br></td>
                </tr>
                </tbody>

                <tfoot align="center">
                    <tr>
                        <td colspan="2"><button type="submit">Enviar</button></td>
                    </tr>
                </tfoot>
            </table>
            </form>
            <h2>CONSULTAR INFORMACIÓN</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table align="center" >
                <tbody>
                    <tr>
                        <td align="center" valign="top"><label for="nro_matricula_busqueda">Nro. de matrícula:</label></td>    
                        <td><input type="text" id="nro_matricula_busqueda" name="nro_matricula_busqueda" required><br><br></td>
                    </tr>
                </tbody>
                <tfoot align="center">
                    <tr>
                        <td colspan="2"><button type="submit">Buscar</button></td>
                    </tr>
                    </tfoot>
            </table>
            </form>
            <?php
            /*GUARDAR DATOS*/
            if (isset($_POST["nro_matricula"])){

                $nro_matricula = $_POST["nro_matricula"];
                $nombre = $_POST["nombre"];
                $apellido = $_POST["apellido"];
                $carrera = $_POST["carrera"];
                $email = $_POST["email"];
                $telefono =$_POST["telefono"];


                $sql_solicitud = "INSERT INTO consulta (nombre,apellido,carrera,nro_matricula,email,telefono) VALUES (?,?,?,?,?,?) ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), apellido = VALUES(apellido), carrera = VALUES(carrera), email = VALUES(email), telefono =VALUES(telefono)";

                $consulta_solicitud = mysqli_prepare($conexion,$sql_solicitud);

                mysqli_stmt_bind_param($consulta_solicitud,"ssssss",$nombre,$apellido,$carrera,$nro_matricula,$email,$telefono);
                
                mysqli_stmt_execute($consulta_solicitud);

                $result_solicitud = mysqli_stmt_get_result($consulta_solicitud);
            /* ENVIAR EMAIL DE CONSULTA */
                $sql_email = "SELECT * FROM emails";
                $consulta_email = mysqli_prepare($conexion,$sql_email);
                mysqli_stmt_execute($consulta_email);
                $result_email = mysqli_stmt_get_result($consulta_email);
                echo " <table border='1' align='center'>";
                $asunto = "Nuevo/Modificar Egresados";
                $mensaje = "Tienes una nueva petición \n\ para aceptar o modificar a un egresado";
                if($result_email){
                    if (mysqli_num_rows($result_email)>0){
                        while($row = mysqli_fetch_assoc($result_email)){
                            $para = $row['email'];
                            mail($para,$asunto,$mensaje);
                        }
                    }
                }
            }   
            /*CONSULTAR DATOS */
                if (isset($_POST["nro_matricula_busqueda"])){
                    $nro_matricula_busqueda = $_POST["nro_matricula_busqueda"];

                    $sql_informar = "SELECT * FROM alumnos WHERE nro_matricula = ?;";

                    $consulta_informar= mysqli_prepare($conexion,$sql_informar);
                    
                    mysqli_stmt_bind_param($consulta_informar,"s",$_POST["nro_matricula_busqueda"]);
                    
                    mysqli_stmt_execute($consulta_informar);
                    
                    $result_consulta = mysqli_stmt_get_result($consulta_informar);
                    
                    echo " <table border='1' align='center'><thead>";
                    if ($result_consulta){
                        if (mysqli_num_rows($result_consulta)>0){

                            echo "<tr><td colspan='2' align='center'><font color='#008000'><b>INFORMACION</b></font></td></tr></thead>";
                            echo "<tbody align='center'>";
                            if ($row = mysqli_fetch_assoc($result_consulta)) {
                                echo "<tr>";
                                echo "<td>Nombre:</td>";
                                echo "<td>".$row['nombre']."</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td>Apellido: </td>";
                                echo "<td>". $row['apellido'] ."</td>";
                                echo "</tr>";
                                
                                echo "<tr>";
                                echo "<td>Carrera: </td>";
                                echo "<td>".$row['carrera']."</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td>Nro. Matrícula: </td>";
                                echo "<td>".$row['nro_matricula']."</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td>Email: </td>";
                                echo "<td>".$row['email']."</td>";
                                echo "</tr>";

                                echo "<tr>";
                                echo "<td>Teléfono: </td>";
                                echo "<td>".$row['telefono']."</td>";
                                echo "</tr>";
                            }
                        }else {
                            echo "<tr><td><font color='#FF0000'><b>MATRICULA NO ENCONTRADA</b></font></td></tr>";
                        }
                        
                    }
                    echo "</tbody></table>";
                    
                }
            ?>    
    </body></font>
</html>