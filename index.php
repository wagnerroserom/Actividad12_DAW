<?php
// Página de inicio pública del sistema.
// Muestra la información general y enlaces para iniciar sesión o registrarse.
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turno Salud Montecristi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(180deg, #024802ff, #ffffffff, #fb0808ff); }
        .hero { background: white; border-radius: 13px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="d-flex flex-column min-vh-10 h-100">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 hero p-5 text-center">
                <h1 class="display-5 fw-bold text-primary">Turnos para Atención Subcentro Montecristi</h1>
                <p class="lead mt-3">
                    Sistema de gestión de turnos médicos para el Subcentro de Salud de Montecristi.
                    <br><strong>¡Evita aglomeraciones y turnos ilegales!</strong>
                </p>
                <div class="mt-4">
                    <a href="auth/login.php" class="btn btn-primary btn-lg me-2">Iniciar Sesión</a>
                    <a href="auth/register.php" class="btn btn-outline-primary btn-lg">Registrarse</a>
                </div>
                <div class="mt-4 text-muted small">
                    ¿Eres personal del centro de salud? Usa tus credenciales de administrador para ingresar por favor.
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light py-3 mt-auto">
        <div class="text-center text-muted">
            © 2026 Subcentro de Salud Montecristi - Proyecto Académico - Estudiantes de DAW - 6to Semestre
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
