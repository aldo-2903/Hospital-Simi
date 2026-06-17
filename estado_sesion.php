<?php
session_start();

if(isset($_SESSION['usuario_id'])){
    echo "si";
}else{
    echo "no";
}
?>