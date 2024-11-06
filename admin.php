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

// Consultar todos los usuarios
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
 }
        .header {
            background: #333;
            color: #fff;
            padding: 15px 0;
            text-align: center;
        }
        .navbar {
            margin: 10px 0;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }
        .content {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
 a:hover {
            text-decoration: underline;
        }
        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .create-button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .create-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Panel de Administración</h1>
        <div class="navbar">
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>

    <div class="content">
        <h2>Lista de Usuarios</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while($user = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['email']; ?></td>
  <td><?php echo $user['rol']; ?></td>
                        <td class="actions">
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Editar</a>
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>">Eliminar>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </table>

        <div class="actions">
            <a href="create_user.php" class="create-button">Crear Nuevo Usuario</a>
            <a href="index.php">Volver a la Página Principal</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close(); // Cierra la conexión a la base de datos
?>
