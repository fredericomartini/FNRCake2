<h1>Rodadas dos campeonatos > Editar rodada</h1>
<?php
echo $this->Form->create('Rodada');
echo $this->Form->input('nome');
echo $this->Form->input('ordem');
echo $this->Form->input('grupo_id', array('type' => 'hidden'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
