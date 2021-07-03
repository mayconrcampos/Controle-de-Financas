<?php
include_once("db.php");
session_start();

if($_SESSION['logado']){
  $userlogin = $_SESSION['usuario'];
  $iduser = $_SESSION['id'];
}else{
  $_SESSION['msglogado'] = "Fazer login para acessar o sistema.";
  header("Location: index.php");
}

if($_SESSION['msg']):
    echo $_SESSION['msg'];
    
    $_SESSION['msg'] = "";
endif;

$ide = $_GET['id'];
$editaConta = mysqli_query($conn, "SELECT descricao, valor, DATE_FORMAT(data, '%Y-%m-%d') as 'data', categoria, comentario, tipo FROM controle WHERE id='$ide'");

$linhaConta = mysqli_fetch_assoc($editaConta);



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
          <a class="dropdown-item" href="addReceita.php"><img src="./css/add.png" width="25px"> Cadastrar Novo Tipo de Receita</a>
          <a class="dropdown-item" href="listaDescReceitas.php"><img src="./css/list-ul.svg" width="25px"> Lista de Tipos de Receitas</a>
          <hr>
          <a class="dropdown-item" href="#"><img src="./css/add.png" width="25px"> Cadastrar Novo Tipo de Despesa</a>
          <a class="dropdown-item" href="listaDescDespesas.php"><img src="./css/list-ul.svg" width="25px"> Lista de Tipos de Despesas</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<h6 class="text text-danger" style="text-align: left;">Usuário: <?php echo $userlogin; ?> <a href="sair.php">Sair</a></h6>


    <div style="background-color:#ffefe6">

        <form action="editaContaDB.php" method="post">
            <div class="form-group form-check form-check-inline">
            <fieldset>
                <legend>Editar Conta</legend>

                <div class="d-inline alert alert-primary" role="alert">
                
                <?php
                    $checkedReceita = ($linhaConta['tipo']) ? "checked" : "";
                    $checkedDespesa = (!$linhaConta['tipo']) ? "checked" : "";
                ?>
                <input type="radio" name="filtro" value="1" class="form-check-input" <?php echo $checkedReceita; ?>>
                <label for="receitas" class="form-check-label">Receita</label>
                </div>

                <div class="d-inline alert alert-danger" role="alert">
                <input type="radio" name="filtro" value="0" class="form-check-input" <?php echo $checkedDespesa; ?>>
                <label for="despesas" class="form-check-label">Despesa</label>
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Descrição</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="descricao" value="<?php echo $linhaConta['descricao'];?>" required autofocus>
                </div><br>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">R$</span>
                    </div>
            
                    <input type="text" name="valor" class="form-control" aria-label="Quantia" value="<?php echo $linhaConta['valor'];?>" required>
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Data</span>
                    </div>
                    <input type="date" aria-label="First name" class="form-control" name="data" value="<?php echo $linhaConta['data'];?>" required>
                </div><br>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01" name="categoria">Categoria</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" name="categoria" value="">
                        <option selected>------ Receitas ------</option>
                      
                      <?php
                        $queryReceitas = mysqli_query($conn, "SELECT id, categoria FROM cat_receita ORDER BY categoria ASC");
                        while($receita = mysqli_fetch_assoc($queryReceitas)){?>
                            <option value=<?php echo $receita['categoria']; ?>><?php echo $receita['categoria'] ;?></option>
                <?php   
                        }?>
                        <option selected>------ Despesas ------</option>
                        <?php
                        $queryDespesas = mysqli_query($conn, "SELECT id, categoria FROM cat_despesa ORDER BY categoria ASC");
                        while($despesa = mysqli_fetch_assoc($queryDespesas)){?>
                            <option value=<?php echo $despesa['categoria']; ?>><?php echo $despesa['categoria'] ;?></option>
                <?php   
                        }?>
                        <option selected><?php echo $linhaConta['categoria'];?></option>
                    </select>
                    
                </div>
                <div class="alert alert-primary" role="alert">
                        <a href="addReceita.php" class="alert-link">Adiciona Receita</a>
                </div>

                <div class="alert alert-danger" role="alert">
                        <a href="addDespesa.php" class="alert-link"> Adiciona Despesa</a>
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Comentários</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="comentario" value="<?php echo $linhaConta['comentario'];?>">
                </div><br>


                <input type="hidden" name="id" value="<?php echo $ide;?>">
                <input type="submit" value="Editar" class="btn btn-primary btn-lg btn-block">


            </fieldset>
            </div>
        </form>
    </div>

    <footer style="background-color:#ffdfcc">Programa de Controle Financeiro</footer>

    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>