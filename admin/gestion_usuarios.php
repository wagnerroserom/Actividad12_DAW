<?php
// Gestión de usuarios (solo pacientes) por parte del administrador.

// Se verifica que el usuario esté autenticado como administrador.
include '../includes/auth_check.php';
if ($_SESSION['rol'] !== 'administrador') {
    header("Location: ../index.php");
    exit();
}

// Se incluye la conexión a la base de datos.
include '../config/db.php';

// Eliminar el usuario (solo si es paciente).
if (isset($_GET['eliminar']) && is_numeric($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    // Se verifica que no sea administrador.
    $stmt_check = $conexion->prepare("SELECT rol FROM usuarios WHERE id = ?");
    $stmt_check->bind_param("i", $id_eliminar);
    $stmt_check->execute();
    $rol = $stmt_check->get_result()->fetch_assoc()['rol'] ?? '';
    if ($rol === 'paciente') {
        $stmt_del = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt_del->bind_param("i", $id_eliminar);
        $stmt_del->execute();
        $mensaje = "El usuario se ha eliminado correctamente.";
    } else {
        $error = "Lo sentimos, no se puede eliminar administradores desde aquí.";
    }
    $stmt_check->close();
}

// Se obtienen todos los usuarios (solo pacientes)
$resultado = $conexion->query("
    SELECT id, nombre, cedula, telefono, email, rol, fecha_registro 
    FROM usuarios 
    ORDER BY fecha_registro DESC
");
$usuarios = [];
while ($fila = $resultado->fetch_assoc()) {
    $usuarios[] = $fila;
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Gestión de Usuarios</h2>
    
    <?php if (isset($mensaje)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Registrado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                        <td><?= htmlspecialchars($u['cedula']) ?></td>
                        <td><?= htmlspecialchars($u['telefono'] ?: '—') ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td>
                            <span class="badge bg-<?= $u['rol'] === 'administrador' ? 'danger' : 'info' ?>">
                                <?= $u['rol'] === 'administrador' ? 'Admin' : 'Paciente' ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y H:i', strtotime($u['fecha_registro'])) ?></td>
                        <td>
                            <?php if ($u['rol'] === 'paciente'): ?>
                                <a href="?eliminar=<?= $u['id'] ?>" 
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar a <?= addslashes($u['nombre']) ?>?')">
                                    Eliminar
                                </a>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php" class="btn btn-secondary mt-3">← Volver al Panel</a>
</div>

<?php include '../includes/footer.php'; ?>
