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

.encabezado{
    background:linear-gradient(135deg,#0077b6,#00b4d8);
    color:white;
    text-align:center;
    padding:30px;
    margin-bottom:30px;
    box-shadow:0 4px 10px rgba(0,0,0,.2);
}

.encabezado h1{
    margin:0;
    font-size:40px;
}

.encabezado p{
    margin-top:10px;
    opacity:.9;
}
    
body{
    background:#f4f9fc;
    font-family:Arial,sans-serif;
}

.contenedor{
    width:90%;
    max-width:900px;
    margin:30px auto;
}

.contenedor-boton{
    display:flex;
    justify-content:center;
    margin:20px 0;
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
    padding:25px;
    margin-bottom:20px;
    border-radius:15px;
    box-shadow:0 6px 15px rgba(0,0,0,.12);
    border-left:8px solid #0077b6;
    transition:.3s;
}

.cita:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 25px rgba(0,0,0,.18);
}

.cita h3{
    color:#0077b6;
    margin-bottom:10px;
}

.cancelar{
    width:100%;
    margin-top:15px;
    background:#dc3545;
    color:white;
    border:none;
    padding:12px;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
    transition:.3s;
}

.cancelar:hover{
    background:#b02a37;
    transform:scale(1.02);
}

.estado{
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    color:white;
    font-weight:bold;
}

.btn-inicio{
    width:auto !important;
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
    
<div class="contenedor-boton">
    <button class="btn-inicio" onclick="location.href='index.php'">Regresar</button>
</div>

<header class="encabezado">
    <h1>Mis Citas</h1>
    <p>Consulta y administra tus citas médicas</p>
</header>
    
<div class="contenedor">

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

    $fechaCita = strtotime($cita['fecha_cita']);
    $hoy = strtotime(date("Y-m-d"));
    $dias = floor(($fechaCita - $hoy) / 86400);

    if($cita['estado'] == "Cancelada"){
    $textoDias = "❌ Cita cancelada";
}
    
    if($dias > 0){
    $textoDias = "⏳ Faltan $dias días";
    }elseif($dias == 0){
    $textoDias = "La cita es hoy";
    }else{
    $textoDias = "Fecha pasada";
}
}

?>

<div class="cita" style="border-left:8px solid <?= $borde ?>">

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

    <form action="cancelar_cita.php" method="POST" onsubmit="return confirm('¿Seguro que deseas cancelar esta cita?')">

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
