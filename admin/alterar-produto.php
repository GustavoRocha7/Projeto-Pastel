<?php  
	session_start();
	include_once('funcoes.php');
	include_once('../conexao.php');
	include_once('cabecalho.php');

	

	$id_produto = isset($_GET['id']) ? $_GET['id'] : null;
	$sql = 'SELECT * FROM tab_produtos WHERE id = :id';
	try {
		$query = $bd->prepare($sql);
		$query->execute(array(':id' => $id_produto));
		$resultado = $query->fetch(PDO::FETCH_LAZY);
	} catch (Exception $e) {
		$e->getMessage();
	}

	if (isset($_POST['submit'])) {
		echo '
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		';

		$produto = $_POST['produto'];
		$valor = str_replace(',', '.', $_POST['valor']);
		$quant = $_POST['quant'];
		$disponivel = $_POST['disponivel'];
		 $sql ='UPDATE tab_produtos SET produto = ? ,valor = ? ,quant = ? ,disponivel = ? WHERE id = ?';
		  	try {
		  		$query = $bd->prepare($sql);
		  		$query->execute(array($produto,$valor,$quant,$disponivel,$id_produto));

				// Chama o modal
				echo '
					<script>
							$(document).ready(function(){
								 $("#insere").modal();
							});
						</script>
				';
		  	} catch (Exception $e) {
		  		echo $e->getMessage();
		  	}
		  }  

	$string = $resultado['disponivel'];
?>
	
	<style type="text/css">
		label{
			color: #f6f6f6;
		}
	</style>
	<!-- Modal -->
	<div class="modal fade" id="insere" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	      </div>
	      <div class="modal-body">
	        Produto alterado com sucesso!
	      </div>
	      <div class="modal-footer">
	        <a href="#" class="btn btn-secondary" onclick="window.location.href='adm-produtos.php'">Fechar</a>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="container">
		<h1 class="alert text-center" id="produtos-titulo">
			Alterar Produto
		</h1>

		<form name="form1" id="form-produtos" method="post" enctype="multipart/form-data" onsubmit="return Insere(this);">
			<div class="row">
				<div class="col-md-6">
					<label for="produto" class="mb-0">Produto</label>
					<input type="text" name="produto" id="produto" class="form-control mb-3" value="<?php echo $resultado['produto']; ?>" required autofocus>

				</div>
				<div class="col-md-6">
					<label for="valor" class="mb-0">Valor</label>
					<input type="text" name="valor" id="valor" class="form-control mb-3" value="<?php echo $resultado['valor']; ?>"required>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<label for="quant" class="mb-0">Quantidade</label>
					<input type="text" name="quant" id="quant" class="form-control mb-3" value="<?php echo $resultado['quant']; ?>"required>

				</div>
				<div class="col-md-6 mt-2">
					<label for="disponivel" class="mb-0">Disponibilidade</label><br>
					<select name="disponivel">
						<option value="<?php echo $resultado['disponivel']; $disp = $resultado['disponivel']?>"><?php echo $resultado['disponivel'] == 0 ? 'Esgotado' : 'Disponivel'?></option>
						<option value="<?php $disp == 0 ? $d = 1 : $d = 0; echo $d?>"><?php echo $d == 1 ? 'Disponivel' : 'Esgotado'?></option>
					</select>
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