<?php
session_start();

// Redirigir si no hay sesión activa
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Verifica si el rol existe en la sesión
if (!isset($_SESSION['rol'])) {
    die("Error: No se encontró el rol del usuario en la sesión.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoñaSucia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .head {
            background: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
        .navbar {
            margin-top: 10px;
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
        }
        .content {
            padding: 20px;
 text-align: center;
        }
        .product {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            width: 200px;
            background-color: #fff;
        }
        .product img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .buy-button {
            background-color: #5cb85c;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .buy-button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="head">
        <h1>Bienvenido a DoñaSucia</h1>
        <div class="navbar">
            <a href="logout.php">Cerrar Sesión</a>
            <?php if ($_SESSION['rol'] == 'admin'): ?>
                <a href="admin.php">Panel de Administración</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">
        <h2>Productos Disponibles</h2>
  <div class="product">
            <img src="images/product1.jpg" alt="El que chupas">
            <h3>El que chupas</h3>
            <p>Huevo 24pz.</p>
            <a href="buy.php?product=1" class="buy-button">Comprar</a>
        </div>

        <div class="product">
            <img src="images/product2.jpg" alt="Producto 2">
            <h3>Proteina</h3>
            <p>De la mas alta calidad.</p>
            <a href="buy.php?product=2" class="buy-button">Comprar</a>
        </div>

        <div class="product">
            <img src="images/product3.jpg" alt="Producto 3">
            <h3>Flacowwwwwww</h3>
            <p>Lo que necesita el yisus.</p>
            <a href="buy.php?product=3" class="buy-button">Comprar</a>
        </div>

        <!-- Agregar más productos según sea necesario -->
    </div>
</body>
</html>
