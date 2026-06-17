<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    echo "no_session";
    exit;
}

$idUsuario = $_SESSION['usuario_id'];
$sql = "
SELECT nombre
FROM usuarios
WHERE id_usuario = ?
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idUsuario]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$nombre = $usuario['nombre'];

$sql = "
INSERT INTO paciente
(
id_usuario,
nombre,
apellido_paterno,
apellido_materno,
fecha_nacimiento,
sexo,
curp,
direccion,
codigo_postal,
tipo_sangre
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
?,
?,
?,
NOW()
)
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $idUsuario,
    $nombre,
    $_POST['apellido_paterno'],
    $_POST['apellido_materno'],
    $_POST['fecha_nacimiento'],
    $_POST['sexo'],
    $_POST['curp'],
    $_POST['direccion'],
    $_POST['codigo_postal'],
    $_POST['tipo_sangre']
]);

echo "ok";
?>
