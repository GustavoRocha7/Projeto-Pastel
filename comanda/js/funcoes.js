function aumenta(quant,quant1, id){
	quant = parseInt(document.getElementById(id).value);
	document.getElementById(id).value = quant + 1;
	if (quant >= quant1) {
		quant = parseInt(document.getElementById(id).value);
		document.getElementById(id).value = quant1;
	}
}

function diminui(quant, id){
	quant = parseInt(document.getElementById(id).value);
	document.getElementById(id).value = quant - 1;
	if (quant <= 0) {
		quant = parseInt(document.getElementById(id).innerText);
		document.getElementById(id).value = quant = 0;
	}
}

function exclui(quant, id){
	quant = parseInt(document.getElementById(id).value);
	document.getElementById(id).value = quant = 0;
}

function fechaComanda(id){
	resposta = confirm('Deseja deseja fechar a comanda?');
	if (resposta == true) {
		return true;
	}
	return false;
}
function excluiProduto(id){
	resposta = confirm('Deseja deseja excluir este produto?');
	if (resposta == true) {
		return true;
	}
	return false;
}


