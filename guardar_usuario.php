<?php

include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$sql = "SELECT id FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$correo]);

if ($stmt->rowCount() > 0) {
    echo "error:correo_duplicado";
    exit;
}

$sql = "
INSERT INTO usuarios
(
nombre,
correo,
telefono,
password
)
VALUES
(
?,
?,
?,
?
)
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $nombre,
    $correo,
    $telefono,
    $passwordHash
]);
?>
