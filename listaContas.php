<?php
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
<form action="" method="POST" class="p-2">
  <div class="row">
    <div class="col-md-4">
      <input type="text" class="form-control" name="filtrar" placeholder="Digite neste campo para filtrar" autofocus>
      <small id="passwordHelpBlock" class="form-text text-muted">
            Digite: "despesa" p/ Filtrar todas as despesas
        </small>
        <small id="passwordHelpBlock" class="form-text text-muted">
            Digite: "receita" p/ Filtrar todas as receitas
        </small>
    </div>
    <div class="col-md-3">
      <input type="date" class="form-control" name="data_ini" placeholder="Digite neste campo para filtrar">
        <small id="passwordHelpBlock" class="form-text text-muted">
            Data Início
        </small>
    </div>
    <div class="col-md-3">
      <input type="date" class="form-control" name="data_fim" placeholder="Digite neste campo para filtrar">
      <small id="passwordHelpBlock" class="form-text text-muted">
            Data Fim
        </small>
    </div>
    <div class="col-mb-2">
      <input type="submit" class="form-control" value="Filtrar" class="p-3">
    </div>
  </div>
</form>
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
                    $filtrar = filter_input(INPUT_POST, "filtrar", FILTER_SANITIZE_STRING);

                    $data_inicio = $_POST['data_ini'];
                    $data_fim = $_POST['data_fim'];
                    
                    if($filtrar and !$data_inicio and !$data_fim){
                        $data_fim = date("Y/m/d");
                        $data_inicio = date("Y/m")."/01";
                        echo $data_inicio." - ".$data_fim;
                        
                        $filtrado = null;

                        if($filtrar == "receita"){
                          $filtrado = 1;
                          $filtrar = null;

                          $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE tipo LIKE '%$filtrado%' AND iduser='$iduser' AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");

                        }elseif($filtrar == "despesa"){
                          $filtrado = 0;
                          $filtrar = null;

                          $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE tipo LIKE '%$filtrado%' AND iduser='$iduser' AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");

                        }else{
                          $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE (descricao LIKE '%$filtrar%' OR categoria LIKE '%$filtrar%' OR comentario LIKE '%$filtrar%' AND iduser='$iduser') AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");
                        }
                        

                    }elseif(!$filtrar and !$data_inicio and !$data_fim){
                      $data_fim = date("Y/m/d");
                      $data_inicio = date("Y/m")."/01";
                      
                      $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE iduser='$iduser' AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");


                    }elseif($filtrar and $data_inicio and $data_fim){
                      $filtrado = "";
                      if($filtrar == "receita"){
                        $filtrado = 1;
                        $filtrar = null;

                        $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE tipo LIKE '$filtrado' AND iduser='$iduser' AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");

                      }elseif($filtrar == "despesa"){
                        $filtrado = 0;
                        $filtrar = null;

                        $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE tipo LIKE '$filtrado' AND iduser='$iduser' AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");

                      }else{
                        $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE (descricao LIKE '%$filtrar%' OR categoria LIKE '%$filtrar%' OR comentario LIKE '%$filtrar%' AND iduser='$iduser') AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");
                      }

                    }elseif(!$filtrar and $data_inicio and $data_fim){
                      $queryContas = mysqli_query($conn, "SELECT id, descricao, valor, DATE_FORMAT(data, '%d/%m/%Y') as 'data', categoria, comentario, tipo FROM controle  WHERE iduser='$iduser' AND data BETWEEN '$data_inicio' AND '$data_fim' ORDER BY data DESC");
                    }
                    
                    $contaReceita = 0;
                    $contaDespesa = 0;
                    $vazio = 0;         
                    while($conta = mysqli_fetch_assoc($queryContas)){
                        $vazio++;                                     ?>
                    <tr>
                        <?php 
                            $tipo = ($conta['tipo']) ? true : false; 
                            if($tipo): $contaReceita += $conta['valor'];
                            else: $contaDespesa += $conta['valor'];
                            endif;

                            $saldo = $contaReceita - $contaDespesa;
                        ?>
                        
                        <td class="text-body"><?php echo $conta['descricao'];?></td>

                        <?php 
                        $tipo = ($conta['tipo']) ? true : false; 
                        if($tipo):
                            echo "<td class='table-primary'>".number_format($conta['valor'], 2, ",", ".")."</td>";                    
                        else:
                            echo "<td class='table-danger'>".number_format($conta['valor'], 2, ",", ".")."</td>";
                        endif;
                        ?>

                        <td class="text-body"><?php echo $conta['data']; ?></td>
                        
                        <td class="text-body"><?php echo $conta['categoria'];?></td>
                        
                        <td class="text-body"><?php echo $conta['comentario'];?></td>
                        
                        <td class="text-body"><?php $tipo = ($conta['tipo'] == 1) ? "Receita" : "Despesa"; echo $tipo;?></td>
                        
                        <td class="alert"><a   class="text-dark" href="editarConta.php?id=<?php echo $conta['id']; ?>"><img src="css/pencil-fill.svg"></a></td>                
                        
                        <td class="alert"><a class="text text-white" href="excluirConta.php?id=<?php echo $conta['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este registro?');"><img src="css/trash-fill.svg"></a></td>
                    </tr>
                   
            <?php   } ?>
                    <tr><td></td></tr>
                    <tr><td></td></tr>
                    <tr class="fixed-bottom p-1">
                        <td class="table-primary border rounded">Total Receitas <strong>(R$)</strong></td>
                        <td class="table-primary border rounded"><?php echo number_format($contaReceita, 2, ",", ".");?></td>
                        <td class="table-danger border rounded">Total Despesas <strong>(R$)</strong></td>
                        <td class="table-danger border rounded"><?php echo number_format($contaDespesa, 2, ",", ".");?></td>
                        <?php 
                            if($saldo < 0):?>
                                <td class="table-danger border rounded">Saldo <strong>(R$)</strong></td>
                                <td class="table-danger border rounded"><?php echo number_format($saldo, 2, ",", ".");?></td>
                    <?php   else:?>
                                <td class="table-primary border rounded">Saldo <strong>(R$)</strong></td>
                                <td class="table-primary border rounded"><?php echo number_format($saldo, 2, ",", ".");?></td>
                    <?php   endif;?>     
                    </tr>
            </tbody>
        </table>
        <?php 
          if($vazio == 0){
            echo "<h5>Não há nenhuma conta cadastrada!</h5>";
            echo "<a href='index1.php'>Clique aqui para cadastrar!</a>";
          }
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