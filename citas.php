<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['usuario_id'])){
    header("Location: iniciar.html");
    exit;
}

$idUsuario = $_SESSION['usuario_id'];

$sql = "
SELECT nombre, correo, telefono
FROM usuarios
WHERE id_usuario = ?
";

$stmt = $conexion->prepare($sql);
$stmt->execute([$idUsuario]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Agendar Cita</title>

<style>

.toast {
    position: fixed;
    top: 20px;
    left: 50%;
    background: #333;
    color: white;
    padding: 16px 24px;
    border-radius: 8px;
    opacity: 0;
    transform: translateX(-50%) translateY(-20px);
    transition: all 0.3s ease;
    font-size: 18px;
    font-family: Arial;
    z-index: 9999;
}

.toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(0);
}

.toast.success {
    background: #28a745;
}

.toast.error {
    background: #dc3545;
}
    
body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
    margin:0;
}

header{
    background:#0d47a1;
    color:white;
    text-align:center;
    padding:20px;
}

.contenedor{
    width:50%;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,.2);
}

input, select{
    width:100%;
    padding:12px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:5px;
}

input[readonly]{
    background:#f0f0f0;
    color:#555;
}

button{
    width:100%;
    padding:12px;
    background:#0099cc;
    color:white;
    border:none;
    border-radius:5px;
    font-size:18px;
    cursor:pointer;
}

button:hover{
    background:#0077a3;
}

.boton-inicio{
    width:auto !important;
    padding:10px 20px;
    background:#f4c542;
    color:black;
    margin:15px;
    font-size:16px;
}

.boton-inicio:hover{
    background:#e0b52f;
}
</style>

</head>
<body>

<header>
    <h1>Agendar Cita Médica</h1>
</header>

<center>
    <button type="button"
            class="boton-inicio"
            onclick="location.href='index.html'">
         Inicio
    </button>
</center>

<div class="contenedor">

<form id="formCita">

<label>Nombre:</label>
<input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" readonly>

<label>Correo electrónico:</label>
<input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" readonly>

<label>Teléfono:</label>
<input type="tel" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" readonly>

<label>Tipo De Cita:</label>
<select name="tipo_cita" required>
    <option>Primera vez</option>
    <option>Seguimiento</option>
    <option>Urgencia</option>
    <option>Interconsulta</option>
</select>

<label>Modalidad:</label>
<select name="modalidad" required>
    <option>Presencial</option>
    <option>Virtual</option>
</select>

<label>Fecha:</label>
<input type="date" id="fecha" name="fecha" required>

<label>Hora (Horas completas) :</label>
<label>Horario de atención de 07:00 a 22:00 hrs</label>
<input type="time" id="hora" name="hora" min="07:00" max="22:00" step="3600" required>

<label>Motivo De Consulta:</label>
<input type="text" id="motivo" name="motivo_consulta" maxlength="99">
<small id="contador">0 / 99</small>

<button type="submit">Agendar Cita</button>

</form>

</div>

    <div id="toast" class="toast"></div>

<script>
const hoy = new Date().toISOString().split("T")[0];
document.getElementById("fecha").min = hoy;
</script>

<script>
const motivo = document.getElementById("motivo");
const contador = document.getElementById("contador");

    motivo.addEventListener("input", () => {
    contador.textContent = motivo.value.length + " / 99";
});
</script>

<script>
    document.getElementById("hora").addEventListener("change", function() {
    let partes = this.value.split(":");
        
    if(partes.length >= 2){
        this.value = partes[0] + ":00";
    }

});
</script>

<script>
function showToast(message, type = "success") {

    const toast = document.getElementById("toast");

    toast.className = "toast";
    toast.textContent = message;

    toast.classList.add("show", type);

    setTimeout(() => {
        toast.classList.remove("show", "success", "error");
    }, 3000);
}
</script>
    
<script>
    document.getElementById("formCita").addEventListener("submit", function(e){

    e.preventDefault();

    const datos = new FormData(this);

    fetch("guardar_cita.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.text())
    .then(data => {
    
        if(data.trim() === "ok"){
            showToast("Cita agendada correctamente", "success");
            setTimeout(() => {
            window.location.href = "index.html";
        }, 2000);
            
        }else{
            showToast(data, "error");
        }
    });
});
</script>

</body>
</html>
