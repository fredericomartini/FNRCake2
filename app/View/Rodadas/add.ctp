<h1>Rodadas dos campeonatos > Nova rodada</h1>
<?php
echo $this->Html->script('jquery');

echo $this->Form->create('Rodada');

echo $this->Form->input('nome');

echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select','options' => $formulas, 'label' => 'Fórmula do campeonato', 'empty' => ''));
echo $this->Form->input('fase_id', array('id' => 'faseID' , 'type' => 'select', 'label' => 'Fases do campeonato'));
echo $this->Form->input('grupo_id', array('id' => 'grupoID' , 'type' => 'select', 'label' => 'Grupo do campeonato'));

echo $this->Form->input('ordem');
echo $this->Form->end('Salvar');

$this->Js->get('#formulaID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'fases', 'action' => 'buscaFases', 'Rodada', 'formula_id'),
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
        array('controller' => 'grupos', 'action' => 'buscaGrupos', 'Rodada'),
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

?>

<?php echo $this->Js->writeBuffer(); ?>