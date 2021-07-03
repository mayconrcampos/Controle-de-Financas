<?php
    session_start();
   
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes - Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        #login {
            overflow: auto;
            border-radius: 5px 5px 5px;
            box-shadow: 1px 3px 5px black;
            padding: 15px;
            background-color: #ffefe6;
            margin-top: 5%;      
            margin-right: auto;
            margin-left: auto;
            width: 400px;
        }
        body {
            background-color: #FFDFCC;
        }
    </style>
</head>
<body>
<div id="login">
<img src="./css/money.png" width="370px">
<form class="form-control-sm" method="POST" action="cadastrouserDB.php">
    <legend style="text-align: center;">Faça seu Cadastro</legend>
  <div class="form-group-sm">
        <label for="exampleInputEmail1">Digite seu melhor Endereço de Email</label>
        <input type="email" class="form-control" id="exampleInputEmail1"    aria-describedby="emailHelp" placeholder="Enter email" name="usuario" required>
        
  </div>
  <div class="form-group">
        <label for="exampleInputPassword1">Digite sua Senha</label>
        <input type="password" class="form-control"     id="exampleInputPassword1" placeholder="Senha" name="senha" required>

        <label>Repita sua Senha</label>
        <input type="password" class="form-control"     id="exampleInputPassword1" placeholder="Repita a sua Senha" name="senha2" required>
        <small id="emailHelp" class="form-text text-muted">Aprenda a sempre utilizar senhas fortes.</small>
  </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

        <p class="text text-danger">
            <?php 
                if($_SESSION['msgerro']){
                    echo $_SESSION['msgerro'];
                    unset($_SESSION['msgerro']);
                }
            ?>
        </p>

        <a href="index.php">Retornar a Tela de Login</a>




</div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/   umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/    ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/    bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/  JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>