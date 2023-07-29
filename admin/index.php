<?php  
	session_start();
	include_once('funcoes.php');
	include_once('../conexao.php');
	include_once('cabecalho.php');
	// Recebe a variável busca se existir
	$busca = isset($_GET['busca']) ? $_GET['busca'] : null;
	//verifica se a variavel está vazia, se estiver , faz a busca completa
	if (empty($busca)) {
		$sql = 'SELECT * FROM tab_produtos';
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
?>

	<h1 class="alert text-center" id="index-titulo">
		Administração
	</h1>
	<section class="container">
		<div class="row mb-5">
			<div class="col-md-12 text-center" id="voltar-index">
				<a href="../" class="btn ml-3" style="width: 200px;">
					<i class="fa-solid fa-right-from-bracket" ></i> Voltar
				</a>
			</div>
		</div>
		<div class="card-deck mb-3 text-center">
			<div class="card mb-4" id="caixas">
				<div class="card-header" id="caixa-titulo">
					<h4 class="my-0">
						Administrar produtos
					</h4>
				</div>
				<div class="card-body">
					<h1><i class="fa-solid fa-utensils mb-2" id="i-index"></i></h1>
					<a href="adm-produtos.php" class="btn btn-lg btn-block" id="btn-index">
						Administrar
					</a>
				</div>
			</div>		

			<div class="card mb-4" id="caixas">
				<div class="card-header" id="caixa-titulo">
					<h4 class="my-0">
						Controle de vendas
					</h4>
				</div>
				<div class="card-body">
					<h1><i class="fa-solid fa-dollar-sign mb-2" id="i-index"></i></h1>
					<a href="vendas.php" class="btn btn-lg btn-block" id="btn-index">
						Verificar
					</a>
				</div>
			</div>
		</div>
	</section>

		<?php 
			include_once('rodape.php');
		?>