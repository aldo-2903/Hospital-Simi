<?php
session_start();
include("conexion.php");

$correo = $_POST['correo'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT * FROM usuarios WHERE correo = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$correo]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['usuario_id'] = $user['id_usuario'];
    $_SESSION['usuario_nombre'] = $user['nombre'];

    echo "ok";
} else {
    echo "error";
}
?>
