<h1>Divisões > Nova divisão</h1>
<?php
echo $this->Form->create('Divisao');
echo $this->Form->input('nome');
echo $this->Form->input('divisao');
echo $this->Form->end('Salvar');
?>