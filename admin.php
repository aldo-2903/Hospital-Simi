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

$total = count($citas);

$programadas = 0;
$confirmadas = 0;
$atendidas = 0;

foreach($citas as $c){

    if($c['estado'] == "Programada")
        $programadas++;

    if($c['estado'] == "Confirmada")
        $confirmadas++;

    if($c['estado'] == "Atendida")
        $atendidas++;
}

?>

<!DOCTYPE html>
<title>Panel Administrador</title>

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

select{
    padding:8px;
    border-radius:6px;
    border:1px solid #ccc;
}

.header_admin{
    background:#0d47a1;
    color:white;
    padding:25px;
    position:relative;
    text-align:center;
}

.titulo_admin h1{
    margin:0;
    font-size:38px;
    color:white;
}

.titulo_admin p{
    margin-top:8px;
    font-size:18px;
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
    
.btn_actualizar{
    background:linear-gradient(45deg,#28a745,#34ce57);
    color:white;
    border:none;
    padding:8px 15px;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
}

.btn_actualizar:hover{
    transform:scale(1.08);
}
    
button{
    background:#28a745;
    color:white;
    border:none;
    padding:6px 10px;
    border-radius:5px;
    cursor:pointer;
}

.estado{
    padding:8px 14px;
    border-radius:30px;
    color:white;
    font-weight:bold;
    display:inline-block;
    min-width:110px;
}

.stats{
    width:95%;
    margin:20px auto;
    display:flex;
    gap:20px;
    justify-content:center;
}

.card{
    background:white;
    padding:20px;
    width:180px;
    text-align:center;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,.1);
}

.card h2{
    color:#0d47a1;
    margin-bottom:10px;
}

.card p{
    font-weight:bold;
}
    
</style>

</head>
<body>

<div class="header_admin">
    <div class="titulo_admin">
        <h1>Panel de Administración</h1>
        <p>Gestión de citas médicas</p>
    </div> 

    <button class="btn_inicio"
        onclick="location.href='index.php'">
        Inicio
    </button>
</div>

<div class="stats">

    <div class="card">
        <h2><?= $total ?></h2>
        <p>Total Citas</p>
    </div>

    <div class="card">
        <h2><?= $programadas ?></h2>
        <p>Programadas</p>
    </div>

    <div class="card">
        <h2><?= $confirmadas ?></h2>
        <p>Confirmadas</p>
    </div>

    <div class="card">
        <h2><?= $atendidas ?></h2>
        <p>Atendidas</p>
    </div>

</div>
    
<table>

<tr>
    <th>ID</th>
    <th>Paciente</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Tipo</th>
    <th>Modalidad</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>

<?php foreach($citas as $cita): ?>

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

<td>
<?php
$color = "#6c757d";

switch($cita['estado']){

    case "Programada":
        $color = "#ffc107";
        break;

    case "Confirmada":
        $color = "#28a745";
        break;

    case "En espera":
        $color = "#fd7e14";
        break;

    case "Atendida":
        $color = "#007bff";
        break;

    case "Cancelada":
        $color = "#dc3545";
        break;

    case "No asistió":
        $color = "#343a40";
        break;
}
?>
<span class="estado"
      style="background:<?= $color ?>">
    <?= $cita['estado'] ?>
</span>>
</td>

<td>
    
<?php if($cita['estado'] == 'Cancelada'): ?>

    <span style="
        color:white;
        background:#dc3545;
        padding:8px 12px;
        border-radius:6px;
        font-weight:bold;
    ">
        Cita cancelada
    </span>

<?php else: ?>
    
<form action="actualizar_estado.php" method="POST" onsubmit="return confirm('¿Deseas actualizar el estado de esta cita?')" >

    <input
        type="hidden"
        name="id_cita"
        value="<?= $cita['id_cita'] ?>"
    >

    <select name="estado">

        <option value="Programada" <?= $cita['estado']=="Programada" ? "selected" : "" ?>>
            Programada
        </option>

        <option value="Confirmada" <?= $cita['estado']=="Confirmada" ? "selected" : "" ?>>
            Confirmada
        </option>

        <option value="En espera" <?= $cita['estado']=="En espera" ? "selected" : "" ?>>
            En espera
        </option>

        <option value="Atendida" <?= $cita['estado']=="Atendida" ? "selected" : "" ?>>
            Atendida
        </option>

        <option value="No asistió" <?= $cita['estado']=="No asistió" ? "selected" : "" ?>>
            No asistió
        </option>

    </select>

    <button type="submit" class="btn_actualizar">
        Actualizar
    </button>

</form>

<?php endif; ?>
    
</td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>
