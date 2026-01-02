<?php
// Con este bloque se muestra los turnos asignados al paciente actual.

// Se verifica que el usuario esté autenticado como paciente.
include '../includes/auth_check.php';
if ($_SESSION['rol'] !== 'paciente') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos.
include '../config/db.php';

// Se obtienen los turnos del paciente actual.
$usuario_id = $_SESSION['usuario_id'];
$stmt = $conexion->prepare("
    SELECT t.fecha, t.hora, e.nombre AS especialidad, t.estado
    FROM turnos t
    JOIN especialidades e ON t.especialidad_id = e.id
    WHERE t.usuario_id = ?
    ORDER BY t.fecha DESC, t.hora DESC
");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$turnos = [];
while ($fila = $resultado->fetch_assoc()) {
    $turnos[] = $fila;
}
$stmt->close();

// Se muestran todos los turnos
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Mis Turnos</h2>
    <?php if (empty($turnos)): ?>
        <div class="alert alert-info">Hola, no tienes turnos registrados.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Especialidad</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($turnos as $turno): ?>
                        <tr>
                            <td><?= htmlspecialchars($turno['fecha']) ?></td>
                            <td><?= htmlspecialchars($turno['hora']) ?></td>
                            <td><?= htmlspecialchars($turno['especialidad']) ?></td>
                            <td>
                                <span class="badge 
                                <?php
                                switch ($turno['estado']) {
                                    case 'pendiente': echo 'bg-warning'; break;
                                    case 'confirmado': echo 'bg-success'; break;
                                    case 'cancelado': echo 'bg-danger'; break;
                                    case 'atendido': echo 'bg-secondary'; break;
                                }
                                ?>">
                                    <?= ucfirst($turno['estado']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <!-- Botón para volver al panel -->
    <a href="dashboard.php" class="btn btn-secondary mt-3">← Volver al Panel</a>
</div>

<?php include '../includes/footer.php'; ?>
