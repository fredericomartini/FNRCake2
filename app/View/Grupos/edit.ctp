<h1>Grupos dos campeonatos > Editar grupo</h1>
<?php
echo $this->Form->create('Grupo');
echo $this->Form->input('nome');
echo $this->Form->input('ordem');
echo $this->Form->input('classificacao', array('type' => 'hidden'));
echo $this->Form->input('fase_id', array('type' => 'hidden'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
