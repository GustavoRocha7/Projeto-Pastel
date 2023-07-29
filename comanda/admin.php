<?php
	include_once('../conexao.php');
		echo '
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>		
	';

	$sql = 'SELECT * FROM tab_produtos WHERE tipo = 0';
	try {
		$query = $bd->prepare($sql);
		$query->execute();
		$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$e->getMessage();
	}

	$sql1 = 'SELECT * FROM tab_produtos WHERE tipo = 1';
	try {
		$query1 = $bd->prepare($sql1);
		$query1->execute();
		$especiais = $query1->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$e->getMessage();
	}

	$sql2 = 'SELECT * FROM tab_produtos WHERE tipo = 2';
	try {
		$query2 = $bd->prepare($sql2);
		$query2->execute();
		$bebidas = $query2->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$e->getMessage();
	}

	$sql3 = 'SELECT id FROM tab_comanda ORDER BY id DESC LIMIT 1';
	try {
	    $query3 = $bd->prepare($sql3);
	    $query3->execute();
	    $idN = $query3->fetchColumn() + 1;


	} catch (Exception $e) {
	    $e->getMessage();
	}


    class Produto{
        public $id;
        public $quant;
        public $nome;
        public $valor;
    }
    session_start();

	if (!isset($_SESSION['scroll'])) {
		$_SESSION['scroll'] = true;
		echo '<script type="text/javascript">
				localStorage.clear();
			</script>';
	}

    if (isset($_POST['finalizar'])) {
    	if (!isset($_SESSION['produtos'])) {
    		echo '
			<script>
				$(document).ready(function(){
					 $("#erro").modal();
				});
			</script>';

    	}else{
			$total = $_POST['total'];
			$data = date('Y/m/d');
			$nome = "Comanda#".$idN;
			if (!empty($_POST['nome'])) {
				$nome = $_POST['nome'];
			}

			$sql = 'INSERT INTO tab_comanda(nome, valor , data, status) VALUES (:nome,:valor, :data ,1)';
			try {
				$query = $bd->prepare($sql);
				$query->bindParam(':nome', $nome);
				$query->bindParam(':valor', $total);
				$query->bindParam(':data', $data);
				$query->execute();

				$id_comanda = $bd->lastInsertId();

				foreach ($_SESSION['produtos'] as $pro) {
					$sql1 = 'INSERT INTO tab_itens(id_comanda, id_produto, qtde, subtotal) 
							 VALUES (:id_comanda, :id_produto, :qtde, :subtotal)';
					try {
						$query1 = $bd->prepare($sql1);
						$query1->bindParam(':id_comanda',$id_comanda);
						$query1->bindParam(':id_produto',$pro->id);
						$query1->bindParam(':qtde',$pro->quant);
						$query1->bindParam(':subtotal',$pro->valor);
						$query1->execute();

					} catch (Exception $e) {
						$e->getMessage();
					}

					$sql2 = 'UPDATE tab_produtos SET quant = quant - ? WHERE id = ?';
					try {
						$query2 = $bd->prepare($sql2);
						$query2->execute(array($pro->quant, $pro->id));

					} catch (Exception $e) {
						$e->getMessage();
					}
				}
				echo '
					<script>
						$(document).ready(function(){
							 $("#criar").modal();
						});
					</script>
					<script type="text/javascript">
						localStorage.clear();
					</script>';
		
				session_destroy();
			} catch (Exception $e) {
				$e->getMessage();
			}
		}
	}



	if (isset($_POST['cancelar'])) {
		echo '
			<script>
				$(document).ready(function(){
					 $("#cancelar").modal();
				});
			</script>';
	}
	if (isset($_POST['cancelar-modal'])) {
		session_destroy();
		header('Location: index.php');
	}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Comandas</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<!-- Font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../icones/fonts/css/all.css">
	<!-- JS -->
	<script src="js/funcoes.js"></script>
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="icon" href="../cardapio/img/logo.png" type="image/x-icon">
	<!--  -->
	<style>
    /* Estilo para ocultar o conteúdo */
    body {
      visibility: hidden;
    }
  	</style>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
	  // Exibe o conteúdo após o carregamento completo da página
	  document.body.style.visibility = 'visible';
	});
	</script>
</head>
<body>
	<!-- Modal erro -->
	<div class="modal fade" id="erro" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-warning">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	      </div>
	      <div class="modal-body">
	        Nenhum produto foi adicionado!
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal cancelar -->
	<div class="modal fade" id="cancelar" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	      </div>
	      <div class="modal-body">
	        Tem certeza que dejesa cancelar?<br>
	        Todos os itens adicionados serão perdidos.
	      </div>
	      <div class="modal-footer">
	      	<form method="post" class="mb-0">
      			<button type="submit" class="btn btn-danger" name="cancelar-modal">Cancelar</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	      	</form>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal sucesso -->
	<div class="modal fade" id="criar" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	      </div>
	      <div class="modal-body">
	        Comanda criada com sucesso!
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" onclick="window.location.href='index.php'">Fechar</a>
	      </div>
	    </div>
	  </div>
	</div>

	<header id="criarC-titulo">
		<h1 class="alert header mb-1" id="criarC-titulo">Criar uma comanda</h1>
	</header>
	<main style="width: 99.4%;">
		<div class="produtos">
			<form name="butao" method="post" class="row">
				<h3 class="alert" id="itens">Itens
					<button type="submit" class="btn btn-danger" name="classicos">
						Classicos
					</button>
					<button type="submit" class="btn btn-danger" name="especiais">
						Especiais
					</button>
					<button type="submit" class="btn btn-danger" name="bebidas">
						Bebidas
					</button>
				</h3>
			</form>
			<?php include_once('produtos.php') ?>
		</div>
		<div style="float: right;" id="comanda">
			<?php include_once('comanda.php') ?>
		</div>
		<div class="border shadow p-2" id="total">Total: <?php echo 'R$'.$total ?></div>
	<footer class="alert-danger" id="footer">
		<form name="form1" method="post">
			<input type="text" placeholder="Nome" name="nome" id="nomeC">
			<input type="text" name="total" value="<?php echo $total ?>" style="display: none;">
			<button type="submit" class="btn btn-danger ml-2" id="btn-footer" name="cancelar" style="float: right;" >Cancelar</button>
			<button type="submit" name="finalizar" id="btn-footer" class="btn btn-success" style="float: right;">Finalizar</button>
		</form>
	</footer>
	</main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

