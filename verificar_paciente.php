<?php

session_start();
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    echo "no_session";
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "
SELECT id_paciente
FROM paciente
WHERE id_usuario = ?
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idUsuario]);

if($stmt->rowCount() > 0){

    echo "si_paciente";

}else{

    echo "no_paciente";

}
?>