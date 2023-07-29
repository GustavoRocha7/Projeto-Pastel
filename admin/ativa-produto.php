<?php  
	session_start();
	include_once('../conexao.php');

	$id = isset($_GET['id']) ? $_GET['id'] : null;
	$sql = 'UPDATE tab_produtos SET disponivel = 1 WHERE id = ?';
	try {
		$query = $bd->prepare($sql);
		$query->bindParam(1, $id, PDO::PARAM_INT);
		$query->execute();

	

		header('Location: adm-produtos.php');
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>