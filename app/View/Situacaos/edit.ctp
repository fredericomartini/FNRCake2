<h1>Situações dos jogos > Editar situação</h1>
<?php
echo $this->Form->create('Situacao');
echo $this->Form->input('nome');
echo $this->Form->input('flgsituacao');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
