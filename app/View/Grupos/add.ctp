<h1>Grupos dos campeonatos > Novo grupo</h1>
<?php
echo $this->Html->script('jquery');

echo $this->Form->create('Grupo');

echo $this->Form->input('nome');
echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select','options' => $formulas, 'label' => 'Fórmula do campeonato', 'empty' => ''));
echo $this->Form->input('fase_id', array('id' => 'faseID' , 'type' => 'select', 'label' => 'Fases do campeonato'));
echo $this->Form->input('classificacao', array ('id' => 'classificacao', 'type' => 'select','options' => $opcoes, 'label' => 'Gera classificação?', 'empty' => ''));
echo $this->Form->input('ordem');
echo $this->Form->end('Salvar');

$this->Js->get('#formulaID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'fases', 'action' => 'buscaFases', 'Grupo', 'formula_id'),
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

?>

<?php echo $this->Js->writeBuffer(); ?>