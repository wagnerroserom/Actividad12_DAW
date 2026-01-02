<?php
// Este bloque permite a los pacientes solicitar un turno nuevo para atención médica.

// Se verifica que el usuario esté autenticado como paciente.
include '../includes/auth_check.php';
if ($_SESSION['rol'] !== 'paciente') {
    header("Location: ../index.php");
    exit();
}

// Incluye la conexión a la base de datos.
include '../config/db.php';

$mensaje = ''; // Envía mensaje de éxito.
$error = '';   // Envía mensaje de error.

// Se obtiene la lista de especialidades disponibles.
$especialidades = [];
$result = $conexion->query("SELECT id, nombre FROM especialidades");
while ($fila = $result->fetch_assoc()) {
    $especialidades[] = $fila;
}

// Procesa el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $especialidad_id = (int)$_POST['especialidad_id'];
    $fecha = $_POST['fecha'];

    // Se valida la fecha para agendar cita/turno (mínimo desde hoy como máximo 30 días).
    $hoy = date('Y-m-d');
    $maximo = date('Y-m-d', strtotime('+30 days'));
    if ($fecha < $hoy) {
        $error = "Por lógica la fecha no puede ser anterior a hoy.";
    } elseif ($fecha > $maximo) {
        $error = "Sólo puedes solicitar turnos hasta 30 días adelantados a la fecha actual.";
    } else {
        // Se verifica si el paciente ya tiene un turno asignado para la fecha seleccionada.
        $stmt = $conexion->prepare("SELECT id FROM turnos WHERE usuario_id = ? AND fecha = ?");
        $stmt->bind_param("is", $_SESSION['usuario_id'], $fecha);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Lo sentimos, ya tienes un turno asignado para esta fecha.";
        } else {
            // Se busca la primera hora disponible para la especialidad y fecha seleccionadas.
            $horas = ['08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                    '14:00', '14:30', '15:00', '15:30', '16:00'];
            $hora_asignada = null;

            foreach ($horas as $hora) {
                $stmt2 = $conexion->prepare("SELECT id FROM turnos WHERE fecha = ? AND hora = ? AND especialidad_id = ?");
                $stmt2->bind_param("ssi", $fecha, $hora, $especialidad_id);
                $stmt2->execute();
                $libre = $stmt2->get_result()->num_rows == 0;
                $stmt2->close();
                if ($libre) {
                    $hora_asignada = $hora;
                    break;
                }
            }

            if ($hora_asignada) {
                // Se inserta el nuevo turno en la base de datos.
                $stmt3 = $conexion->prepare("INSERT INTO turnos (usuario_id, especialidad_id, fecha, hora) VALUES (?, ?, ?, ?)");
                $stmt3->bind_param("iiss", $_SESSION['usuario_id'], $especialidad_id, $fecha, $hora_asignada);
                if ($stmt3->execute()) {
                    $mensaje = "¡Felicidades su turno fue asignado con éxito! Fecha: $fecha, Hora: $hora_asignada.";
                } else {
                    $error = "Lo sentimos, hubo un error al asignar el turno.";
                }
                $stmt3->close();
            } else {
                $error = "No hay horarios disponibles para ese día y especialidad, intente otra fecha por favor";
            }
        }
        $stmt->close();
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Solicitar Nuevo Turno</h2>

    <!-- Muestra mensajes de éxito o error -->
    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Formulario para solicitud de turno -->
    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label for="especialidad_id" class="form-label">Especialidad</label>
            <select class="form-select" name="especialidad_id" required>
                <option value="">Seleccione...</option>
                <?php foreach ($especialidades as $esp): ?>
                    <option value="<?= $esp['id'] ?>"><?= htmlspecialchars($esp['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="fecha" class="form-label">Fecha (máx. 30 días)</label>
            <input type="date" class="form-control" name="fecha" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime('+30 days')) ?>" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Buscar Horario Disponible</button>
        </div>
    </form>

    <!-- Botón para volver al inicio -->
    <div class="mt-4">
        <a href="../index.php" class="btn btn-secondary">← Volver al Inicio</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
