<h1>Fases dos campeonatos > Nova fase</h1>
<?php
echo $this->Form->create('Fase');
echo $this->Form->input('nome');
echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select','options' => $formulas, 'label' => 'Fórmula de disputa', 'empty' => ''));
echo $this->Form->input('classificacaogeral', array ('id' => 'classificacaogeral', 'type' => 'select','options' => $opcoes, 'label' => 'Gera classificação geral?', 'empty' => ''));
echo $this->Form->input('jogosentregrupos', array ('id' => 'jogosentregrupos', 'type' => 'select','options' => $opcoes, 'label' => 'Permite jogos com clubes de outro grupo?', 'empty' => ''));
echo $this->Form->input('ordem');
echo $this->Form->end('Salvar');
?>