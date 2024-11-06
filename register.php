<?php
// register.php
session_start();

// Configuración de la base de datos
$host = 'localhost'; // Cambia si es necesario
$db = 'Duno01'; // Nombre de tu base de datos
$user = 'root'; // Tu usuario de MySQL
$pass = '123456'; // Tu contraseña de MySQL

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario de registro
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verificar si el usuario ya existe
    $sql = "SELECT * FROM usuarios WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Redirigir con mensaje de error si el usuario ya existe
        header("Location: index.php?message=El nombre de usuario ya está en uso.");
        exit();
    } else {
        // No hashear la contraseña, almacenar en texto plano
        $role = 'usuario'; // Asignar el rol por defecto

        // Insertar el nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)"; // Asegúra>
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $password, $role);

        if ($stmt->execute()) {
 // Redirigir con mensaje de éxito
            header("Location: index.php?message=Usuario registrado exitosamente.");
            exit();
        } else {
            // Redirigir con mensaje de error en caso de falla
            header("Location: index.php?message=Error al registrar usuario: " . urlencode($c>
            exit();
        }
    }
}

$conn->close(); // Cierra la conexión a la base de datos
?>
