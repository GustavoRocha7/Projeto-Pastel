<?php  
	include_once('../conexao.php');
	$sql = 'SELECT * FROM tab_produtos WHERE tipo = 0 ORDER BY produto NOT LIKE "%carne%"';
	try {
		$query = $bd->prepare($sql);
		$query->execute();
		$resultado = $query->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	$sql1 = 'SELECT * FROM tab_produtos WHERE tipo = 1';
	try {
		$query1 = $bd->prepare($sql1);
		$query1->execute();
		$resultado1 = $query1->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Carpadio</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">

	<!-- Fontawesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<meta http-equiv="refresh" content="9">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../css/style.css">

	<link rel="icon" href="img/logo.png" type="image/x-icon">

</head>
<body>
	<main>
	<!-- Pasteis Simples -->
	<div class="simples">
		 <h3 class="alert alert-warning text-center" id="titulo">Pasteis simples</h3>
	</div>
	<div class="mx-auto row" id="simples">
		<?php include_once('simples.php') ?>
	</div>


	<!-- Pasteis Especiais -->
	<div class="simples">
		 <h3 class="alert alert-warning text-center" id="titulo">Especiais</h3>
	</div>
	<div class=" mx-auto row" id="especiais">
		<?php include_once('especial.php') ?>
	</div>	

	</main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="js/funcoes.js"></script>
	<script>
		function autoScroll(scrollContainer) {
		  let scrollDirection = 1; // começa a rolar para baixo
		  let isPaused = false; // indica se o scroll está em pausa

		  function doAutoScroll() {
		    if (!isPaused) {
		      // calcula a próxima posição do scroll
		      let nextScrollTop = scrollContainer.scrollTop + (scrollDirection * 3);

		      // verifica se chegou ao fim do conteúdo
		      if (nextScrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight) {
		        isPaused = true; // pausa o scroll

		        setTimeout(function() {
		          scrollDirection = -1; // muda a direção do scroll para cima
		          isPaused = false; // retoma o scroll
		        }, 3000); // espera 3 segundos antes de mudar a direção do scroll

		      } else if (nextScrollTop <= 0) { // verifica se voltou ao início do conteúdo
		        isPaused = true; // pausa o scroll

		        setTimeout(function() {
		          scrollDirection = 1; // muda a direção do scroll para baixo
		          isPaused = false; // retoma o scroll
		        }, 3000); // espera 3 segundos antes de mudar a direção do scroll
		      }

		      // rola o conteúdo para a próxima posição
		      scrollContainer.scrollTop = nextScrollTop;
		    }
		  }

		  // define o tempo de espera antes do início do auto scroll
		  setTimeout(function() {
		    // define o intervalo de tempo para rolar o conteúdo automaticamente
		    setInterval(doAutoScroll, 50);
		  }, 3000); // espera 3 segundos antes do início do auto scroll
		}

		const scrollContainer1 = document.getElementById('simples');
		const scrollContainer2 = document.getElementById('especiais');

		autoScroll(scrollContainer1);
		autoScroll(scrollContainer2);

    </script>
</body>
</html>
