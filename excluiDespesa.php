<?php
session_start();
include_once("db.php");

$id = $_GET['id'];

$deletaDespesa = mysqli_query($conn, "DELETE FROM cat_despesa WHERE id='$id'");

if(mysqli_affected_rows($conn)):
    $_SESSION['msg'] = "Descrição de Despesa excluida com sucesso!";
    header("Location: listaDescDespesas.php");
else:
    $_SESSION['msg'] = "Erro ao excluir conta!";
    header("Location: listaContas.php");
endif;