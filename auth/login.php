<?php
// Con este bloque se maneja el inicio de sesión de los usuarios (pacientes o administradores).

// Inicia la sesión
session_start();

// Si ya hay una sesión activa, lo redirige según el rol del usuario
if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['rol'] === 'administrador') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../paciente/dashboard.php");
    }
    exit(); // Detiene la ejecución para evitar mostrar el formulario
}

// Incluye la conexión a la base de datos
include '../config/db.php';

$error = ''; // Esta variable sirve para almacenar mensajes de error

// Se procesa el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Se valida que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Sección que prepara la consulta para buscar al usuario
        $stmt = $conexion->prepare("SELECT id, nombre, cedula, password, rol FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Se verifica si encontró un usuario
        if ($usuario = $resultado->fetch_assoc()) {
            // Se verifica la contraseña
            if (password_verify($password, $usuario['password'])) {
                // Sección que almacena datos del usuario en la sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['cedula'] = $usuario['cedula'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirige según el rol
                if ($usuario['rol'] === 'administrador') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../paciente/dashboard.php");
                }
                exit(); // Detiene la ejecución
            } else {
                $error = "Correo o contraseña incorrectos.";
            }
        } else {
            $error = "Correo o contraseña incorrectos.";
        }
        $stmt->close(); // Cierra la sentencia preparada
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TurnoSalud Montecristi - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4" style="max-width: 400px; width: 100%;">
            <h3 class="text-center mb-4">Iniciar Sesión</h3>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
            <div class="text-center mt-3">
                ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
