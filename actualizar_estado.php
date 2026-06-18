<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){
    die("Acceso denegado");
}

$idCita = $_POST['id_cita'];
$estado = $_POST['estado'];

$sql = "
UPDATE cita
SET estado = ?
WHERE id_cita = ?
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $estado,
    $idCita
]);

header("Location: admin.php");
exit;
?>