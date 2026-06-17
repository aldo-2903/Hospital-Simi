<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    die("No hay sesión iniciada");
}

echo "Hola " . $_SESSION['usuario_nombre'];
?>