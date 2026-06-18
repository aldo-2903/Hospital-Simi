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
    background:#f4f9fc;
    font-family:Arial,sans-serif;
}

h1{
    text-align:center;
    color:#0d47a1;
}

table{
    width:90%;
    margin:auto;
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
    text-align:center;
}

tr:hover{
    background:#f5f5f5;
}

.btn-inicio{
    margin:20px;
    padding:10px 20px;
    background:#f4c542;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
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