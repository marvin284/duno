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

    // Consultar el usuario
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
}

// Actualizar el usuario si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET username = ?, email = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $email, $rol, $id);

    if ($stmt->execute()) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Error al actualizar el usuario.";
    }
}

$conn->close(); // Cierra la conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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
        input[type="text"], input[type="email"], select {
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
            width: 100%;
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
        <h1>Editar Usuario</h1>
        <form method="POST">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="admin" <?php echo $user['rol'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="cliente" <?php echo $user['rol'] === 'cliente' ? 'selected' : ''; ?>>Cliente</option>
            </select>

            <input type="submit" value="Actualizar Usuario">
        </form>
        <a href="admin.php" class="back-link">Volver al Panel</a>
    </div>
</body>
</html>
