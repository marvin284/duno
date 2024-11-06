<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: login.php'); // Redirigir a la página de inicio de sesión
    exit();
}

// Conexión a la base de datos
$host = 'localhost'; // Cambia si es necesario
$db = 'Duno01'; // Nombre de tu base de datos
$user = 'root'; // Tu usuario de MySQL
$pass = '123456'; // Tu contraseña de MySQL

$conn = new mysqli($host, $user, $pass, $db);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newContent = $_POST['newContent'];

    // Aquí puedes guardar los cambios en la base de datos, o hacer otras modificaciones
    // Por ejemplo, podrías actualizar una tabla de contenido o un archivo de texto.

    // Ejemplo de actualización (modifica según tu estructura):
    $sql = "UPDATE contenido SET texto = ? WHERE id = 1"; // Asume que tienes una tabla `con>
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $newContent);

    if ($stmt->execute()) {
        echo "Contenido modificado exitosamente.";
    } else {
        echo "Error al modificar el contenido: " . $conn->error;
    }
}
