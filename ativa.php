<?php
session_start();
include_once("db.php");

$usuario = $_GET['usuario'];
$status = 1;

$testaUser = mysqli_query($conn, "SELECT * FROM userlogin WHERE usuario='$usuario' AND status='$status'");
$resultTestaUser = mysqli_fetch_assoc($testaUser);

if(empty($resultTestaUser)){
    // Usuário não ativado. Pode dar UPDATE
    $updateUser = mysqli_query($conn, "UPDATE userlogin SET status='$status' WHERE usuario='$usuario'");

    if(mysqli_affected_rows($conn)){
        // UPDATE realizado com sucesso.
        $_SESSION['msgsucesso'] = "Conta ativada com sucesso!";
        header("Location: index.php");
    }else{
        // ERRO ao fazer UPDATE.
        $_SESSION['msgsucesso'] = "ERRO ao ativar conta!";
        header("Location: index.php");
    }
}else{
    // Usuário já ativado no sistema, somente fazer o login.
    $_SESSION['ativado'] = "Usuário $usuario já está ativado. Faça o login.";
    header("Location: index.php");
}