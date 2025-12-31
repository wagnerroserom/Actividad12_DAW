<?php
// Header común para todas las páginas.
// Contiene el menú de navegación y el botón para cerrar sesión.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurnoSalud Montecristi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Actividad12_DAW/assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <!-- Enlace al dashboard correspondiente según el rol -->
            <a class="navbar-brand" href="
            <?php
            if (isset($_SESSION['rol'])) {
                echo ($_SESSION['rol'] === 'administrador') ? '/Actividad12_DAW/admin/dashboard.php' : '/Actividad12_DAW/paciente/dashboard.php';
            } else {
                echo '/Actividad12_DAW/index.php';
            }
            ?>">
                TurnoSalud Montecristi
            </a>
            <!-- Botones de usuario y cierre de sesión -->
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['nombre'])): ?>
                    <span class="navbar-text me-3">¡Hola, <?= htmlspecialchars($_SESSION['nombre']) ?>!</span>
                    <!-- Botón de cierre de sesión -->
                    <a href="/Actividad12_DAW/auth/logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
