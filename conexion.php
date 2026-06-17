<?php

$host = "zephyr.proxy.rlwy.net";
$usuario = "root";
$password = "IreqgJNcxhUWSJLalBlubYbTbgIBFqbH";
$basedatos = "railway";
$puerto = 51145;

$conexion = new mysqli(
    $host,
    $usuario,
    $password,
    $basedatos,
    $puerto
);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

echo "Conexión exitosa";

?>
