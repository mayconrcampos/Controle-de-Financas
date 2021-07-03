<?php
session_start();
include_once("db.php");
include("email.php");

if(isset($_POST['usuario']) and isset($_POST['senha']) and isset($_POST['senha2'])){
    // Verificando se as duas senhas inseridas são iguais.
    if($_POST['senha'] == $_POST['senha2']){
        // Recebendo usuário e senha
        $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
        $senha = md5(mysqli_real_escape_string($conn, $_POST['senha']));
        
        // Verificar se usuário já existe dentro do banco de dados;
        $existeUser = mysqli_query($conn, "SELECT usuario FROM userlogin WHERE usuario='$usuario'");
        $existeResultado = mysqli_fetch_assoc($existeUser);

        if(empty($existeResultado)){
            // Inserir usuário e senha no banco de dados;
            $status = 0;
            $insereUser = mysqli_query($conn, "INSERT INTO userlogin (usuario, senha, status) VALUES ('$usuario', '$senha', '$status')");

            // Testando se usuário foi inserido com sucesso.
            if(mysqli_affected_rows($conn)){
                sendEmail($usuario);
                $_SESSION['msgsucesso'] = "Usuário adicionado com sucesso!";
                header("Location: index.php");
            }else{
                $_SESSION['msgerro'] = "Erro ao inserir usuário!";
                header("Location: cadastrouser.php");
            }

        }else{
            $_SESSION['msgerro'] = "Usuário já existe! Somente faça o login.";
            header("Location: index.php");
        }
        
    }else{
        $_SESSION['msgerro'] = "As senhas não conferem.";
        header("Location: cadastrouser.php");
    }



}else{
    $_POST['msgerro'] = "ERRO! é preciso preencher os campos.";
    header("Location: cadastrouser.php");
}
