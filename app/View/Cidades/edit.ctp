<h1>Cidades > Editar cidade</h1>
<?php
echo $this->Form->create('Cidade');
echo $this->Form->input('nome', array('label' => 'Cidade'));
echo $this->Form->input('estado_id', array('type' => 'hidden'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>