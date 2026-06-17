<?php

$host = "zephyr.proxy.rlwy.net";
$usuario = "root";
$password = "IreqgJNcxhUWSJLalBlubYbTbgIBFqbH";
$basedatos = "railway";
$puerto = 51145;

try {

    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$basedatos;charset=utf8",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa";

} catch (PDOException $e) {

    die("Error: " . $e->getMessage());

}
?>
