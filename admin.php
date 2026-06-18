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
c.id_cita,
c.fecha_cita,
c.hora_cita,
c.estado,
c.tipo_cita,
c.modalidad,
c.motivo_consulta,
p.nombre,
p.apellido_paterno,
p.apellido_materno
FROM cita c
INNER JOIN paciente p
ON c.id_paciente = p.id_paciente
ORDER BY c.fecha_cita ASC, c.hora_cita ASC
";

$stmt = $conexion->prepare($sql);
$stmt->execute();

$citas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<title>Panel Administrador</title>

<style>

body{
    font-family:Arial;
    background:#f4f9fc;
    margin:0;
}

h1{
    text-align:center;
    color:#0d47a1;
}

table{
    width:95%;
    margin:20px auto;
    border-collapse:collapse;
    background:white;
    box-shadow:0 0 10px rgba(0,0,0,.15);
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

select{
    padding:6px;
}

button{
    background:#28a745;
    color:white;
    border:none;
    padding:6px 10px;
    border-radius:5px;
    cursor:pointer;
}

</style>

</head>
<body>

<h1>Panel de Administración</h1>

<table>

<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Tipo</th>
    <th>Modalidad</th>
    <th>Estado</th>
</tr>

<?php foreach($citas as $cita): ?>

<tr>

<tr>

<td><?= $cita['id_cita'] ?></td>

<td>
<?= $cita['nombre'] . " " .
   $cita['apellido_paterno'] . " " .
   $cita['apellido_materno'] ?>
</td>

<td><?= $cita['fecha_cita'] ?></td>

<td><?= substr($cita['hora_cita'],0,5) ?></td>

<td><?= $cita['tipo_cita'] ?></td>

<td><?= $cita['modalidad'] ?></td>

<td><?= $cita['estado'] ?></td>

</tr>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>
