<?php
// Asegúrate de que tu conexión a la base de datos esté configurada
$host = 'localhost';
$db = 'Duno01';
$user = 'root';
$pass = '123456';

// Conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Actualizar contraseñas de los usuarios
$users = [
    ['username' => 'lego', 'new_password' => '1'],
    ['username' => 'brayan', 'new_password' => 'lego'],
    ['username' => 'Marvin', 'new_password' => '123']
];

foreach ($users as $user) {
    $hashed_password = password_hash($user['new_password'], PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $user['username']);
    $stmt->execute();
}

echo "Contraseñas actualizadas.";
$conn->close();
?>


