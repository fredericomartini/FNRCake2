<h1>Campeonatos > Novo campeonato</h1>
<?php

echo $this->Form->create('Campeonato', array('type' => 'file'));

echo $this->Form->input('nome_completo', array('id' => 'nome_completo', 'label' => 'Nome completo'));

echo $this->Form->input('nome_reduzido', array('id' => 'nome_reduzido', 'label' => 'Nome reduzido'));

echo $this->Form->input('nivei_id', array ('id' => 'nivelID', 'type' => 'select','options' => $niveis, 'label' => 'Nível', 'empty' => ''));

echo $this->Form->input('divisao_id', array ('id' => 'divisaoID', 'type' => 'select','options' => $divisoes, 'label' => 'Divisão', 'empty' => ''));

echo $this->Form->input('paise_id', array ('id' => 'paisID', 'type' => 'select','options' => $paises, 'label' => 'País', 'empty' => ''));

echo $this->Form->input('estado_id', array('id' => 'estadoID' , 'type' => 'select'));

echo $this->Form->input('superior', array('type' => 'file','class' => 'file','label' => 'Imagem superior (776x93)'));

echo $this->Form->input('img_superior', array('type' => 'hidden'));

echo $this->Form->end('Salvar');

$this->Js->get('#nivelID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'paises', 'action' => 'buscaPaises'),
        array(  'update' => '#paisID',
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

$this->Js->get('#paisID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'estados', 'action' => 'buscaEstados', 'Campeonato'),
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

foreach($tipoNivel as $key => $tipo){
    if ($tipo == "E") {
        $nivelEstadual = $key;
    } elseif ($tipo == "N") {
        $nivelNacional = $key;
    } elseif ($tipo == "I") {
        $nivelInternacional = $key;
    }
}
?>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#paisID").attr('disabled','disabled');
        $("#estadoID").attr('disabled','disabled');
        $("#divisaoID").attr('disabled','disabled');
        $("#nivelID").change( function(){
            var itemSelecionado = $("#nivelID option:selected").val();
            if(itemSelecionado == <?php echo $nivelEstadual; ?>){
                $("#paisID").attr('disabled',false);
                $("#estadoID").attr('disabled',false);
                $("#divisaoID").attr('disabled',false);
            } else if (itemSelecionado == <?php echo $nivelNacional; ?>) {
                $("#paisID").attr('disabled',false);
                $("#estadoID").attr('disabled','disabled');
                $('#estadoID').append('<option value="NULL" selected="selected"></option>');
                $("#divisaoID").attr('disabled',false);
            } else if (itemSelecionado == <?php echo $nivelInternacional; ?>) {
                $("#paisID").attr('disabled','disabled');
                $('#paisID').append('<option value="NULL" selected="selected"></option>');
                $("#estadoID").attr('disabled','disabled');
                $('#estadoID').append('<option value="NULL" selected="selected"></option>');
                $("#divisaoID").attr('disabled','disabled');
                $('#divisaoID').append('<option value="NULL" selected="selected"></option>');
            }
	});
    });
    
</script>

<?php echo $this->Js->writeBuffer(); ?>