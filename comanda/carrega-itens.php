	<?php 
	$sql1 = 'SELECT i.id AS id_itens, p.id, i.qtde, i.subtotal, p.produto, p.valor
	 FROM tab_itens i
	 INNER JOIN tab_produtos p ON i.id_produto = p.id
	 WHERE i.id_comanda = :id_comanda';
	try {
		$query1 = $bd->prepare($sql1);
		$query1->bindParam(':id_comanda',$res['id']);
		$query1->execute();
		$procom = $query1->fetchALL(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	foreach ($procom as $pro) { ?>
		<p class="text-left m-0"><?php echo $pro['produto'].' x'.$pro['qtde'] ?></p>
	<?php } ?>
