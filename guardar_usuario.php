<?php

include("conexion.php");

$nombre = $_POST['text'];
$correo = $_POST['email'];
$telefono = $_POST['tel'];
$password = $_POST['password'];

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
