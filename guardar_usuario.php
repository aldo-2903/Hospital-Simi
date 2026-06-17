<?php

include("conexion.php");

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$password = $_POST['password'];

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);
echo $nombre . "<br>";
echo $correo . "<br>";
echo $telefono . "<br>";
echo $password . "<br>";

$sql = "
INSERT INTO usuarios
(
nombre,
correo,
telefono,
password
)
VALUES
(
?,
?,
?,
?
)
";

$stmt = $conexion->prepare($sql);

$stmt->execute([
    $nombre,
    $correo,
    $telefono,
    $passwordHash
]);

echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script>
Swal.fire({
  title: '¡Éxito!',
  text: 'Usuario registrado correctamente',
  icon: 'success',
  confirmButtonText: 'OK'
}).then(() => {
  window.location.href = 'index.html';
});
</script>";
exit();

?>
