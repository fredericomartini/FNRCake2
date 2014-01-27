<h1>Níveis dos campeonatos > Editar nível</h1>
<?php
echo $this->Form->create('Nivei');
echo $this->Form->input('nome');
echo $this->Form->input('tipo');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
