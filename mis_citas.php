<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    header("Location: iniciar.html");
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

$paciente = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$paciente){
    die("No existe paciente asociado");
}

$idPaciente = $paciente['id_paciente'];

$sql = "
SELECT
id_cita,
fecha_cita,
hora_cita,
estado,
tipo_cita,
modalidad,
motivo_consulta
FROM cita
WHERE id_paciente = ?
ORDER BY fecha_cita, hora_cita
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idPaciente]);

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis Citas</title>

<style>

body{
    background:#f4f9fc;
    font-family:Arial,sans-serif;
}

.contenedor{
    width:90%;
    max-width:900px;
    margin:30px auto;
}


    
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#0d47a1;
    color:white;
    padding:12px;
}

td{
    padding:10px;
    border:1px solid #ddd;
}

tr:hover{
    background:#f5f5f5;
}

.cita{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:12px;
    box-shadow:0 0 10px rgba(0,0,0,.15);
}

.cita h3{
    color:#0077b6;
    margin-bottom:10px;
}

.cancelar{
    background:#dc3545;
    margin-top:15px;
}

.cancelar:hover{
    background:#c82333;
}

.estado{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-weight:bold;
}

.btn-inicio{
    background:#f4c542;
    color:black;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    margin-bottom:20px;
    transition:.3s;
}

.btn-inicio:hover{
    transform:scale(1.05);
    background:#e0b52f;
}

</style>

</head>
<body>

<span class="estado" style="background:<?= $color ?>">
    <?= $cita['estado'] ?>
</span>
    
<button class="btn-inicio" onclick="location.href='index.html'">Regresar</button>
    
<div class="contenedor">

<h1>Mis Citas</h1>

<?php foreach($citas as $cita): ?>

<?php

$color = "#6c757d";

switch($cita['estado']){

    case "Programada":
        $color = "#ffc107";
        break;

    case "Confirmada":
        $color = "#28a745";
        break;

    case "Atendida":
        $color = "#007bff";
        break;

    case "Cancelada":
        $color = "#dc3545";
        break;
}

?>

<div class="cita">

    <h3>
        <?= $cita['fecha_cita'] ?>
        - <?= substr($cita['hora_cita'],0,5) ?>
    </h3>

    <p><b>Tipo:</b> <?= $cita['tipo_cita'] ?></p>

    <p><b>Modalidad:</b> <?= $cita['modalidad'] ?></p>

    <p><b>Motivo:</b> <?= htmlspecialchars($cita['motivo_consulta']) ?></p>

    <p>
        <b>Estado:</b>
        <span class="estado" style="background:<?= $color ?>">
            <?= $cita['estado'] ?>
        </span>
    </p>

    <?php if($cita['estado'] == "Programada"): ?>

    <form action="cancelar_cita.php" method="POST">

        <input
            type="hidden"
            name="id_cita"
            value="<?= $cita['id_cita'] ?>"
        >

        <button class="cancelar">
            Cancelar cita
        </button>

    </form>
    <?php endif; ?>

</div>
<?php endforeach; ?>

</div>

</body>
</html>
