<?php
session_start();
include_once("db.php");

$id = $_GET['id'];

$deletaConta = mysqli_query($conn, "DELETE FROM controle WHERE id='$id'");

if(mysqli_affected_rows($conn)):
    $_SESSION['contaExcluida'] = "<br>Conta excluida com sucesso!";
    header("Location: listaContas.php");
else:
    $_SESSION['msg'] = "Erro ao excluir conta!";
    header("Location: listaContas.php");
endif;