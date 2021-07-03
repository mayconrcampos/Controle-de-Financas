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
//1660+440

$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_STRING);
$valor = filter_input(INPUT_POST, "valor");
$valor = valida_float($valor);
$data = $_POST['data'];
$categoria = filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_STRING);
$comentario = filter_input(INPUT_POST, "comentario", FILTER_SANITIZE_STRING);
$filtro = filter_input(INPUT_POST, "filtro", FILTER_SANITIZE_NUMBER_INT);
$iduser = $_SESSION['iduser'];

if($descricao and $valor and $data and $categoria){
    $insereConta = mysqli_query($conn, "INSERT INTO controle (descricao, valor, data, categoria, comentario, tipo, iduser) VALUES ('$descricao', '$valor', '$data', '$categoria','$comentario', '$filtro', '$iduser')");

    if(mysqli_affected_rows($conn)){
        echo $_SESSION['contaInserida'] = "<br>Conta inserida com sucesso.";
        header("Location: listaContas.php");
    }else{
        echo $_SESSION['msg'] = "Erro ao inserir conta.";
        header("Location: index1.php");
    }
}else{
    header("Location: index1.php");
    $_SESSION['msg'] = "ERRO! É necessário preencher todos os campos do formulário.";
    
}



