<?php
// Con este bloque eliminamos la sesión actual y redirige al usuario a la página de inicio.

// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Elimina todas las variables de sesión
session_unset();

// Elimina la sesión completa
session_destroy();

// Redirige al usuario a la página de inicio
header("Location: ../index.php");
exit(); // Se asegura de que no se ejecute más código después de la redirección
