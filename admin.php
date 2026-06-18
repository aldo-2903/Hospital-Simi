<?php
session_start();

if(
    !isset($_SESSION['usuario_id']) ||
    $_SESSION['rol'] != 'admin'
){
    die("Acceso denegado");
}

include("conexion.php");

$sql = "
SELECT
c.id_cita,
c.fecha_cita,
c.hora_cita,
c.estado,
c.tipo_cita,
c.modalidad,
c.motivo_consulta,
p.nombre,
p.apellido_paterno,
p.apellido_materno
FROM cita c
INNER JOIN paciente p
ON c.id_paciente = p.id_paciente
ORDER BY c.fecha_cita DESC, c.hora_cita DESC
";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
