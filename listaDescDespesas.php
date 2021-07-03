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
<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color:#ffdfcc">
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
          <a class="dropdown-item" href="addDespesa.php"><img src="./css/add.png" width="25px"> Cadastrar Novo Tipo de Despesa</a>
          <a class="dropdown-item" href="#"><img src="./css/list-ul.svg" width="25px"> Lista de Tipos de Despesas</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<h6 class="text text-danger" style="text-align: left;">Usuário: <?php echo $userlogin; ?> <a href="sair.php">Sair</a></h6>


        <div class="border table-responsive" style="background-color:#ffefe6">
            <table class="table table-sm table-striped table-hover table-bordered">
                <thead class="thead">
                    <tr>
                        <th>Descrição</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $queryDescDespesas = mysqli_query($conn, "SELECT * FROM cat_despesa WHERE iduser='$iduser' ORDER BY categoria");
                    $conta = 0;
                    while($linha = mysqli_fetch_assoc($queryDescDespesas)){ 
                        $conta++;                                           ?>
                        <tr>
                            <td><?php echo $linha['categoria']; ?></td>
                            <td><a href="editaDespesa.php?id=<?php echo $linha['id']; ?>"><img src="css/pencil-fill.svg"></a></td>
                            <td><a href="excluiDespesa.php?id=<?php echo $linha['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');"><img src="css/trash-fill.svg"></a></td>
                        </tr>
            <?php   } 
                    if($conta == 0){
                      echo "Não há Nenhuma Descrição de Despesas em sua lista. Comece a cadastrar agora mesmo!<br>";
                      echo "<a href='addDespesa.php'>Clique aqui para Cadastrar uma Nova Descrição.</a>";
                    }else{  ?>
                    </tbody>
            </table>
                        <a href='addDespesa.php'>Clique aqui para Cadastrar uma Nova Descrição.</a>
              <?php } ?>    
                
        </div>
        
        
        <?php
            if($_SESSION['msg']):
                echo $_SESSION['msg'];
                $_SESSION['msg'] = "";
            endif;
        ?>
    </div>

    
    <footer class="fixed-bottom" style="background-color:#ffdfcc">Programa de Controle Financeiro</footer>

    
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>