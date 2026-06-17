<?php

include("conexion.php");

$nombre = $_POST['Nombre Completo'];
$correo = $_POST['Correo Electrónico'];
$telefono = $_POST['Número Telefónico'];
$password = $_POST['Contraseña'];

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

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

echo "Usuario registrado correctamente";

?>
