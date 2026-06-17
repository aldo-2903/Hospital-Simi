<?php

$host = "mysql.railway.internal";
$usuario = "root";
$password = "IreqgJNcxhUWSJLalBlubYbTbgIBFqbH";
$basedatos = "railway";
$puerto = 3306;

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
