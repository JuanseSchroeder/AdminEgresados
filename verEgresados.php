<html>
    <head>
        <title>LISTADO EGRESADOS</title>
    </head>
    <body align="center"><font face="Courier">
    <h1>ADMINISTRADOR <br> -LISTADO EGRESADOS-</h1>
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
                    $sql_informar = "SELECT * FROM alumnos;";

                    $consulta_informar= mysqli_prepare($conexion,$sql_informar);
                    
                    mysqli_stmt_execute($consulta_informar);
                    
                    $result = mysqli_stmt_get_result($consulta_informar);
                    
                    echo " <table border='1' align='center'>";
                    if ($result){
                        if (mysqli_num_rows($result)>0){

                            echo "<thead><tr><td colspan='2' align='center'><font color='#008000'><b>INFORMACION</b></font></td></tr></thead>";
                            
                            while ($row = mysqli_fetch_assoc($result)) {
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
                            }
                            
                        }
                    }
        ?>
    </font></body>
</html>