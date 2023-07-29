<?php 
	class Produto{
		public $quant;
		public $nome;
		public $valor;
	}


   	$_SESSION['produtos'] = array();



	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$produto = new Produto();
		$produto->quant = $_POST['quantidade'];
   		$produto->nome = $_POST['nome'];
   		$produto->valor = 'R$'.number_format($_POST['valor']*$_POST['quantidade'],2);

   		array_push($_SESSION['produtos'], $produto);
	}


	echo '
	<div class="table-responsive">
		<table class="table table-bordered table-striped" style="float: right;">
			<tr>
				<td class="text-center">Quantidade</td>
				<td class="text-center">Produto</td>
				<td class="text-center">Valor</td>
			</tr>

		'; 
?>
<?php foreach ($_SESSION['produtos'] as $pro) { ?>
    <tr>
        <td class="text-left align-middle"><?php echo $pro->quant ?></td>
        <td class="text-left align-middle"><?php echo $pro->nome ?></td>
        <td class="text-center align-middle"><?php echo $pro->valor ?></td>
    </tr>
<?php } ?>
		</table>
	</div>