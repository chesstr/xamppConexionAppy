<?php
include 'conexion2.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $consulta = "SELECT * FROM usuarios WHERE id='" . $id . "'";
    $resultado = $conexion->query($consulta);

    $registro = array();

    while ($fila = $resultado->fetch_array()) {
        $registro[] = array_map('utf8_encode', $fila);
    }

    echo json_encode($registro);
    $resultado->close();
} else {
    echo "ID no proporcionado";
}
?>
