<?php
// Este script nos ayuda a generar un hash válido para la contraseña que se desee.
// Para usar este script de debe copiar y ejecutar en el navegador el link: http://localhost/Actividad12_DAW/generar_hash.php

$contrasena = 'admin123'; // Cambiar 'admin123' si se requiere otra contraseña
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

echo "<h2>Hash generado para la contraseña: <code>$contrasena</code></h2>";
echo "<p><strong>Hash:</strong> <code>$hash</code></p>";
echo "<p>Úsalo en tu consulta SQL para insertar el administrador.</p>";
?>
