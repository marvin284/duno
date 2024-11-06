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

// Procesar el formulario de creación de usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Asegúrate de manejar la contraseña adecuadamente
    $rol = $_POST['rol'];

    // Preparar la consulta para insertar el usuario
    $sql = "INSERT INTO usuarios (username, email, password, rol) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Hashear la contraseña si es necesario, si estás guardando en texto plano solo descome>
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Si decides hashear
    // $stmt->bind_param("ssss", $username, $email, $hashed_password, $rol);
    $stmt->bind_param("ssss", $username, $email, $password, $rol); // Si guardas la contrase>

    if ($stmt->execute()) {
        // Usuario creado con éxito
        header('Location: admin.php');
        exit();
    } else {
 echo "Error al crear el usuario: " . $stmt->error;
    }
}

$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }
        input[type="text"], input[type="email"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
  input[type="submit"] {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #337ab7;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Crear Nuevo Usuario</h1>
        <form method="POST">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="admin">Administrador</option>
                <option value="cliente">Cliente</option>
            </select>

            <input type="submit" value="Crear Usuario">
  </form>
        <a href="admin.php" class="back-link">Volver al Panel</a>
    </div>
</body>
</html>

