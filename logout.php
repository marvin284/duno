<?php
error_reporting(E_ALL); // Mostrar todos los errores
ini_set('display_errors', 1); // Habilitar la visualización de errores

session_start(); // Iniciar la sesión

// Destruir la sesión
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir a la página de inicio
header("Location: index.php");
exit(); // Asegúrate de salir para evitar que se ejecute el resto del código
?>



