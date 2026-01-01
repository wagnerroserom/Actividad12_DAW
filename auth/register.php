<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: ../paciente/dashboard.php");
    exit();
}

include '../config/db.php';

$error = '';
$exito = '';

// Validar cédula 
function validarCedula($cedula) {
    if (strlen($cedula) != 10 || !is_numeric($cedula)) return false;
    $coeficientes = [2,1,2,1,2,1,2,1,2];
    $suma = 0;
    for ($i = 0; $i < 9; $i++) {
        $digito = (int)$cedula[$i] * $coeficientes[$i];
        $suma += ($digito > 9) ? $digito - 9 : $digito;
    }
    $digitoVerificador = (10 - ($suma % 10)) % 10;
    return (int)$cedula[9] === $digitoVerificador;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $cedula = trim($_POST['cedula']);
    $telefono = trim($_POST['telefono']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($nombre) || empty($cedula) || empty($email) || empty($password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo electrónico no válido.";
    } elseif (!validarCedula($cedula)) {
        $error = "Número de cédula no válido.";
    } elseif (strlen($password) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres.";
    } elseif ($password !== $password2) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ? OR cedula = ?");
        $stmt->bind_param("ss", $email, $cedula);
        $stmt->execute();
        $existe = $stmt->get_result()->num_rows > 0;
        $stmt->close();

        if ($existe) {
            $error = "El correo o la cédula ya están registrados.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conexion->prepare("INSERT INTO usuarios (nombre, cedula, telefono, email, password, rol) VALUES (?, ?, ?, ?, ?, 'paciente')");
            $stmt2->bind_param("sssss", $nombre, $cedula, $telefono, $email, $password_hash);

            if ($stmt2->execute()) {
                $exito = "Registro exitoso!!!. Ya puedes iniciar sesión.";
            } else {
                $error = "Error al registrar. Intente nuevamente.";
            }
            $stmt2->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TurnoSalud Montecristi - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card p-4" style="max-width: 500px; width: 100%;">
            <h3 class="text-center mb-4">Registro de Paciente</h3>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($exito): ?>
                <div class="alert alert-success"><?= htmlspecialchars($exito) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula (10 dígitos)</label>
                    <input type="text" class="form-control" id="cedula" name="cedula" maxlength="10" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono (Opcional)</label>
                    <input type="text" class="form-control" id="telefono" name="telefono">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Repetir Contraseña</label>
                    <input type="password" class="form-control" id="password2" name="password2" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Registrarme</button>
            </form>
            <div class="text-center mt-3">
                ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
