<?php 
	if ($query->rowCount() <= 0) {
		echo '<h3 class="alert alert-danger m-3 mt-4">Não foi encontrado nenhum registro!</h3>';
	}else{
		echo '
			<div class="table-responsive shadow mt-3" id="tabela">
				<table class="table table-bordered table-striped table-hover" >
				<tr style="background-color: #d3d3d3">
					<th class="text-center">Nome</th>
					<th class="text-center">Valor</th>
					<th class="text-center">Data</th>
					<th class="text-center">Status</th>
				</tr>
		';} ?>
		<?php foreach ($resultado as $res) { ?>
				<tr>
						
						<td class="text-left align-middle"><a href="../comanda/alterar-comanda.php?id=<?php echo $res['id'] ?>" style="color: black;"><?php echo $res['nome'] ?></a></td>
						<td class="text-center align-middle">R$<?php echo $res['valor'] ?></td>
						<td class="text-center align-middle"><?php echo date('d/m/Y',strtotime($res['data'])) ?></td>
						<td class="text-center align-middle"><?php echo $res['status'] == 1 ? '<b style="color: green">Aberta</b>' : '<b style="color: red">Fechada</b>' ?></td>
					
				</tr>
		<?php } ?>

			</table>
	</div>
				<?php if (isset($produtos1) && !empty($produtos1)) { 
				$tot = 0;
				foreach($resultado as $res){ 
		 		$tot += floatval($res['valor']); 
			}?>
				<div class="shadow total">
					<div><?php echo '<b>Total do Periodo:</b>  R$'.number_format($tot,2) ?></div>
				</div>
			<?php } ?>