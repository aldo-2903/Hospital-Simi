<?php
include("conexion.php");

try {

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT correo FROM usuarios WHERE correo = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$correo]);

    if ($stmt->fetch()) {
        echo "error:correo_duplicado";
        exit;
    }

    $sql = "INSERT INTO usuarios (nombre, correo, telefono, password)
            VALUES (?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->execute([$nombre, $correo, $telefono, $passwordHash]);

    echo "ok";

} catch (PDOException $e) {
    echo "error_sql: " . $e->getMessage();
}
?>
