<?php
session_start();

if($_SESSION['logado']){
    $_SESSION['logado'] = false;
    unset($_SESSION['usuario']);
    unset($_SESSION['id']);
    header("Location: index.php");
}