<?php  
	session_start();
	include_once('funcoes.php');
	include_once('../conexao.php');
	include_once('cabecalho.php');
	echo '
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	';


	$tipo = 9;
	if (isset($_POST['submit'])) {
		echo '
			<script>
					$(document).ready(function(){
						 $("#confirma").modal();
					});
				</script>
		';
		if (!isset($_SESSION['existe'])) {
			$_SESSION['existe'] = true;
			$_SESSION['valor'] = $_POST['valor'];
			$_SESSION['tipo'] = $_POST['tipo'];

			$_SESSION['valor'] = str_replace(',', '.', $_SESSION['valor']);
		}
	 } 
	 
	if (isset($_POST['confirma'])) {
		 $sql ='UPDATE tab_produtos SET valor = :valor WHERE tipo = :tipo';
		  	try {
		  		$query = $bd->prepare($sql);
		  		$query->bindParam(':valor', $_SESSION['valor']);
		  		$query->bindParam(':tipo', $_SESSION['tipo']);
		  		$query->execute();
				// Chama o modal
				echo '
					<script>
							$(document).ready(function(){
								 $("#insere").modal();
							});
						</script>
				';
				session_destroy();

		  	} catch (Exception $e) {
		  		echo $e->getMessage();
		  	}
		  }
	if (isset($_POST['fechar'])) {
		session_destroy();
		header("Location: altera-valor.php");
	}

	
?>
	<style type="text/css">
		label{
			color: #f6f6f6;
		}
	</style>
	<!-- Modal confirma-->
	<div class="modal fade" id="confirma" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-warning">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Tem certeza que deseja continuar?<br>
	        <?php if ($_SESSION['tipo'] == 0) {
	        	echo 'O valor de todos os pasteis simples serão alterados para R$'.number_format($_SESSION['valor'], 2);
	        }if ($_SESSION['tipo'] == 1) {
	        	echo 'O valor de todos os pasteis especiais serão alterados para R$'.number_format($_SESSION['valor'], 2);
	        }?>	 
	      </div>
	      <div class="modal-footer">
	      	<form method="post">
				<button type="submit" class="btn btn-danger" name="confirma" id="confirma">Confirmar</button>
				<button type="submit" name="fechar"class="btn btn-secondary">Fechar</button>		        	
			</form>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="insere" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Valor alterado com sucesso!
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href='adm-produtos.php';">Fechar</a>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="container">
	<h1 class="alert text-center" id="produtos-titulo">
		Alterar valor geral
	</h1>

	<form name="fomr1" id="form-produtos" method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="col-md-6">
				<label for="valor" class="mb-0">Valor</label>
				<input type="text" name="valor" id="Valor" class="form-control mb-3" required>
			</div>
			<div class="col-md-6">
				<label style="font-size:20px">Tipo do produto</label><br>
				<label for="simples">Simples</label>
				<input type="radio" name="tipo" value="0" class="mr-2"required>
				<label for="especial">Especial</label>
				<input type="radio" name="tipo" value="1" class="mr-2">
			</div>
		</div>

		<div class="col-md-12 text-center">
				<button type="submit" name="submit" id="submit" class="btn btn-info mt-3">
					<i class="fa-solid fa-floppy-disk"></i> Salvar
				</button>
				<a href="adm-produtos.php" class="btn btn-secondary mt-3"><i class="fa-solid fa-angles-left"></i> Voltar</a>
			</div>
	</form>
</div>

<?php  
	include_once('rodape.php');
?>