<?php
$host = '127.0.0.1:3300';
$user = 'root';
$pass = '123456';
$bd = 'sys';

/* CONEXION A LA BASE DE DATOS*/
$conexion = mysqli_connect($host,$user,$pass,$bd);
if ($conexion === false){
    die("ERROR".$conexion);
} 
if (!isset($_SESSION)) {
    session_start();
}
/* FUNCION BORRAR - TABLA CONSULTA */
function borrar_tConsulta($conexion,$matricula){
    $sql_borrar = "DELETE FROM consulta WHERE nro_matricula = (?)";

    $consulta_borrar = mysqli_prepare($conexion,$sql_borrar);

    mysqli_stmt_bind_param($consulta_borrar,"i",$matricula);

    mysqli_stmt_execute($consulta_borrar);

    header("Location: " . $_SERVER['PHP_SELF']);
exit();
}
/*FUNCION ACTUALIZAR - TABLA CONSULTA */
function actualizar_tConsulta($conexion,$row){
    echo "funcion activada <br>";
    $sql_cargar = "INSERT INTO alumnos (nombre, apellido, carrera, nro_matricula, email, telefono) 
            VALUES (?, ?, ?, ?, ?, ?) 
            ON DUPLICATE KEY UPDATE 
            nombre = VALUES(nombre), 
            apellido = VALUES(apellido), 
            carrera = VALUES(carrera), 
            nro_matricula = VALUES(nro_matricula),
            email = VALUES(email), 
            telefono = VALUES(telefono)";
    
    if($consulta_cargar = mysqli_prepare($conexion,$sql_cargar)){
    } else{echo "error Preparando";}
    if(mysqli_stmt_bind_param($consulta_cargar,"sssiss",$row['nombre'],$row['apellido'],$row['carrera'],$row['nro_matricula'],$row['email'],$row['telefono'])){
    } else{echo "error Asociando";}

    if(mysqli_stmt_execute($consulta_cargar)){
    } else{echo "error Ejecutando";}
    
}
// Definir una variable global inicial
$_SESSION['user'];
?>