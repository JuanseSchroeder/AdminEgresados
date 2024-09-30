<html>
    <head>

    </head>
    <body align="center"><font face='Courier'>
    <h1>ADMINISTRADOR <br> -CONSULTAS-</h1>
    <form action="administrador.php" method="POST">
            <table align="center">
                <tr >
                    <td ><b>Volver a Menu Administrador:</b></td>
                    <td ><input type="submit" name="submit" value="Volver"></td>
                </tr>
            </table>
        </form>

        <?php
        include './config.php';
        $sql_informar = "SELECT * FROM consulta;";
        $consulta_informar= mysqli_prepare($conexion,$sql_informar);
        mysqli_stmt_execute($consulta_informar);
        $result = mysqli_stmt_get_result($consulta_informar);
        
        echo " <table border='1' align='center'>";
        if ($result){
            if (mysqli_num_rows($result)>0){

                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td colspan='2' align='center'><font color='#008000'><b>INFORMACION NUEVA</b></font></td></tr>";
                    echo "<tbody align='center'>";
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
                    echo "<tr><td colspan='2' bgcolor='#008000'></td></tr>";
                    
                    $matricula=$row['nro_matricula'];
                    /*COMPARAR DATOS */
                    
                    $sql_datos = "SELECT * FROM alumnos WHERE nro_matricula = ?";
                    $datos =  mysqli_prepare($conexion,$sql_datos);
                
                    
                    mysqli_stmt_bind_param($datos,'s',$matricula);
                    mysqli_stmt_execute($datos);
                
                    $result2 = mysqli_stmt_get_result($datos);
                    
                    if($result2){
                        
                        if(mysqli_num_rows($result2)>0){
                            
                                if ($row2 = mysqli_fetch_assoc($result2)) 
                                {   
                                    if(in_array($matricula,$row2)){
                        
                                    echo "<tr>
                                    <td colspan='2'><b>
                                    INFORMACIÓN VIEJA</b></td>
                                        </tr>";
                                    echo "<tr>";
                                    echo "<td>Nombre:</td>";
                                    echo "<td>".$row2['nombre']."</td>";
                                    echo "</tr>";
                
                                    echo "<tr>";
                                    echo "<td>Apellido: </td>";
                                    echo "<td>". $row2['apellido'] ."</td>";
                                    echo "</tr>";
                                    
                                    echo "<tr>";
                                    echo "<td>Carrera: </td>";
                                    echo "<td>".$row2['carrera']."</td>";
                                    echo "</tr>";
                
                                    echo "<tr>";
                                    echo "<td>Nro. Matrícula: </td>";
                                    echo "<td>".$row2['nro_matricula']."</td>";
                                    echo "</tr>";
                
                                    echo "<tr>";
                                    echo "<td>Email: </td>";
                                    echo "<td>".$row2['email']."</td>";
                                    echo "</tr>";
                
                                    echo "<tr>";
                                    echo "<td>Teléfono: </td>";
                                    echo "<td>".$row2['telefono']."</td>";
                                    echo "</tr>";
                                    echo "<tr><td colspan='2' bgcolor='#008000'></td></tr>";
                                    echo "</tbody>";}
                                    
                                    }
                                    echo "<tr >
                                    <td bgcolor='#008000' ><b>
                                &#9650 ACTUALIZAR INFORMACIÓN VIEJA &#9650</b></td>
                                    <td align='center'  bgcolor='#008000'>";
                                    ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    
                                    <button type="submit" name="actualizar">APROBAR CAMBIO</button
                                    >
                                    
                                    <button type="submit" name="rechazar">RECHAZAR CAMBIO</button
                                    >
                                    </form>

                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                        if (isset($_POST['rechazar'])){
                                            
                                            /*ELIMINAR DE TABLA CONSULTAS */

                                            borrar_tConsulta($conexion,$matricula);

                                            header("Location: " . $_SERVER['PHP_SELF']);
                                            exit();
                                            
                                        }
                                    }

                                        if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                            if (isset($_POST['actualizar'])){
                                                
                                                echo "precionado <br>";

                                                actualizar_tConsulta($conexion,$row);
                                                /*ELIMINAR DE TABLA CONSULTAS */
    
                                                borrar_tConsulta($conexion,$matricula);

                                                header("Location: " . $_SERVER['PHP_SELF']);
                                                exit();
                                            }
                                        }
                                    echo "</td>";
                                }
                                else{
                                    echo "<tr>
                                    <td><b>
                                &#9650 ALUMNO SIN REGISTRAR &#9650</b></td>
                                    <td valign='middle'>";
                                    ?>

                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                                    <button type="submit" name='borrar'>REGISTRAR NUEVO ALUMNO</button
                                    >
                                    <?php
                                    if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                        if (isset($_POST['borrar'])){
                                            echo "boton precionado";
                                            /* ACTUALIZAR TABLA ALUMNOS */
                                            
                                            if (actualizar_tConsulta($row,$conexion)){
                                                /*ELIMINAR DE TABLA CONSULTAS */

                                                borrar_tConsulta($matricula,$conexion);

                                                header("Location: " . $_SERVER['PHP_SELF']);
                                                exit();
                                                
                                            }
                                        }
                                    }
                                    echo "</td></tr>";
                                }
                            }else{echo "no resultado";}
                        }
                    }
                }echo "</table>";
        ?>
        </font></body>
</html>