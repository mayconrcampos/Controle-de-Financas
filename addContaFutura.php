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
    <link rel="stylesheet" href="css/style.css">
</head>
<!-- Início da Nav -->


<body class="bodyindex">
<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color:#ffdfcc"> 
  <a class="navbar-brand" href="#"><img src="css/money.png" width="320px"></a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#"><img src="./css/add.png" width="25px"> Adicionar Receita / Despesa <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
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
          <a class="dropdown-item" href="addDespesa.php"><img src="./css/add.png" width="25px"> Cadastrar Novo Tipo de Despesa</a>
          <a class="dropdown-item" href="listaDescDespesas.php"><img src="./css/list-ul.svg" width="25px"> Lista de Tipos de Despesas</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<h6 class="text text-danger" style="text-align: left;">Usuário: <?php echo $userlogin; ?> <a href="sair.php">Sair</a></h6>

<!--Início da form FFDFCC-->
    <div class=" border border-dark" style="background-color:#ffefe6; text-align:center;">

        <form action="addContaFuturaDB.php" method="post">
            <div class="form-check form-check-inline">
            <fieldset>
                <legend>Adicionar Contas Parceladas / Gastos Fixos</legend>
        
        
                <div class="d-inline alert alert-primary" role="alert">
                <input type="radio" name="filtro" value="1" class="form-check-input mb-4" >
                <label for="receitas" class="form-check-label">Receita</label>
                </div>
            
                <div class="d-inline alert alert-danger" role="alert">
                <input type="radio" name="filtro" value="0" class="form-check-input" checked >
                <label for="despesas" class="form-check-label">Despesa</label>
                </div>
        
                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Descrição</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="descricao" placeholder="Digite a descrição" required autofocus>
                </div><br>


                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Entrada-Valor/Mês (R$)</span>
                    </div>
            
                    <input type="text" name="valor1" class="form-control" aria-label="Quantia" placeholder="Digite o valor da entrada ou parcela" required>
                        
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Total (R$)</span>
                    </div>
            
                    <input type="text" name="valorTotal" class="form-control" aria-label="Quantia" required>
                        
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Qtde de Parcelas</span>
                    </div>
            
                    <select class="custom-select" id="inputGroupSelect01" name="qtdeParcelas" required>
                        <option selected>------ Selecione ------</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>                       
                    </select>
                        
                </div>
         

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Data 1º Parcela</span>
                    </div>
                    <input type="date" aria-label="First name" class="form-control" name="pParcela" required>
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01" name="categoria">Forma de Pagto/Recebimento</label>
                    </div>


                    <select class="custom-select" id="inputGroupSelect01" name="formaPagto" required>
                        <option selected>------ Selecione ------</option>
                        <option value="">Á Vista Dinheiro</option>
                        <option value="">Á Vista Débito</option>
                        <option value="">Á Vista Boleto</option>
                        <option value="">Á Vista Pix</option>
                        <option value="">Á Vista Crédito</option>
                        <option value="">Á Vista cheque</option>
                        <option value="">Link Pagto MercadoPago</option>
                        <option value="">Á Vista Transf banc TED/DOC</option>
                        <option value="">Parcelado Crédito</option>
                        <option value="">Parcelado Crediário</option>                        
                    </select>
                </div>

            
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01" name="categoria">Categoria</label>
                    </div>


                    <select class="custom-select" id="inputGroupSelect01" name="categoria" required>
                        <option selected>------ Receitas ------</option>
                      
                      <?php
                        $queryReceitas = mysqli_query($conn, "SELECT id, categoria FROM cat_receita WHERE iduser='$iduser' ORDER BY categoria ASC");
                        while($receita = mysqli_fetch_assoc($queryReceitas)){?>
                            <option value=<?php echo $receita['categoria']; ?>><?php echo $receita['categoria'] ;?></option>
                <?php   
                        }?>
                        <option selected>------ Despesas ------</option>
                        <?php
                        $queryDespesas = mysqli_query($conn, "SELECT id, categoria FROM cat_despesa WHERE iduser='$iduser' ORDER BY categoria ASC");
                        while($despesa = mysqli_fetch_assoc($queryDespesas)){?>
                            <option value=<?php echo $despesa['categoria']; ?>><?php echo $despesa['categoria'] ;?></option>
                <?php   
                        }?>
                    </select>
                    
                </div>
                <div class="alert alert-primary" role="alert">
                        <a href="addReceita.php" class="alert-link">Adiciona Descrição de Receita</a>
                </div>

                <div class="alert alert-danger" role="alert">
                        <a href="addDespesa.php" class="alert-link"> Adiciona Descrição de Despesa</a>
                </div>

                <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Comentários</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="comentario">
                </div><br>



                <input type="submit" value="Inserir Conta Futura" class="btn btn-primary btn-lg btn-block mb-5">


            </fieldset>
            </div>
        </form>
        <?php
            if($_SESSION['msg']):
                echo $_SESSION['msg'];
                $_SESSION['msg'] = "";
            endif;

        ?>
    </div>


   

    <footer class="fixed-bottom text-center"  style="background-color:#ffdfcc">Programa para Gerenciamento e Controle Financeiro ® Maycon R. Campos - 07/2021</footer>


    





    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>