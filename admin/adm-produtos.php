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

	// Recebe a variável busca se existir
	$busca = isset($_GET['busca']) ? $_GET['busca'] : null;
	//verifica se a variavel está vazia, se estiver , faz a busca completa
	if (empty($busca)) {
		$sql = 'SELECT * FROM tab_produtos ORDER BY tipo ASC';
		try {
			$query = $bd->prepare($sql);
			$query->execute();
			$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo $e->getMEssage();
		}
	}else{
		$sql = 'SELECT * FROM tab_produtos WHERE produto LIKE :produto';
		try {
			$query = $bd->prepare($sql);
			$query->bindvalue(':produto', '%'.$busca.'%');
			$query->execute();
			$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			
		}
	}
	$nomeP = '';
	$id_modal = 0;
	if (isset($_POST['exclui'])) {
		$id_modal = $_POST['id-modal'];
		$sql = 'SELECT produto FROM tab_produtos WHERE id = :id';
		try {
			$query = $bd->prepare($sql);
			$query->bindParam(':id', $id_modal);
			$query->execute();
			$nomeP = $query->fetchColumn();
		} catch (Exception $e) {
			
		}
		echo '<script>
				$(document).ready(function(){
					 $("#exclui").modal();
					});
			  </script>';
	}
?>

	<!-- Modal exclui -->
	<div class="modal fade" id="exclui" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	      </div>
	      <div class="modal-body">
	        Deseja excluir o seguinte produto : <?php echo $nomeP ?>?
	      </div>
	      <div class="modal-footer">
	        <a href="exclui-produto.php?id=<?php echo $id_modal ?>"><button type="button" class="btn btn-danger">Excluir</button></a>
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<h1 class="alert text-center" id="produtos-titulo">
		Administração
	</h1>
	<section class="container" id="section">
		<div class="row">
			<div class="col-md-12 text-center">
				<a href="insere-produto.php" class="btn btn-success">
					<i class="fa-solid fa-floppy-disk"></i> Inserir produto
				</a>
				<a href="index.php" class="btn ml-3" id="voltar-produtos">
					<i class="fa-solid fa-right-from-bracket"></i> Voltar
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 row" id="div-form" style="justify-content: center">
				<form name="form1" id="formP" method="get" class="mt-3">
					<label for="busca" id="lblBusca">Pesquisar</label>
					<div class="row">
						<div class="row mr-4" id="caixa-pesquisa">
							<input type="text" name="busca" id="busca" class="form-control mb-2">
							<button type="submit" name="pesquisar" id="pesquisarP" class="btn ml-2 mb-2">
								<i class="fa-solid fa-magnifying-glass mr-1"></i>Pesquisar
							</button>
						</div>
						<div class="row" id="caixa-altera">
							<a href="altera-valor.php" class="btn mb-2" id="altera-geral">
							Alterar valor geral
							</a>
							<a href="altera-quant.php" class="btn ml-2 mb-2" id="altera-geral">
								Alterar quantidade geral
							</a>
						</div>
					</div>
				</form>
			</div>
		</div>

		<article class="container row p-3" id="produtos-article">
				<?php 
					if ($query->rowCount() <= 0) {
						echo '<h3 class="alert alert-danger mt-3">Não foi encontrado nenhum registro!</h3>';
					}else{
						echo '
							<div class="table-responsive" id="tabelaPro">
								<table class="table table-bordered table-striped table-hover" >
								<tr style="background-color: #d3d3d3">
									<th class="text-center">ID</th>
									<th class="text-left">Produto</th>
									<th class="text-center">Valor</th>
									<th class="text-center">Quantidade</th>
									<th class="text-center">Alterar</th>
									<th class="text-center">Excluir</th>
									<th class="text-center">Disponivel</th>
								</tr>
						';
							foreach ($resultado as $res) {
							echo '<tr>
									<td class="text-center align-middle">'.$res['id'].'</td>
									<td class="text-left align-middle">'.$res['produto'].'</td>
									<td class="text-center align-middle">R$'.$res['valor'].'</td>
									<td class="text-center align-middle">'.$res['quant'].'</td>
									<td class="text-center align-middle"><a href="alterar-produto.php?id='.$res['id'].'"><i class="fa-solid fa-pen-to-square"></i></a></td>
									<form method="post">
										<input type="text" name="id-modal" value="'.$res['id'].'" style="display: none">
										<td class="text-center align-middle"><button type="submit" name="exclui" class="text-danger" id="excluir" ><i class="fa-solid fa-trash"></i></button></td>
									</form>
									';
								

									if ($res['disponivel'] == 1) {
										echo '
											<td class="text-center align-middle"><a href="desativa-produto.php?id='.$res['id'].'" onclick="return desativaPessoa('.$res['id'].')" class="text-success"><i class="fa-solid fa-check"></i></a></td>
										';
									}else{
										echo '
											<td class="text-center align-middle"><a href="ativa-produto.php?id='.$res['id'].'" onclick="return ativaPessoa('.$res['id'].')" class="text-danger"><i class="fa-solid fa-xmark"></i></a></td>
										';
									}
						}
						echo '
							
							</table>
						</div>
						';
					}?>
				</article>
		</section>
			<script>
			  // Obtém o elemento da div que você deseja preservar o scroll
			  var scrollDiv = document.getElementById('tabelaPro');

			  // Armazena a posição do scroll no `localStorage` quando a página for recarregada/sair
			  window.addEventListener('beforeunload', function() {
			    localStorage.setItem('scrollPosition', scrollDiv.scrollTop);
			  });

			  // Restaura a posição do scroll a partir do `localStorage` quando a página for carregada
			  window.addEventListener('load', function() {
			    var scrollPosition = localStorage.getItem('scrollPosition');
			    if (scrollPosition !== null) {
			      scrollDiv.scrollTop = scrollPosition;
			    }
			  });
		</script>
		<?php 
			include_once('rodape.php');
		?>
		