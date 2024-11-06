<?php
session_start();

// Verificar que el usuario esté autenticado y que sea un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Configuración de la base de datos
$host = 'localhost';
$db = 'Duno01';
$user = 'root';
$pass = '123456';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error al eliminar el usuario.";
    }
} else {
    echo "ID de usuario no proporcionado.";
}

$conn->close(); // Cierra la conexión a la base de datos
?>
