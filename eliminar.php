<?php
include 'conexion2.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "DELETE FROM usuarios WHERE id='" . $id . "'";

    mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
    mysqli_close($conexion);
} else {
    echo "ID no proporcionado";
}
?>


