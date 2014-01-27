<h1>Fases dos campeonatos > Editar fase</h1>
<?php
echo $this->Form->create('Fase');
echo $this->Form->input('nome');
echo $this->Form->input('ordem');
echo $this->Form->input('classificacaogeral', array('type' => 'hidden'));
echo $this->Form->input('jogosentregrupos', array('type' => 'hidden'));
echo $this->Form->input('formula_id', array('type' => 'hidden'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>
