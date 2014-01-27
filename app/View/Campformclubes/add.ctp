<h1>Participantes dos campeonatos > Participantes <?php echo date("Y"); ?></h1>

<?php
echo $this->Form->create('Campformclube');

echo $this->Form->input('campeonato_id', array ('id' => 'campeonatoID', 'type' => 'select','options' => $campeonatos, 'label' => 'Campeonato', 'empty' => ''));
echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select', 'label' => 'Fórmula', 'empty' => ''));
echo $this->Form->input('clube_id', array ('id' => 'clubeID', 'type' => 'select', 'label' => 'Clube', 'empty' => ''));
echo $this->Form->input('ano', array('type' => 'hidden', 'value' => date("Y")));
echo $this->Form->end('Salvar');

$this->Js->get('#campeonatoID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'campformulas', 'action' => 'buscaFormula', 'Campformclube', date("Y")),
        array(  'update' => '#formulaID',
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

$this->Js->get('#campeonatoID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'clubes', 'action' => 'buscaClubesParticipantes', 'Campformclube'),
        array(  'update' => '#clubeID',
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
        $('#campeonatoID').focus();
    });
</script>
