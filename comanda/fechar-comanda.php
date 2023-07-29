<?php 
	include_once('../conexao.php');

	echo '<script type="text/javascript">
			localStorage.clear();
	</script>';

	$id = isset($_GET['id']) ? $_GET['id'] : null;

	$sql = 'UPDATE tab_comanda SET status = 0 WHERE id = ?';
	try {
		$query = $bd->prepare($sql);
		$query->bindParam(1, $id, PDO::PARAM_INT);
		$query->execute();

		header('Location: index.php');
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>