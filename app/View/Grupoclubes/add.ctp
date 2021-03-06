<h1>Participantes dos campeonatos > Participantes <?php echo date("Y"); ?></h1>

<?php
echo $this->Html->script('jquery');

echo $this->Form->create('Grupoclube');

echo $this->Form->input('campeonato_id', array ('id' => 'campeonatoID', 'type' => 'select','options' => $campeonatos, 'label' => 'Campeonato', 'empty' => ''));
echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select', 'label' => 'Fórmula', 'empty' => ''));
echo $this->Form->input('fase_id', array ('id' => 'faseID', 'type' => 'select', 'label' => 'Fase', 'empty' => ''));
echo $this->Form->input('grupo_id', array ('id' => 'grupoID', 'type' => 'select', 'label' => 'Grupo', 'empty' => ''));
echo $this->Form->input('clube_id', array ('id' => 'clubeID', 'type' => 'select', 'label' => 'Clube', 'empty' => ''));
echo $this->Form->input('ano', array('type' => 'hidden', 'value' => date("Y")));
echo $this->Form->end('Salvar');

$this->Js->get('#campeonatoID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'campformulas', 'action' => 'buscaFormula', 'Grupoclube', date("Y")),
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

$this->Js->get('#formulaID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'fases', 'action' => 'buscaFases', 'Grupoclube', 'formula_id'),
        array(  'update' => '#faseID',
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

$this->Js->get('#faseID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'grupos', 'action' => 'buscaGrupos', 'Grupoclube'),
        array(  'update' => '#grupoID',
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
        array('controller' => 'campformclubes', 'action' => 'buscaClubes', 'Grupoclube', date("Y")),
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

<?php echo $this->Js->writeBuffer(); ?>