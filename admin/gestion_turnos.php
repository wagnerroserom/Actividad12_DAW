<?php
// Gestión de turnos por parte del administrador.

// Se verifica que el usuario esté autenticado como administrador
include '../includes/auth_check.php';
if ($_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

// Se incluye la conexión a la base de datos
include '../config/db.php';

// Se actualiza estado de turno
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_turno']) && isset($_POST['estado'])) {
    $id_turno = (int)$_POST['id_turno'];
    $estado = $_POST['estado'];
    if (in_array($estado, ['pendiente', 'confirmado', 'cancelado', 'atendido'])) {
        $stmt = $conexion->prepare("UPDATE turnos SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $id_turno);
        $stmt->execute();
        $stmt->close();
    }
}

// Se obtienen todos los turnos con datos del paciente y especialidad
$resultado = $conexion->query("
    SELECT t.id, t.fecha, t.hora, t.estado, 
        u.nombre AS paciente, u.cedula, 
        e.nombre AS especialidad
    FROM turnos t
    JOIN usuarios u ON t.usuario_id = u.id
    JOIN especialidades e ON t.especialidad_id = e.id
    ORDER BY t.fecha DESC, t.hora DESC
");
$turnos = [];
while ($fila = $resultado->fetch_assoc()) {
    $turnos[] = $fila;
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Turnos</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Paciente</th>
                    <th>Cédula</th>
                    <th>Especialidad</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($turnos as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['fecha']) ?></td>
                        <td><?= htmlspecialchars($t['hora']) ?></td>
                        <td><?= htmlspecialchars($t['paciente']) ?></td>
                        <td><?= htmlspecialchars($t['cedula']) ?></td>
                        <td><?= htmlspecialchars($t['especialidad']) ?></td>
                        <td>
                            <span class="badge bg-<?= 
                                $t['estado'] === 'pendiente' ? 'warning' : 
                                ($t['estado'] === 'confirmado' ? 'success' : 
                                ($t['estado'] === 'cancelado' ? 'danger' : 'secondary'))
                            ?>">
                                <?= ucfirst($t['estado']) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id_turno" value="<?= $t['id'] ?>">
                                <select name="estado" class="form-select form-select-sm d-inline" style="width:auto;" onchange="this.form.submit()">
                                    <option value="pendiente" <?= $t['estado'] === 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                    <option value="confirmado" <?= $t['estado'] === 'confirmado' ? 'selected' : '' ?>>Confirmado</option>
                                    <option value="cancelado" <?= $t['estado'] === 'cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                    <option value="atendido" <?= $t['estado'] === 'atendido' ? 'selected' : '' ?>>Atendido</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-3">← Volver al Panel</a>
</div>

<?php include '../includes/footer.php'; ?>
