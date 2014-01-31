<h1>Noticias > Editar Noticia</h1>
<?php
echo $this -> Html -> script('ckeditor/ckeditor.js');

echo $this -> Form -> create('Noticia', array('type' => 'file'));
echo $this -> Form -> input('id', array('id' => 'noticiaID', 'type' => 'hidden') );
echo $this -> Form -> input('cidade_id', array('id' => 'cidadeID', 'type' => 'select', 'options' => $cidades, 'label' => 'Cidade', 'empty' => ''));
echo $this -> Form -> input('clube_id', array('id' => 'clubeID', 'type' => 'select', 'options' => $clubes, 'empty' => ''));
echo $this -> Form -> input('titulo');
echo $this -> Form -> input('subtitulo');
echo $this -> Form -> input('corpo', array('id' => 'corpo', 'class' => 'ckeditor'));
echo $this -> Form -> input('rodape');
?>

<?
	$datames = date('d/m/Y', strtotime($this->request->data['Noticia']['datahora']));
	$hora = date('H', strtotime($this->request->data['Noticia']['datahora']));
	$minuto = date('i', strtotime($this->request->data['Noticia']['datahora']));;
?>
<div class="input text">
    <label for="datepicker">Data / Hora</label>
    <input name="datanoticia" type="text" class="datepicker" id="datepicker" title="Informe a data" value="<?php echo $datames; ?>">
    <select name="horas" id="horas" class="campohora" title="Informe a hora">
        <option value="<?php echo $hora; ?>"><?php echo $hora; ?></option>
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
        <option value="<?php echo $minuto; ?>"><?php echo $minuto; ?></option>
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

<?
echo $this -> Form -> end('Salvar');


//CARREGA COMBO
$this -> Js -> get('#cidadeID') -> event(
'change',
	$this -> Js -> request(
		array('controller' => 'clubes', 'action' => 'buscaClubes', 'Noticia'), 
		array('update' => '#clubeID', 'async' => true,
			  'method' => 'post',
			  'dataExpression' => true,
			  'data' => $this -> Js -> serializeForm(array(
			 			 'isForm' => true,
			 			 'inline' => true)) 
	)));
?>

<script type="text/javascript" charset="utf-8">
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
