<html>
    <head>
        <title>LISTADO EGRESADOS</title>
    </head>
    <body align="center"><font face="Courier">
    <h1>ADMINISTRADOR <br> -LISTADO CARRERAS-</h1>
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
                        <b>Agregar Nueva Carrera:</b>
                        </td>
                    </tr>
                </thead>
                <tbody align='center'>
                <tr>
                    <td>
                        <label for="id_new_carrera">ID Carrera:</label>
                    </td>
                    <td>
                        <input type="text" id="id_new_carrera" name="id_new_carrera" required>
                    </td>
                </tr>
                <tr>
                    <td>
                    <label for="new_carrera">Nombre:</label>
                    </td>
                <td>
                    <input type="text" id="new_carrera" name="new_carrera" required>
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
                            Eliminar Carrera
                        </b>
                        </td>
                    </tr>
                </thead>
                <tbody align='center'>
                <tr>
                    <td>
                        <label for="id_carrera_eliminar">ID Carrera:</label>
                    </td>
                    <td>
                        <input type="text" id="id_carrera_eliminar" name="id_carrera_eliminar" required>
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
            if (isset($_POST["id_new_carrera"])){

                $nombre_carrera = $_POST["new_carrera"];
                $id_new_carrera = $_POST["id_new_carrera"];

                $sql_guardar_carrera = "INSERT INTO carreras (id,carrera) VALUES (?,?) ON DUPLICATE KEY UPDATE id = VALUES(id), carrera = VALUES(carrera)";

                $consulta_guardar_carrera = mysqli_prepare($conexion,$sql_guardar_carrera);
                mysqli_stmt_bind_param($consulta_guardar_carrera,"ss",$id_new_carrera,$nombre_carrera);
                
                mysqli_stmt_execute($consulta_guardar_carrera);
                $result = mysqli_stmt_get_result($consulta_guardar_carrera);
            } 
            
            if (isset($_POST["id_carrera_eliminar"])){
                $id_carrera_eliminar = $_POST["id_carrera_eliminar"];
                $sql_eliminar_carrera = "DELETE FROM carreras WHERE id = (?)";
                $consulta_eliminar_carrera = mysqli_prepare($conexion,$sql_eliminar_carrera);
                mysqli_stmt_bind_param($consulta_eliminar_carrera,"s",$id_carrera_eliminar);
                mysqli_stmt_execute($consulta_eliminar_carrera);
                $result = mysqli_stmt_get_result($consulta_eliminar_carrera);
            } 
                $sql_informar_carreras = "SELECT * FROM carreras";
                $consulta_informar_carreras= mysqli_prepare($conexion,$sql_informar_carreras);
                mysqli_stmt_execute($consulta_informar_carreras);
                $result = mysqli_stmt_get_result($consulta_informar_carreras);
                echo " <table border='1' align='center'><thead>";
                if ($result){
                    if (mysqli_num_rows($result)>0){

                        echo "<tr><td colspan='2' align='center'><font color='#008000'><b>LISTA DE CARRERAS</b></font></td></tr></thead>";
                        echo "<tbody align='center'>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>ID:</td>";
                            echo "<td>".$row['id']."</td>";
                            echo "</tr>";

                            echo "<tr>";
                            echo "<td>Nombre:</td>";
                            echo "<td>".$row['carrera']."</td>";
                            echo "</tr>";
                            echo "<tr><td colspan='2' bgcolor='#008000'></td></tr>";
                        }
                    }else {
                        echo "<tr><td><font color='#FF0000'><b>MATRICULA NO ENCONTRADA</b></font></td></tr>";
                    }
                    
                }
                echo "</tbody></table>";
                
        ?>
    </font></body>
</html>