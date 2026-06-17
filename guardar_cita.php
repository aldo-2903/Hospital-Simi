<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    echo "no_session";
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
    echo "no_paciente";
    exit;
}

$idPaciente = $paciente['id_paciente'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$motivo_consulta = $_POST['motivo'];
$tipo_cita = $_POST['tipo_cita'];
$modalidad = $_POST['modalidad'];

$sql = "
INSERT INTO cita
(
fecha_cita,
hora_cita,
motivo_consulta,
id_paciente,
tipo_cita,
modalidad,
fecha_registro,
)
VALUES
(
?,
?,
?,
?,
?,
?,
NOW()
)
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $fecha,
    $hora,
    $motivo_consulta,
    $idPaciente,
    $tipo_cita,
    $modalidad
]);

echo "ok";