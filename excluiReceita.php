<?php
session_start();
include_once("db.php");

$id = $_GET['id'];

$deletaReceita = mysqli_query($conn, "DELETE FROM cat_receita WHERE id='$id'");

if(mysqli_affected_rows($conn)):
    $_SESSION['msg'] = "Descrição de Receita excluida com sucesso!";
    header("Location: listaDescReceitas.php");
else:
    $_SESSION['msg'] = "Erro ao excluir conta!";
    header("Location: listaContas.php");
endif;