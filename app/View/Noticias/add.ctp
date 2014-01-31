
<h1>Notícias do sistema > Nova Notícia</h1>
<?php 
echo $this->Html->script('ckeditor/ckeditor.js');
echo $this->Html->script('ckeditor/config.js');

echo $this->Form->create('Noticia', array('type' => 'file'));
echo $this->Form->input('pais', array ('id' => 'paisID', 'type' => 'select', 'options' => $paises, 'label' => 'País', 'empty' => ''));
echo $this->Form->input('estado', array('id' => 'estadoID' , 'type' => 'select'));
echo $this->Form->input('cidade_id', array('id' => 'cidadeID' , 'type' => 'select'));
echo $this->Form->input('clube_id', array('id' => 'clubeID' , 'type' => 'select'));

/**********************
 OPTION BUTTON IMAGES
**********************/
?>
	<div id="options_imagem" style="font-size: 15px; color:black;" align="center">
		<table>
			<tr>
				<td>
					<input type="radio" name="image"  value="semImagem" id ="semImagem" checked="true" />
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
<?php		echo $this->Form->input('imagemUpload', array('id' =>'imagemUpload', 'type' => 'file','class' => 'file','label' => 'Upload Imagem')); ?>
	</div>
	<div id="url" style="display: none;">
		<?php echo $this->Form->input('img_url', array('id' => 'imagemUrl', 'label' => 'Url Imagem')); ?>	  
	</div>
<?

echo $this->Form->input('titulo');
echo $this->Form->input('subtitulo');
echo $this->Form->input('corpo', array('id' => 'corpo', 'class' => 'ckeditor'));
echo $this->Form->input('rodape');

/*******************************
BOTOES ENTRA NO AR
********************************/
?>
	<div id="option_datahora" style="font-size: 15px; color:black;" align="center">
		<table>
			<tr>
				<td>
					<input type="radio" name="datahoras"  value="entraNoAr" id ="entraNoAr" checked="true"/>
					<label for="entraNoAr">Entrar No Ar</label>
				</td>
				<td>	
					<input type="radio" name="datahoras" value="programarHora" id ="programarHora" />
					<label for="programarHora">Programar Hora</label>
				</td>
			</tr>
		</table>
	</div>


	<div id="programar" style="display: none;">
		<div class="input text">
		    <label for="datepicker">Data / Hora</label>
		    <input name="pdatahora" type="text" class="datepicker" id="datepicker" title="Informe a data">
		    <select name="horas" id="horas" class="campohora" title="Informe a hora">
		        <option value=""></option>
		        <?php
		        for($i=23; $i>=0; $i--) {
		            if ($i < 10) {
		                ?><option value="0<?php echo $i; ?>">0<?php echo $i; ?></option><?php
		            } else {
		                ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
		            }
		        }
		        ?>
		    </select>
		    <select name="minutos" id="minutos" class="campohora" title="Informe os minutos">
		        <option value=""></option>
		        <option value="00">00</option>
		        <option value="05">05</option>
		        <option value="10">10</option>
		        <option value="15">15</option>
		        <option value="20">20</option>
		        <option value="25">25</option>
		        <option value="30">30</option>
		        <option value="35">35</option>
		        <option value="45">45</option>
		        <option value="50">50</option>
		        <option value="55">55</option>
		    </select>
		</div>		
	</div>		
<?
echo $this->Form->input('datahora', array('type' => 'hidden', 'value' => 'now'));
echo $this -> Form -> end('Salvar');

//CARREGA COMBO
$this->Js->get('#paisID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'estados', 'action' => 'buscaEstados', 'Noticia'),
        array(  'update' => '#estadoID',
                'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => true,
			'inline' => true
			)),
            )
    )
);

$this->Js->get('#estadoID')->event(
	'change',
	$this->Js->request(
		array('controller' => 'cidades', 'action' => 'buscaCidades', 'Noticia'),
		array('update' => '#cidadeID', 
			  'async'  => true,
		  'method' => 'post',
		  'dataExpression' => true,
		  'data' => $this->Js->serializeForm(array(
		  		'isForm' => true,
				'inline' => true
				)),
			 )
	)	
);

$this->Js->get('#cidadeID')->event(
	'change',
	$this->Js->request(
		array('controller' => 'clubes', 'action' => 'buscaClubes', 'Noticia'),
		array('update' => '#clubeID', 
			  'async'  => true,
		  'method' => 'post',
		  'dataExpression' => true,
		  'data' => $this->Js->serializeForm(array(
		  		'isForm' => true,
				'inline' => true
				)),
			 )
	)	
);
?>
	<script type="text/javascript" charset="utf-8">
	
		//MANIPULACAO BOTOES IMAGEM
        $("input[id=uploadImagem]").on("click", function(){	
        
        $("#uploadImagem").is(":checked")
	        	$('#upload').show();
	        	$('#url').hide(); 	
	        	$('#imagemUrl').val('');
        });
        
		$("input[id=urlImagem]").on("click", function(){	
        
        $("#urlImagem").is(":checked");
	        	$('#upload').hide();
	        	$('#url').show();
	            $('#noImage').val('');
	           	$('#imagemUpload').val('');  	
        });	
        
		$("input[id=semImagem]").on("click", function(){	
        
        $("#semImagem").is(":checked");
	        	$('#upload').hide();
	        	$('#url').hide(); 	
				$('#imagemUrl').val('');
				$('#imagemUpload').val(''); 
        });	 
        
        //MANIPULACAO BOTOES HORARIO
         $("input[id=entraNoAr]").on("click", function(){	
        
         $("#entraNoAr").is(":checked");
	        	$('#programar').hide();	   
	        	$('#NoticiaDatahora').val('now'); 
	        	  	 
        });	        

         $("input[id=programarHora]").on("click", function(){	
        
         $("#programarHora").is(":checked");
	        	$('#programar').show();
	        	$('#NoticiaDatahora').val('');  
        });	        
		 
		$("#datepicker").mask("99/99/9999");
		
		//DATAPICKER
		$(function() {
    		$( "#datepicker" ).datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
  		});
  		
	</script>