<?php

// ainda vou implementar.

session_start();
include_once("db.php");

// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');

// Mantendo ID do usuário em variável global.
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
        <a class="nav-link" href="#"><img src="./css/list-ul.svg" width="25px"> Listar Contas / Filtrar por</a>
      </li>
    </ul>
  </div>
</nav>
<h6 class="text text-danger" style="text-align: left;">Usuário: <?php echo $userlogin; ?> <a href="sair.php">Sair</a></h6>

<!-- Filtrar por alguma coisa que o usuário digitar --->
<div class="border border-dark sticky-top" style="background-color:#ffefe6">
    <h3 style="text-align: center;">Listando Contas que ainda irão vencer.</h3>
<?php
  if($_SESSION['editaconta']){
    echo $_SESSION['editaconta'];
    $_SESSION['editaconta'] = "";
  }
?>
</div>


    <div class="border border-dark table-responsive" style="background-color:#ffefe6">

        <table class="table table-sm table-striped table-hover table-bordered">
            <thead class="thead">
                <tr>
                    <th>Descrição</th>
                    <th>Valor (R$)</th>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Comentário</th>
                    <th>Tipo</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                    $data_fim = date("Y/m/d");
                    $DespesaFutura = 0;
                    $ReceitaFutura = 0;
                    $vazio = 0;  
                    
                    // Query que contabiliza as contas futuras de entrada e saída.
                    $queryContasFuturas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle WHERE data > '$data_fim'");

                    while($ContasFuturas = mysqli_fetch_assoc($queryContasFuturas)){
                      $tipo = ($ContasFuturas['tipo']) ? true : false; 
                      if($tipo): $ReceitaFutura += $ContasFuturas['valor'];
                      else: $DespesaFutura += $ContasFuturas['valor'];
                      endif;
                      $vazio++;
    
                                                                  ?>
                    <tr>
                        
                        <td class="text-body"><?php echo $ContasFuturas['descricao'];?></td>

                        <?php 
                        $tipo = ($ContasFuturas['tipo']) ? true : false; 
                        if($tipo):
                            echo "<td class='table-primary'>".number_format($ContasFuturas['valor'], 2, ",", ".")."</td>";                    
                        else:
                            echo "<td class='table-danger'>".number_format($ContasFuturas['valor'], 2, ",", ".")."</td>";
                        endif;
                        ?>

                        <td class="text-body"><?php echo $ContasFuturas['data']; ?></td>
                        
                        <td class="text-body"><?php echo $ContasFuturas['categoria'];?></td>
                        
                        <td class="text-body"><?php echo $ContasFuturas['comentario'];?></td>
                        
                        <td class="text-body"><?php $tipo = ($ContasFuturas['tipo'] == 1) ? "Receita" : "Despesa"; echo $tipo;?></td>
                        
                        <td class="alert"><a   class="text-dark" href="editarConta.php?id=<?php echo $ContasFuturas['id']; ?>"><img src="css/pencil-fill.svg"></a></td>                
                        
                        <td class="alert"><a class="text text-white" href="excluirConta.php?id=<?php echo $ContasFuturas['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');"><img src="css/trash-fill.svg"></a></td>
                    </tr>
                   
            <?php   } ?>
                    
                    <tr class="fixed-bottom p-1">
                        <td class="table-primary border rounded">A Vencer +(R$)</td>
                        <td class="table-primary border rounded"><?php echo number_format($ReceitaFutura, 2, ",", ".");?></td>
                        <td class="table-danger border rounded">A Vencer -(R$)</td>
                        <td class="table-danger border rounded"><?php echo number_format($DespesaFutura, 2, ",", ".");?></td>
                    </tr>
            </tbody>
        </table>
        <?php 
          if($vazio == 0){
            echo "<h5 style='text-align:center;'>Não há nenhuma conta futura cadastrada!</h5>";
          }
          echo "<a href='listaContas.php'>Retornar para a Lista de Contas!</a>";
          if($_SESSION['contaExcluida']){
            echo $_SESSION['contaExcluida'];
            unset($_SESSION['contaExcluida']);
          }
          if($_SESSION['contaInserida']){
            echo $_SESSION['contaInserida'];
            unset($_SESSION['contaInserida']);
          }
        ?>
    </div>
  
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>