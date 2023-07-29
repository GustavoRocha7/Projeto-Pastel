<?php
	include_once('../conexao.php');

	echo '
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>		
	';



	$id_comanda = isset($_GET['id']) ? $_GET['id'] :null;

	$sqlp = 'SELECT * FROM tab_produtos WHERE tipo = 0';
	try {
		$queryp = $bd->prepare($sqlp);
		$queryp->execute();
		$resultado = $queryp->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$e->getMessage();
	}

	$sqle = 'SELECT * FROM tab_produtos WHERE tipo = 1';
	try {
		$querye = $bd->prepare($sqle);
		$querye->execute();
		$especiais = $querye->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$e->getMessage();
	}

	$sqlb = 'SELECT * FROM tab_produtos WHERE tipo = 2';
	try {
		$queryb = $bd->prepare($sqlb);
		$queryb->execute();
		$bebidas = $queryb->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$e->getMessage();
	}


	$sql1 = 'SELECT i.id AS id_itens, p.id, i.qtde, i.subtotal, p.produto, p.valor
			 FROM tab_itens i
			 INNER JOIN tab_produtos p ON i.id_produto = p.id
			 WHERE i.id_comanda = :id_comanda';
	try {
		$query1 = $bd->prepare($sql1);
		$query1->bindParam(':id_comanda',$id_comanda);
		$query1->execute();
		$procom = $query1->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	$sql2 = 'SELECT * FROM tab_comanda WHERE id = :id';
	try {
		$query2 = $bd->prepare($sql2);
		$query2->bindParam(':id',$id_comanda);
		$query2->execute();
		$comanda = $query2->fetch(PDO::FETCH_LAZY);

	} catch (Exception $e) {
		
	}


    class Produto{
        public $id;
        public $quant;
        public $nome;
        public $valor;
    }

    session_start();

    if (isset($_POST['finalizar'])) {
    	if (empty($_SESSION['produtos'])) {
    		echo '
			<script>
				$(document).ready(function(){
					 $("#erro").modal();
				});
			</script>';
    	}else{
			$total = $_POST['total'];
			$data = date('Y/m/d');
			$nome = $comanda->nome;
			if (!empty($_POST['nome'])) {
				$nome = $_POST['nome'];
			}

			$sql = 'UPDATE tab_comanda SET nome = ?, valor = ?, data = ?, status = 1, pronta = 0 WHERE id = ?';
			try {
				$query = $bd->prepare($sql);
				$query->execute(array($nome,$total,$data,$id_comanda));

				$sql2 = 'DELETE FROM tab_itens WHERE id_comanda = :id';
				try {
					$query2 = $bd->prepare($sql2);
					$query2->bindParam(':id',$id_comanda);
					$query2->execute();
				} catch (Exception $e) {
					echo $e->getMessage();
				}

				foreach ($_SESSION['produtos'] as $pro) {
					$sql2 = 'INSERT INTO tab_itens(id_comanda, id_produto, qtde, subtotal) 
							 VALUES (:id_comanda, :id_produto, :qtde, :subtotal)';
					try {
						$query2 = $bd->prepare($sql2);
						$query2->bindParam(':id_comanda',$id_comanda);
						$query2->bindParam(':id_produto',$pro->id);
						$query2->bindParam(':qtde',$pro->quant);
						$query2->bindParam(':subtotal',$pro->valor);
						$query2->execute();

					} catch (Exception $e) {
						$e->getMessage();
					}

					$sql3 = 'UPDATE tab_produtos SET quant = quant - ? WHERE id = ?';
					try {
						$query3 = $bd->prepare($sql3);
						$query3->execute(array($pro->quant, $pro->id));


					} catch (Exception $e) {
						$e->getMessage();
					}
				}
					echo '
						<script>
							$(document).ready(function(){
								 $("#alterar").modal();
							});
						</script>
						<script type="text/javascript">
							localStorage.clear();
						</script>';
				session_destroy();
				// header('Location: index.php');

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
	<!-- Impede a tela de piscar -->
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
	        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
	          <span aria-hidden="true">&times;</span>
	        </button>
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
	        Todas as alterações serão perdidas.
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

	<!-- Modal -->
	<div class="modal fade" id="alterar" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Comanda alterada com sucesso!
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" onclick="window.location.href='index.php'">Fechar</a>
	      </div>
	    </div>
	  </div>
	</div>

	<header id="criarC-titulo">
		<h1 class="alert">Alterar comanda</h1>
	</header>
	<main  style="width: 99.4%;">
		<div class="produtos">
			<form name="butao" method="post" class="row">
				<h3 class="alert alert-danger" id="itens">Itens
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
			<?php include_once('alterar/produtos.php') ?>
		</div>
		<div id="comanda" style="float: right;">
			<?php include_once('alterar/comanda.php') ?>
		</div>
		<div class="border shadow p-2" id="total">Total: <?php echo 'R$'.$total ?></div>
	</main>
	<footer class="alert-danger" id="footer">
		<form name="form1" method="post">
				<input type="text" placeholder="Nome" name="nome" id="nomeC" value="<?php echo $comanda['nome'] ?>">
				<input type="text" name="total" value="<?php echo $total ?>" style="display: none;">
				<button type="submit" class="btn btn-danger ml-2" id="btn-footer" name="cancelar" style="float: right;" >Cancelar</button>
				<button type="submit" name="finalizar" id="btn-footer" class="btn btn-success" style="float: right;">Alterar</button>
		</form>
	</footer>





	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>

