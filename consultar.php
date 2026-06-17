<?php

include("conexion.php");

$sql = "SHOW TABLES";

$resultado = $conexion->query($sql);

while($fila = $resultado->fetch(PDO::FETCH_NUM)){
    echo $fila[0] . "<br>";
}
?>
