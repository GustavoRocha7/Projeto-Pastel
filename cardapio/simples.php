<?php foreach ($resultado as $res) { ?>
	<div class="linha">
		<div id="produto"><?php echo $res['produto']?> 
			<?php if ($res['disponivel'] == 0 || $res['quant'] == 0) { ?>
			<span class="esgotado">Esgotado</span> <?php } ?>
		</div>
		<div id="preco"><?php echo 'R$'.$res['valor'] ?></div>
	</div>
<?php } ?>
</div>	