<?php
// Con este bloque se verifica si el usuario ha iniciado sesión.
// Si no está autenticado lo redirige a la página de inicio.

session_start();
if (!isset($SESSION['usuario_id'])) {
    header("Location: ../index.php");
    exit();
} 
?>