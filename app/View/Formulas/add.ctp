<h1>Fórmulas > Nova fórmula</h1>
<?php
echo $this->Form->create('Formula');
echo $this->Form->input('nome');
echo $this->Form->input('numclubes', array('label' => 'Número de clubes participantes'));
echo $this->Form->end('Salvar');
?>