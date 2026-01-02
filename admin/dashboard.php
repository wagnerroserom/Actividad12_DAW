<?php
// Panel de administración, exclusivo para el personal del subcentro de salud.

// Se verifica que el usuario esté autenticado como administrador
include '../includes/auth_check.php';
if ($_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

// Se incluye la conexión a la base de datos
include '../config/db.php';

// Obtener todas las estadísticas
$total_pacientes = $conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'paciente'")->fetch_row()[0];
$total_turnos = $conexion->query("SELECT COUNT(*) FROM turnos")->fetch_row()[0];
$turnos_hoy = $conexion->query("SELECT COUNT(*) FROM turnos WHERE fecha = CURDATE()")->fetch_row()[0];
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Panel de Administración</h2>
    <p class="lead">Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></p>

    <div class="row g-4">
        <!-- Tarjeta: Pacientes Registrados -->
        <div class="col-md-4">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Pacientes Registrados</h5>
                    <h2 class="display-5"><?= $total_pacientes ?></h2>
                    <a href="gestion_usuarios.php" class="btn btn-light mt-2">Ver todos</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Turnos Asignados -->
        <div class="col-md-4">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h5 class="card-title">Turnos Asignados</h5>
                    <h2 class="display-5"><?= $total_turnos ?></h2>
                    <a href="gestion_turnos.php" class="btn btn-light mt-2">Ver todos</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Turnos Para Hoy -->
        <div class="col-md-4">
            <div class="card text-bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Turnos Para Hoy</h5>
                    <h2 class="display-5"><?= $turnos_hoy ?></h2>
                    <a href="gestion_turnos.php" class="btn btn-light mt-2">Ver detalles</a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="../index.php" class="btn btn-secondary">← Volver al inicio</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
