<?php foreach ($resultado1 as $res1) { ?>
	<div class="linha" style="justify-content: center;">
		<div id="produto"><?php echo $res1['produto'] ?>
			<?php if ($res1['disponivel'] == 0 || $res1['quant'] == 0) { ?>
			<span class="esgotado">Esgotado</span> <?php } ?>
		</div>
		<div id="preco"><?php echo 'R$'.$res1['valor'] ?></div>
	</div>
<?php } ?>