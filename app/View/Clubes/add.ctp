<h1>Clubes > Novo clube</h1>
<?php
echo $this->Form->create('Clube', array('type' => 'file'));

echo $this->Form->input('nome_completo', array('label' => 'Nome completo'));

echo $this->Form->input('nome_reduzido', array('label' => 'Nome reduzido'));

echo $this->Form->input('pais', array ('id' => 'paisID', 'type' => 'select','options' => $paises, 'label' => 'País', 'empty' => ''));

echo $this->Form->input('estado', array('id' => 'estadoID' , 'type' => 'select', 'empty' => ''));

echo $this->Form->input('cidade_id', array('id' => 'cidadeID' , 'type' => 'select'));

echo $this->Form->input('estadio', array('label' => 'Estádio'));

echo $this->Form->input('simbolo', array('type' => 'file','class' => 'file','label' => 'Símbolo (51x51)'));

echo $this->Form->input('simbolo_pq', array('type' => 'file','class' => 'file','label' => 'Símbolo (19x19)'));

echo $this->Form->input('superior', array('type' => 'file','class' => 'file','label' => 'Imagem superior (776x93)'));

echo $this->Form->input('img_simbolo', array('type' => 'hidden'));

echo $this->Form->input('img_simbolo_pq', array('type' => 'hidden'));

echo $this->Form->input('img_superior', array('type' => 'hidden'));

echo $this->Form->end('Salvar');

$this->Js->get('#paisID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'estados', 'action' => 'buscaEstados', 'Clube'),
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
        array('controller' => 'cidades', 'action' => 'buscaCidades', 'Clube'),
        array(  'update' => '#cidadeID',
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