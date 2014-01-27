<h1>Países do sistema > Editar país</h1>
<?php
echo $this->Form->create('Paise');
echo $this->Form->input('nome');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
