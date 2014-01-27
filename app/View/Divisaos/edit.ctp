<h1>Divisões > Editar divisão</h1>
<?php
echo $this->Form->create('Divisao');
echo $this->Form->input('nome');
echo $this->Form->input('divisao');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
