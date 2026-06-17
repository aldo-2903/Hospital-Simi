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