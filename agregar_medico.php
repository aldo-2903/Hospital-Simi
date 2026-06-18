<!DOCTYPE html>
<head>
<title>Agregar Médico</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:linear-gradient(135deg,#e3f2fd,#f4f9fc);
    margin:0;
    min-height:100vh;
}

.contenedor{
    width:70%;
    max-width:900px;
    margin:30px auto;
    background:white;
    padding:30px;
    border-radius:12px;
    box-shadow:0 0 15px rgba(0,0,0,.15);
}

h1{
    text-align:center;
    color:#0d47a1;
}

h2{
    margin-top:25px;
    color:#0d47a1;
    border-bottom:2px solid #ddd;
    padding-bottom:5px;
}

input, select{
    width:100%;
    padding:12px;
    margin:8px 0;
    border:1px solid #ccc;
    border-radius:6px;
}

button{
    width:100%;
    padding:14px;
    margin-top:20px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:16px;
    font-weight:bold;
}

.btn-guardar{
    background:#28a745;
    color:white;
}

.btn-guardar:hover{
    background:#218838;
}

.btn_regresar{
    background:#f4c542;
    color:black;
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
    transition:.3s;
}

.btn_regresar:hover{
    transform:scale(1.05);
    background:#e0b52f;
}

</style>

</head>
<body>

<div class="contenedor">

<h1>Agregar Médico</h1>

<form action="guardar_medico.php" method="POST">

<h2>Información Personal</h2>

<input type="text"
       name="nombre"
       id="nombre"
       placeholder="Nombre"
       required>

<input type="text"
       name="apellido_paterno"
       id="apellido_paterno"
       placeholder="Apellido paterno"
       required>

<input type="text"
       name="apellido_materno"
       id="apellido_materno"
       placeholder="Apellido materno"
       required>

<h2>Información Profesional</h2>

<input type="text"
       name="cedula_profesional"
       id="cedula_profesional"
       placeholder="Cédula profesional"
       required>

<input type="number"
       name="años_experiencia"
       id="años_experiencia"
       placeholder="Años de experiencia"
       min="0"
       required>

<h2>Contacto</h2>

<input type="tel"
       name="telefono"
       id="telefono"
       placeholder="Teléfono"
       required>

<input type="email"
       name="correo"
       id="correo"
       placeholder="Correo"
       required>

<button type="submit" class="btn-guardar">
    Guardar Médico
</button>

</form>

<button
class="btn-regresar"
onclick="location.href='medicos.php'">
    Regresar
</button>

</div>

</body>
</html>