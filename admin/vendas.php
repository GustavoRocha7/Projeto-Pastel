<?php  
	session_start();
	include_once('funcoes.php');
	include_once('../conexao.php');
	include_once('cabecalho.php');
	// Recebe a variável busca se existir
	if (isset($_POST['pesquisar'])) {
		$dataI = date('Y/m/d',strtotime($_POST['dataI']));
		$dataF = date('Y/m/d',strtotime($_POST['dataF']));
		$emp = $dataI;
		if ($dataF == '1970/01/01') {
			$dataF = date('Y/m/d');
		}
	}
		//verifica se a variavel está vazia, se estiver , faz a busca completa
	if (!isset($dataI) || $emp == '1970/01/01') {
		$sql = 'SELECT * FROM tab_comanda';
		try {
			$query = $bd->prepare($sql);
			$query->execute();
			$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo $e->getMEssage();
		}
	}else{
		$sql = 'SELECT * FROM tab_comanda WHERE data BETWEEN :dataI AND :dataF';
		try {
			$query = $bd->prepare($sql);
			$query->bindvalue(':dataI',$dataI);
			$query->bindvalue(':dataF',$dataF);
			$query->execute();
			$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			
		}
		$produtos = array();

		$sql2 = 'SELECT i.id AS id_itens, i.id_comanda ,p.id, p.valor ,i.qtde, i.subtotal, p.produto, p.valor, c.data, c.id AS id_comanda 
			 FROM tab_itens i
			 INNER JOIN tab_produtos p ON i.id_produto = p.id
	         INNER JOIN tab_comanda c ON c.id = i.id_comanda
		 	 WHERE data BETWEEN :dataI AND :dataF';
			try {
				$query2 = $bd->prepare($sql2);
				$query2->bindParam(':dataI',$dataI);
				$query2->bindParam(':dataF',$dataF);
				$query2->execute();
				$produtos1 = $query2->fetchALL(PDO::FETCH_ASSOC);

				foreach ($produtos1 as $produto) {
				    $produto_adicionado = false;
				    foreach ($produtos as &$prod) {
				        if ($produto['id'] == $prod['id']) {
				            $prod['qtde'] += $produto['qtde'];
				            $prod['subtotal'] += $produto['subtotal'];
				            $produto_adicionado = true;
				            break;
				        }
				    }
				    if (!$produto_adicionado) {
				        $produtos[] = $produto;
				    }
				}

			} catch (Exception $e) {
				echo $e->getMessage();
			}
		
	}
?>

	<h1 class="alert text-center" id="vendas-titulo">
		Controle de vendas
	</h1>
		<div class="col md-6 text-center mb-5" id="voltar-index">
			<a href="index.php" class="btn" style="width: 150px;">
				<i class="fa-solid fa-right-from-bracket"></i> Voltar
			</a>
		</div>

	<div class="row" style="justify-content: center;">
		<form name="form1" id="form1" method="post" class="mb-2">
				<label for="dataI" id="lblDtI">Data inicio</label>
				<input type="date" name="dataI" id="dataI"<?php if (isset($produtos)) {?>	value="<?php echo date('Y-m-d',strtotime($dataI)) ?>"<?php } ?>>
				<label for="dataF" id="lblDtF">Data Fim</label>
				<input type="date" name="dataF" id="dataF"<?php if (isset($produtos)) {?>	value="<?php echo date('Y-m-d',strtotime($dataF)) ?>"<?php } ?>>
				<button type="submit" name="pesquisar" id="pesquisar" class="btn ml-2">
					<i class="fa-solid fa-magnifying-glass mr-1"></i>Pesquisar
				</button>
			</form>
		</div>
		<div class="row m-1 pb-2" id="tabs">
			<div>
				<?php include_once('comandas.php') ?>
			</div>
			<div>
				<?php include_once('total-produtos.php') ?>
			</div>
		</div>


		<?php 
			include_once('rodape.php');
		?>