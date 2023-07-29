<?php  
	include_once('conexao.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, viewport-fit=cover">
	<title>Acesso restrito</title>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<!-- FontAwesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<link rel="icon" href="cardapio/img/logo.png" type="image/x-icon">

</head>
<body id="body-index">
	<main class="container mt-3" id="main-index">
		<div class="col-md-5 mx-auto mt-5" id="menu">
			<h1 class="alert text-center" id="h1-index">
				Pastelaria
			</h1>
			<hr>
			<button class="btn form-control mb-3 shadow" id="btn-index" onclick="window.location.href='admin/'">Administrar</button>
			<button class="btn form-control mb-3 shadow" id="btn-index" onclick="window.location.href='cardapio/'">Cardapio</button>
			<button class="btn form-control shadow" id="btn-index" onclick="window.location.href='comanda/'">Comanda</button>

		</div>

	</main>
</body>
</html>



<?php  
	include_once('admin/rodape.php');
?>