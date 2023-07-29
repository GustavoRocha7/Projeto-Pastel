<div class="scrollP" id="scrollP">
<?php 
	    
    if (!isset($_SESSION['produtos'])){
        $_SESSION['produtos'] = array();
        foreach ($procom as $pro) {
            $produto = new Produto();
            $produto->id = $pro['id'];
            $produto->quant = $pro['qtde'];
            $produto->nome = $pro['produto'];
            $produto->valor = $pro['subtotal'];
            
            array_push($_SESSION['produtos'], $produto);
        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar'])) {
        if ($_POST['quantidade'] == 0) {
            if (isset($_SESSION['produtos'])) {
                foreach ($_SESSION['produtos'] as $key => $pro) {
                    if ($pro->id == $_POST['id']) {
                        unset($_SESSION['produtos'][$key]);
                        break;
                    }
                }
            }
        } else {
            $produto = new Produto();
            $produto->id = $_POST['id'];
            $produto->quant = $_POST['quantidade'];
            $produto->nome = $_POST['nome'];
            $produto->valor = number_format($_POST['valor']*$_POST['quantidade'],2);

            $produtos = &$_SESSION['produtos'];

            $produtoExistente = false;
            foreach ($produtos as &$pro) { 
                if ($pro->id == $produto->id) {
                    $pro->quant = $produto->quant; 
                    $pro->valor = number_format($pro->quant * $_POST['valor'], 2);
                    $produtoExistente = true;
                    break;
                }
            }
            unset($pro);

            if (!$produtoExistente) {
                array_push($produtos, $produto);
            }
        }
    }

	if (!isset($classicos) && !isset($_SESSION['classicos']) && !isset($_SESSION['especiais']) && !isset($_SESSION['bebidas'])) {
		$classicos = true;
	}
	if (isset($_POST['classicos'])) {
		if (isset($_SESSION['especiais'])) {
			unset($_SESSION['especiais']);
		}
		if (isset($_SESSION['bebidas'])) {
			unset($_SESSION['bebidas']);
		}
		if (isset($classicos)) {
			unset($classicos);
		}
		$_SESSION['classicos'] = true;
	}
	if (isset($_POST['especiais'])) {
		if (isset($_SESSION['classicos'])) {
			unset($_SESSION['classicos']);
		}
		if (isset($_SESSION['bebidas'])) {
			unset($_SESSION['bebidas']);
		}
		if (isset($classicos)) {
			unset($classicos);
		}
		$_SESSION['especiais'] = true;
	}
	if (isset($_POST['bebidas'])) {
		if (isset($_SESSION['classicos'])) {
			unset($_SESSION['classicos']);
		}
		if (isset($_SESSION['especiais'])) {
			unset($_SESSION['especiais']);
		}
		if (isset($classicos)) {
			unset($classicos);
		}
		$_SESSION['bebidas'] = true;
	}

?>
<?php 
	if (isset($_SESSION['classicos']) || isset($classicos)) {
	foreach ($resultado as $res) { 
	$quant = 0;
	$tot = $res['quant'];
	if (isset($_SESSION['produtos'])) {
		foreach ($_SESSION['produtos'] as $pro) {
			if ($pro->id == $res['id']) {
				$quant = $pro->quant;
				$res['quant'] -= $pro->quant;
				break;
			}		
		}
	}
?>
	<div class="row border shadow ml-2 mr-2" id="linha">

		<div style="display: none;"><?php echo $res['id'] ?></div>

		<div class="alert" id="produto"><?php echo $res['produto'] ?></div>

		<div class="alert" id="quant1" <?php if ($res['quant'] == 0) { ?>
			style="background-color: red;
				   color: black;
				   font-weight: 500;"
		<?php } ?>><?php if ($res['quant'] == 0) {
			echo "ESGOTADO";
		}else{
			echo 'Qtde: '.$res['quant']; 
		}?>
		</div>

		<div class="alert" id="valor1"><?php echo 'R$'.$res['valor'] ?></div>

		<form class="mr-2 ml-2 mt-1 pt-2" method="post" id="form-itens">

			<input type="text" name="id" value="<?php echo $res['id'] ?>" style="display: none;">

			<input type="text" name="nome" value="<?php echo $res['produto'] ?>" style="display: none;">

			<input type="text" name="valor" value="<?php echo $res['valor'] ?>" style="display: none;">

			<button type="submit" name="adicionar"class="btn diminuir" onclick="diminui(<?php echo $quant ?>, <?php echo $res['id'] ?>)"><i class="fa-solid fa-minus"></i></button>

			<label class="text-center" style="width: 20px;"><?php echo $quant ?></label>
			<input type="text"  class="quant" name="quantidade" id="<?php echo $res['id'] ?>" value="<?php echo $quant; ?>" style="display: none;">
			
			<button type="submit" name="adicionar"class="btn aumentar" onclick="aumenta(<?php echo $quant ?>,<?php echo $tot ?>, <?php echo $res['id'] ?>)">
				<i class="fa-solid fa-plus"></i>
			</button>

			<button type="submit" name="adicionar" class="btn excluir ml-3"onclick="exclui(<?php echo $quant ?>, <?php echo $res['id'] ?>)"><i class="fa-solid fa-trash"></i></button>

		</form>

	</div><br>
<?php } } ?>

<?php 
	if (isset($_SESSION['especiais'])) {

	foreach ($especiais as $res) { 
	$quant = 0;
	$tot = $res['quant'];
	if (isset($_SESSION['produtos'])) {
		foreach ($_SESSION['produtos'] as $pro) {
			if ($pro->id == $res['id']) {
				$quant = $pro->quant;
				$res['quant'] -= $pro->quant;
				break;
			}		
		}
	}
?>
	<div class="row border shadow ml-2 mr-2" id="linha">

		<div style="display: none;"><?php echo $res['id'] ?></div>

		<div class="alert alert-warning" id="produto"><?php echo $res['produto'] ?></div>

		<div class="alert alert-warning" id="quant1" <?php if ($res['quant'] == 0) { ?>
			style="background-color: red;
				   color: black;
				   font-weight: 500;"
		<?php } ?>><?php if ($res['quant'] == 0) {
			echo "ESGOTADO";
		}else{
			echo 'Qtde: '.$res['quant']; 
		}?>
		</div>

		<div class="alert alert-warning" id="valor1"><?php echo 'R$'.$res['valor'] ?></div>

		<form class="mr-2 ml-2 mt-1 pt-2" method="post" id="form-itens">
			<input type="text" name="id" value="<?php echo $res['id'] ?>" style="display: none;">

			<input type="text" name="nome" value="<?php echo $res['produto'] ?>" style="display: none;">

			<input type="text" name="valor" value="<?php echo $res['valor'] ?>" style="display: none;">

			<button type="submit" name="adicionar"class="btn diminuir" onclick="diminui(<?php echo $quant ?>, <?php echo $res['id'] ?>)"><i class="fa-solid fa-minus"></i></button>

			<label class="text-center" style="width: 20px;"><?php echo $quant ?></label>
			<input type="text"  class="quant" name="quantidade" id="<?php echo $res['id'] ?>" value="<?php echo $quant; ?>" style="display: none;">
			
			<button type="submit" name="adicionar"class="btn aumentar" onclick="aumenta(<?php echo $quant ?>,<?php echo $tot ?>, <?php echo $res['id'] ?>)">
				<i class="fa-solid fa-plus"></i>
			</button>

			<button type="submit" name="adicionar" class="btn excluir ml-3"onclick="exclui(<?php echo $quant ?>, <?php echo $res['id'] ?>)"><i class="fa-solid fa-trash"></i></button>

		</form>

	</div><br>
<?php } } ?>

<?php 
	if (isset($_SESSION['bebidas'])) {

	foreach ($bebidas as $res) { 
	$quant = 0;
	$tot = $res['quant'];
	if (isset($_SESSION['produtos'])) {
		foreach ($_SESSION['produtos'] as $pro) {
			if ($pro->id == $res['id']) {
				$quant = $pro->quant;
				$res['quant'] -= $pro->quant;
				break;
			}		
		}
	}
?>
	<div class="row border shadow ml-2 mr-2" id="linha">

		<div style="display: none;"><?php echo $res['id'] ?></div>

		<div class="alert alert-warning" id="produto"><?php echo $res['produto'] ?></div>

		<div class="alert alert-warning" id="quant1" <?php if ($res['quant'] == 0) { ?>
			style="background-color: red;
				   color: black;
				   font-weight: 500;"
		<?php } ?>><?php if ($res['quant'] == 0) {
			echo "ESGOTADO";
		}else{
			echo 'Qtde: '.$res['quant']; 
		}?>
		</div>

		<div class="alert alert-warning" id="valor1"><?php echo 'R$'.$res['valor'] ?></div>

		<form class="mr-2 ml-2 mt-1 pt-2" method="post" id="form-itens">
			<input type="text" name="id" value="<?php echo $res['id'] ?>" style="display: none;">

			<input type="text" name="nome" value="<?php echo $res['produto'] ?>" style="display: none;">

			<input type="text" name="valor" value="<?php echo $res['valor'] ?>" style="display: none;">

			<button type="submit" name="adicionar"class="btn diminuir" onclick="diminui(<?php echo $quant ?>, <?php echo $res['id'] ?>)"><i class="fa-solid fa-minus"></i></button>

			<label class="text-center" style="width: 20px;"><?php echo $quant ?></label>
			<input type="text"  class="quant" name="quantidade" id="<?php echo $res['id'] ?>" value="<?php echo $quant; ?>" style="display: none;">
			
			<button type="submit" name="adicionar"class="btn aumentar" onclick="aumenta(<?php echo $quant ?>,<?php echo $tot ?>, <?php echo $res['id'] ?>)">
				<i class="fa-solid fa-plus"></i>
			</button>

			<button type="submit" name="adicionar" class="btn excluir ml-3"onclick="exclui(<?php echo $quant ?>, <?php echo $res['id'] ?>)"><i class="fa-solid fa-trash"></i></button>

		</form>

	</div><br>
<?php } } ?>

	<script type="text/javascript">
		// Verifique se há uma posição de rolagem salva no local storage
		if (localStorage.getItem("scrollPosition")) {
		  // Obtenha a posição de rolagem salva
		  var scrollPosition = localStorage.getItem("scrollPosition");

		  // Defina a posição de rolagem da div 'scrollP' para a posição salva
		  document.getElementById("scrollP").scrollTop = scrollPosition;
		}

		// Adicione um evento de envio de formulário
		document.addEventListener("submit", function() {
		  // Salve a posição de rolagem atual no local storage
		  localStorage.setItem("scrollPosition", document.getElementById("scrollP").scrollTop);
		});
	</script>

</div>

