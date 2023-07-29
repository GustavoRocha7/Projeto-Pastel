</main>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="js/jquery.mask.min.js"></script>
	<script src="../comanda/js/funcoes.js"></script>
	<script src="https://cdn.ckeditor.com/4.20.2/basic/ckeditor.js"></script>
	<!-- <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script> -->
	<!-- <script src="https://cdn.ckeditor.com/4.20.2/full/ckeditor.js"></script> -->
	<script type="text/javascript">
		$(document).ready(function(){
			CKEDITOR.replace("descricao").on('required', function(evt){
				alert('Descrição obrigatoria');
				evt.cancel();
			});
		})
	</script>


</body>
</html>