<?php  
	include_once('../conexao.php');

	echo '
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>		
	';

	$sql = 'SELECT * FROM tab_comanda WHERE status = 1 ORDER BY pronta = 0';
	try {
		$query = $bd->prepare($sql);
		$query->execute();
		$resultado = $query->fetchAll(PDO::FETCH_ASSOC);

	} catch (Exception $e) {
		echo $e->getMessage();
	}
	$id_modal = 0;
	
	if (isset($_POST['fecha-comanda'])) {
		$id_modal = $_POST['id-comanda'];
		echo '<script>
				$(document).ready(function(){
					 $("#fecha").modal();
					});
			  </script>';
		$refresh = false;
	}else{
		$refresh = true;
	}
	if (isset($_POST['pronta'])) {
		$id_modal= $_POST['id-comanda'];

		$sql = 'UPDATE tab_comanda SET pronta = 1 WHERE id = :id';
		try {
			$query = $bd->prepare($sql);
			$query->bindParam(':id',$id_modal);
			$query->execute();

			header('Location: index.php');
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	if (isset($_POST['nPronta'])) {
		$id_modal= $_POST['id-comanda'];

		$sql = 'UPDATE tab_comanda SET pronta = 0 WHERE id = :id';
		try {
			$query = $bd->prepare($sql);
			$query->bindParam(':id',$id_modal);
			$query->execute();

			header('Location: index.php');
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sistema de Comandas</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" type="text/css" href="../icones/fonts/css/all.css">
	<link rel="icon" href="../cardapio/img/logo.png" type="image/x-icon">
	<script src="js/funcoes.js"></script>
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
	<?php if ($refresh) { ?>
		<meta http-equiv="refresh" content="3">
	<?php } ?>
</head>
<body class="m-3" id="body-index">

	<!-- Modal fecha -->
	<div class="modal fade" id="fecha" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true" data-backdrop="static">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-danger">
	        <h5 class="modal-title" id="TituloModalCentralizado">Aviso</h5>
	      </div>
	      <div class="modal-body">
	        Deseja fechar a comanda?
	      </div>
	      <div class="modal-footer">
	        <a href="fechar-comanda.php?id=<?php echo $id_modal ?>"><button type="button" class="btn btn-danger">Fechar comanda</button></a>
	        <a href="index.php"><button type="button" class="btn btn-secondary">Cancelar</button></a>
	      </div>
	    </div>
	  </div>
	</div>

	<header>
		<h1 class="alert text-center" id="index-titulo">Sistema de Comandas</h1>
		<div class="row">
			<div class="col-md-12 text-center">
				<a href="admin.php" class="btn btn-success">
					<i class="fa-solid fa-pen-to-square"></i> Criar comanda
				</a>
				<a href="../" class="btn ml-3" id="voltar-index" onclick="localStorage.clear();">
					<i class="fa-solid fa-right-from-bracket"></i> Voltar
				</a>
			</div>
		</div>
	</header>
	<section>
		<div class="mx-auto row m-5 pt-3 pb-3 pl-0 pr-0" id="grid">
			<?php foreach ($resultado as $res) {?>
			<div class="comandas" id="comandas-index" <?php if ($res['pronta'] == 1) {
				echo 'style="background-color: green;"';
			} ?>>
				<h4 class="alert" id="comanda-titulo"><?php echo $res['nome'] ?></h4>
				<div class="m-3 p-1 rounded" id="grid-itens">
					<?php include('carrega-itens.php')?>
				</div>
				<div class="rounded m-3" id="totC">Total: R$<?php echo $res['valor'] ?></div>

				<form method="post">
					<a href="alterar-comanda.php?id=<?php echo $res['id'] ?>" class="btn" id="altera" onclick="localStorage.clear();">Alterar</a>
					<input type="text" name="id-comanda" value="<?php echo $res['id'] ?>" style="display: none;">
					<button type="submit" name="fecha-comanda" class="btn btn-danger" id="butao">Fechar</button>
					<?php if ($res['pronta'] == 1) { ?>
						<button type="submit" name="nPronta" class="btn btn-danger" id="pronta"><i class="fa-solid fa-xmark"></i></button>
					<?php }else{ ?>
						<button type="submit" name="pronta" class="btn btn-success" id="pronta"><i class="fa-solid fa-check"></i></button>
					<?php } ?>
				</form>
			</div>
			<?php } ?>
			<?php if ($query->rowCount() <= 0) { ?>
				<div class="alert alert-danger m-3 text-center" style="width: 70%; font-size: 50px;border-radius: 20px;">Não há comandas abertas</div>
			<?php } ?>
		</div>
	</section>
		<script type="text/javascript">
		// Verifique se há uma posição de rolagem salva no local storage
		if (localStorage.getItem("scrollPosition")) {
		  // Obtenha a posição de rolagem salva
		  var scrollPosition = localStorage.getItem("scrollPosition");

		  // Defina a posição de rolagem da div 'scrollP' para a posição salva
		  document.getElementById("body-index").scrollTop = scrollPosition;
		}

		// Adicione um evento de envio de formulário
		document.addEventListener("submit", function() {
		  // Salve a posição de rolagem atual no local storage
		  localStorage.setItem("scrollPosition", document.getElementById("body-index").scrollTop);
		});
	</script>
</body>
</html>