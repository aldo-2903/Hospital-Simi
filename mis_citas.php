<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    header("Location: iniciar.html");
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "
SELECT id_paciente
FROM paciente
WHERE id_usuario = ?
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idUsuario]);

$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$paciente){
    die("No existe paciente asociado");
}

$idPaciente = $paciente['id_paciente'];

$sql = "
SELECT
id_cita,
fecha_cita,
hora_cita,
estado,
tipo_cita,
modalidad,
motivo_consulta
FROM cita
WHERE id_paciente = ?
ORDER BY fecha_cita, hora_cita
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idPaciente]);

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Citas</title>

<style>

body{
    font-family:Arial;
    background:#f4f4f4;
}

.contenedor{
    width:90%;
    margin:30px auto;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#0d47a1;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    border:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

</style>

</head>
<body>

<div class="contenedor">

<h1>Mis Citas</h1>

<table>

<tr>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Tipo</th>
    <th>Modalidad</th>
    <th>Estado</th>
    <th>Motivo</th>
</tr>

<?php foreach($citas as $cita): ?>

<tr>

<td><?= $cita['fecha_cita'] ?></td>
<td><?= $cita['hora_cita'] ?></td>
<td><?= $cita['tipo_cita'] ?></td>
<td><?= $cita['modalidad'] ?></td>
<td><?= $cita['estado'] ?></td>
<td><?= htmlspecialchars($cita['motivo_consulta']) ?></td>

</tr>

<?php endforeach; ?>

</table>

</div>

</body>
</html>