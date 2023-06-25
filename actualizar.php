<?php
include 'conexion2.php';

if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['edad'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];

    // Validar y sanitizar los datos si es necesario

    $consulta = "UPDATE datos SET Nombre='$nombre', Edad='$edad' WHERE id=$id";
    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
    mysqli_close($conexion);
} else {
    echo "Datos incompletos";
}
?>


