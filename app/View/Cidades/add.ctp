<h1>Cidades > Nova cidade</h1>
<?php

echo $this->Html->script('jquery');

echo $this->Form->create('Cidade');

echo $this->Form->input('pais', array ('id' => 'paisID', 'type' => 'select','options' => $paises, 'label' => 'País', 'empty' => ''));

echo $this->Form->input('estado_id', array('id' => 'estadoID' , 'type' => 'select'));

echo $this->Form->input('nome', array('label' => 'Cidade'));

echo $this->Form->end('Salvar');

$this->Js->get('#paisID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'estados', 'action' => 'buscaEstados', 'Cidade'),
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

?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#paisID').focus();
    });
</script>

