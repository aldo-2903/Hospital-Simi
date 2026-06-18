<?php
session_start();

if(
    !isset($_SESSION['usuario_id']) ||
    $_SESSION['rol'] != 'admin'
){
    die("Acceso denegado");
}

include("conexion.php");

$sql = "
SELECT
id_medico,
nombre,
apellido_paterno,
apellido_materno,
telefono,
estado,
años_experiencia
FROM medico
ORDER BY apellido_paterno, apellido_materno
";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Médicos</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:linear-gradient(135deg,#e3f2fd,#f4f9fc);
    margin:0;
    min-height:100vh;
}

h1{
    text-align:center;
    color:#0d47a1;
}

table{
    width:95%;
    margin:30px auto;
    border-collapse:collapse;
    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

th{
    background:#1565c0;
    color:white;
    padding:15px;
    font-size:15px;
}

td{
    padding:14px;
    border-bottom:1px solid #eee;
}

tr:hover{
    background:#f5faff;
}

.btn_inicio{
    background:#f4c542;
    color:black;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    transition:.3s;
}

.btn_inicio:hover{
    transform:scale(1.05);
    background:#e0b52f;
}

</style>

</head>
<body>

<button class="btn_inicio"
        onclick="location.href='admin.php'">
    ← Regresar
</button>

<h1>Médicos Registrados</h1>

<table>

<tr>
    <th>ID</th>
    <th>Médico</th>
    <th>Teléfono</th>
    <th>Estado</th>
    <th>Experiencia</th>
    <th>Acciones</th>
</tr>

<?php foreach($medicos as $medico): ?>

<tr>

<td><?= $medico['id_medico'] ?></td>

<td>
<?= $medico['nombre'] . " " .
   $medico['apellido_paterno'] . " " .
   $medico['apellido_materno'] ?>
</td>

<td><?= $medico['telefono'] ?></td>

<td><?= $medico['estado'] ?></td>

<td><?= $medico['años_experiencia'] ?> años</td>

<td>
    Editar
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>
