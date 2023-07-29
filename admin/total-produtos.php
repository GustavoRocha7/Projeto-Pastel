<?php if (isset($produtos1) && !empty($produtos1)) {				 
			echo '
				<div class="table-responsive shadow-lg mt-3" id="tabela2">
				 	<table class="table table-bordered table-striped table-hover" >
					<tr  style="background-color: #d3d3d3">
						<th class="text-center">Produto</th>
						<th class="text-center">Total vendido</th>
						<th class="text-center">Total arrecadado</th>
					</tr>
			';
	 ?><?php 
	 function ordenaQtde($a, $b) {
	    if ($a['qtde'] == $b['qtde']) {
	        return 0;
	    }
	    return ($a['qtde'] > $b['qtde']) ? -1 : 1;
	}

	// ordenar o array usando a função de classificação
	usort($produtos, 'ordenaQtde');
	 	foreach ($produtos as $pro) { ?>
	 	<tr>
	 		<td class="text-center align-middle"><?php echo $pro['produto'] ?></td>
	 		<td class="text-center align-middle"><?php echo $pro['qtde'] ?></td>
	 		<td class="text-center align-middle"><?php echo 'R$'.number_format($pro['subtotal'],2) ?></td>
	 	</tr>	
	 <?php } } ?>
	 	</table>
	 </div>