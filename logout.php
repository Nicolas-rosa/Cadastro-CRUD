<?php 
if(!isset($_SESSION)){ //se seção estiver ocorrendo
    session_start();
}
session_destroy();//destroi a sessão

header("Location: index.php");
?>