<?php
// Panel principal del paciente después de iniciar sesión.

// Verificar que el usuario esté autenticado como paciente
include '../includes/auth_check.php';
if ($_SESSION['rol'] !== 'paciente') {
    header("Location: ../index.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Panel del Paciente</h2>
    <p class="lead">Bienvenido, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong></p>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Solicitar Turno</h5>
                    <a href="solicitar_turno.php" class="btn btn-primary">Nuevo Turno</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5>Mis Turnos</h5>
                    <a href="mis_turnos.php" class="btn btn-success">Ver Turnos</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Botón para volver al inicio -->
    <div class="mt-4">
        <a href="../index.php" class="btn btn-secondary">← Volver al Inicio</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
