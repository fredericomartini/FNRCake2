<h1>Noticias > Editar Noticia</h1>

<?php
echo $this -> Form -> create('Noticia', array('type' => 'file'));
/** OPTION BUTTON IMAGES ***/
?>
<div id="options_imagem" style="font-size: 15px; color:black;" align="center">
	<table>
		<tr>
			<td>
				<input type="radio" name="image"  value="semImagem" id ="semImagem" />
				<label for="semImagem">Sem Imagem</label>
			</td>
			<td>
				<input type="radio" name="image" value="uploadImagem" id ="uploadImagem" />
				<label for="uploadImagem">Upload de Imagem</label>
			</td>
			<td>
				<input type="radio" name="image"    value="urlImagem" id ="urlImagem" />
				<label for="urlImagem">Url de Imagem</label>
			</td>
		</tr>
	</table>
</div>
	
<div id="upload" style="display: none;">
<?php
	echo $this -> Form -> input('imagemUpload', array('id' => 'imagemUpload', 'type' => 'file', 'class' => 'file', 'label' => 'Upload Imagem'));
	echo $this -> Form -> input('img_upload', array('id' => 'img_upload', 'type' => 'hidden'));
?>
</div>
<div id="url" style="display: none;">
	<?php echo $this->Form->input('img_url', array('id' => 'imagemUrl', 'label' => 'Url Imagem')); ?>
</div>

<?
/** OPTION BUTTON IMAGES ***/
echo $this -> Form -> end('Salvar');
?>

<script type="text/javascript" charset="utf-8">
	//QUANDO PAGINA CARREGA
	$().ready(function() {
		//VERIFICAR QUAL CAMPO ESTA SELECIONADO: img_upload, img_url ou sem img
		//SE IMAGEM CONTIVER IMAGEM URL
		if ($('#imagemUrl').val() != '') {
			//alert('imagem url e definido!'+ $('#imagemUrl').val());
			$("#urlImagem").attr('checked', true);
			$('#url').show();
		}
		//SE IMAGEM CONTIVER IMAGEM UPLOAD
		else if ($('#img_upload').val() != '') {
			//alert('imagem uPLOAD e definido2 !'+ $('#img_upload').val());
			$("#uploadImagem").attr('checked', true);
			$('#upload').show();
		}
		//SE FOR SEM IMAGEM
		else {
			$("#semImagem").attr('checked', true);
		}

	});

	//MANIPULACAO BOTOES IMAGEM
	$("input[id=uploadImagem]").on("click", function() {

		$("#uploadImagem").is(":checked")
		$('#upload').show();
		$('#url').hide();
		$('#imagemUrl').val('');
	});

	$("input[id=urlImagem]").on("click", function teste() {

		$("#urlImagem").is(":checked");
		$('#upload').hide();
		$('#url').show();
		$('#noImage').val('');
		$('#imagemUpload').val('');
		$('#img_upload').val('');
	});

	$("input[id=semImagem]").on("click", function() {

		$("#semImagem").is(":checked");
		$('#upload').hide();
		$('#url').hide();
		$('#imagemUrl').val('');
		$('#imagemUpload').val('');
	});
</script>

