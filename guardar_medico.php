<?php
session_start();
include("conexion.php");

$sql = "
INSERT INTO medico
(
nombre,
apellido_paterno,
apellido_materno,
cedula_profesional,
telefono,
correo,
años_experiencia,
)
VALUES
(
?,
?,
?,
?,
?,
?,
?,
)
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $_POST['nombre'],
    $_POST['apellido_paterno'],
    $_POST['apellido_materno'],
    $_POST['cedula_profesional'],
    $_POST['telefono'],
    $_POST['correo'],
    $_POST['años_experiencia'],
]);

header("Location: medicos.php");
exit;
?>