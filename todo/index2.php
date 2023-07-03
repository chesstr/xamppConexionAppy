<?php
include 'conexion2.php';

$pdo = new Conexion();

// Función para crear un nuevo usuario
function crearUsuario($edad, $nombre) {
    global $pdo;
    
    $sql = $pdo->prepare("INSERT INTO usuarios (Edad,Nombre) VALUES (:edad, :nombre)");
    $sql->bindValue(':edad',$edad);
    $sql->bindValue(':nombre',$nombre);
    $sql->execute();
    
    return $pdo->lastInsertId(); // Devuelve el ID del nuevo usuario creado
}

// Función para obtener todos los usuarios
function obtenerUsuarios() {
    global $pdo;
    
    $sql = $pdo->prepare("SELECT * FROM usuarios");
    $sql->execute();
    
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener un usuario por su ID
function obtenerUsuarioPorId($id) {
    global $pdo;
    
    $sql = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    
    return $sql->fetch(PDO::FETCH_ASSOC);
}

// Función para actualizar un usuario por su ID
function actualizarUsuario($id, $edad,$nombre) {
    global $pdo;
    
    $sql = $pdo->prepare("UPDATE usuarios SET Edad = :edad, Nombre = :nombre WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->bindValue(':edad', $edad);
    $sql->bindValue(':nombre', $nombre);
    $sql->execute();
    
    return $sql->rowCount(); // Devuelve la cantidad de filas afectadas (debería ser 1)
}

// Función para eliminar un usuario por su ID
function eliminarUsuario($id) {
    global $pdo;
    
    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();
    
    return $sql->rowCount(); // Devuelve la cantidad de filas afectadas (debería ser 1)
}

// Comprobar el método de solicitud HTTP
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear un nuevo usuario
    $edad = $_POST['edad'];
    $nombre = $_POST['nombre'];
    // Luego, puedes utilizar los valores en tu función crearUsuario()
    $usuarioId = crearUsuario($edad, $nombre);
    if ($usuarioId) {
        header("HTTP/1.1 201 Created");
        echo json_encode(['id' => $usuarioId]);
        exit;
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(['error' => 'Error al crear el usuario']);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todos los usuarios o un usuario específico
    if (isset($_GET['id'])) {
        // Obtener un usuario por su ID
        $usuario = obtenerUsuarioPorId($_GET['id']);
        
        if ($usuario) {
            header("HTTP/1.1 200 OK");
            echo json_encode($usuario);
            exit;
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['error' => 'Usuario no encontrado']);
            exit;
        }
    } else {
        // Obtener todos los usuarios
        $usuarios = obtenerUsuarios();
        
        if ($usuarios) {
            header("HTTP/1.1 200 OK");
            echo json_encode($usuarios);
            exit;
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(['error' => 'No se encontraron usuarios']);
            exit;
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Actualizar un usuario existente
    parse_str(file_get_contents("php://input"), $data); // Suponiendo que los datos se envían en el cuerpo de la solicitud en formato x-www-form-urlencoded
    
    $usuarioId = $_GET['id'];
    $nombre = $_GET['nombre'];
	$edad = $_GET['edad'];
    
    $resultado = actualizarUsuario($usuarioId, $edad, $nombre);
    
    if ($resultado) {
        header("HTTP/1.1 200 OK");
        echo json_encode(['message' => 'Usuario actualizado correctamente']);
        exit;
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(['error' => 'Error al actualizar el usuario']);
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Eliminar un usuario existente
    $usuarioId = $_GET['id'];
    $resultado = eliminarUsuario($usuarioId);
    
    if ($resultado) {
        header("HTTP/1.1 200 OK");
        echo json_encode(['message' => 'Usuario eliminado correctamente']);
        exit;
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(['error' => 'Error al eliminar el usuario']);
        exit;
    }
} else {
    // Obtener todos los usuarios
    $usuarios = obtenerUsuarios();
    
    if ($usuarios) {
        header("HTTP/1.1 200 OK");
        echo json_encode($usuarios);
        exit;
    } else {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['error' => 'No se encontraron usuarios']);
        exit;
    }
}
?>
