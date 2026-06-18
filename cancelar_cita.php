<?php
session_start();
include("conexion.php");

$idCita = $_POST['id_cita'];

$sql = "
UPDATE cita
SET estado='Cancelada'
WHERE id_cita=?
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idCita]);

header("Location: mis_citas.php");
exit;
?>