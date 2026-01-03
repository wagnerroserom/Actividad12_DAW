<?php
// generar_hash_adm123.php
$password = 'adm123';
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "<h3>Hash para la contraseña: <code>$password</code></h3>";
echo "<p><strong>Copia este valor:</strong></p>";
echo "<pre style='background:#f0f0f0; padding:10px; border-radius:5px;'>$hash</pre>";
echo "<p>Úsalo en la consulta SQL a continuación.</p>";
?>
