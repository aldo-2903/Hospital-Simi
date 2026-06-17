<?php
session_start();

if(isset($_SESSION['usuario_id'])){
    echo "ok";
}else{
    echo "no_session";
}
?>