<?php
include_once("db.php");
session_start();

if($_SESSION['logado']){
  $userlogin = $_SESSION['usuario'];
  $iduser = $_SESSION['iduser'];

}else{
  $_SESSION['msglogado'] = "Fazer login para acessar o sistema.";
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle Financeiro Doméstico</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>



<body style="background-color:#ffdfcc">
<nav class="navbar navbar-expand-lg navbar-light" style="background-color:#ffdfcc">
  <a class="navbar-brand" href="index1.php"><img src="css/money.png" width="320px" alt=""></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index1.php"><img src="./css/add.png" width="25px"> Adicionar Receita / Despesa <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="listaContas.php"><img src="./css/list-ul.svg" width="25px"> Listar Contas / Filtrar por</a>
      </li>

     
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Add/Remover Descrições de Gastos
        </a>
        <div class="dropdown-menu"  aria-labelledby="navbarDropdownMenuLink" style="background-color:#ffefe6">
          <a class="dropdown-item" href="#"><img src="./css/add.png" width="25px"> Cadastrar Novo Tipo de Receita</a>
          <a class="dropdown-item" href="listaDescReceitas.php"><img src="./css/list-ul.svg" width="25px"> Lista de Tipos de Receitas</a>
          <hr>
          <a class="dropdown-item" href="addDespesa.php"><img src="./css/add.png" width="25px"> Cadastrar Novo Tipo de Despesa</a>
          <a class="dropdown-item" href="listaDescDespesas.php"><img src="./css/list-ul.svg" width="25px"> Lista de Tipos de Despesas</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<h6 class="text text-danger" style="text-align: left;">Usuário: <?php echo $userlogin; ?> <a href="sair.php">Sair</a></h6>

    <div class="alert alert-primary" role="alert">
        <form action="" method="post">
            <div class="form-group form-check form-check-inline">
            <fieldset>
                <legend>Inserir Novo Tipo de Receita</legend>

                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Descrição</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="receita" required autofocus>
                </div><br>

                <input type="submit" value="Inserir" class="btn btn-primary btn-lg btn-block">


            </fieldset>
            </div>
            <br>
        </form>
        <?php
            $receita = filter_input(INPUT_POST, "receita", FILTER_SANITIZE_STRING);

            if($receita){
                $insertDespesa = mysqli_query($conn, "INSERT INTO cat_receita (categoria, iduser) VALUES ('$receita', '$iduser')");

                if(mysqli_affected_rows($conn)){
                    $_SESSION['msg'] = "Receita adicionada com sucesso à lista de descrição de receitas.";
                    header("Location: listaDescReceitas.php");
                }else{

                    echo "ERRO ao adicionar nova descrição de receita.";   
                }
            }else{
                $_SESSION['msg'] = "É necessário preencher o campo antes de inserir.";
            
            }

            if($_SESSION['msg']):
              echo $_SESSION['msg'];
              $_SESSION['msg'] = "";
            endif;
            
        ?>
    </div>
    <footer style="background-color:#ffdfcc">Programa de Controle Financeiro</footer>

    
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>