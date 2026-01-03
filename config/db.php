<?php
// Configuración de la conexión a la base de datos MySQL utilizando XAMPP.
$host = 'localhost';            // Servidor de la base de datos
$usuario_db = 'root';           // Usuario por defecto de MySQL en XAMPP
$contraseña_db = '';
$nombre_db = 'turnosalud_montecristi12';  // Nombre de la base de datos

// Crea la conexión
$conexion = new mysqli($host, $usuario_db, $contrasena_db, $nombre_db);

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Establece la codificación UTF-8 para evitar problemas con caracteres especiales
$conexion->set_charset("utf8");
?>
