<?php
session_start();
include_once("db.php");

function valida_float($num){
    if(is_int($num)){
        $num = (double) $num;
        return $num;
    }else{
        $num = str_replace(",", ".", $num);
        return (double) $num;
    }
}

$id = $_POST['id'];


$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_POST, "valor");
$valor = valida_float($valor);
$data = $_POST['data'];
$categoria = filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_STRING);
$comentario = filter_input(INPUT_POST, "comentario", FILTER_SANITIZE_STRING);
$filtro = $_POST['filtro'];

if(isset($descricao) and isset($valor) and isset($data) and isset($filtro)){
    $insereConta = mysqli_query($conn, "UPDATE controle SET descricao='$descricao', valor='$valor', data='$data', categoria='$categoria', comentario='$comentario', tipo='$filtro' WHERE id='$id'");

    if(mysqli_affected_rows($conn)){
        echo $_SESSION['editaconta'] = "Conta editada com sucesso.";
        header("Location: listaContas.php");
    }else{
        echo $_SESSION['editaconta'] = "Erro ao editar conta.";
        header("Location: listaContas.php");
    }
}else{
    $_SESSION['msg'] = "ERRO! É necessário preencher todos os campos do formulário.";
    header("Location: listaContas.php");
    
}

