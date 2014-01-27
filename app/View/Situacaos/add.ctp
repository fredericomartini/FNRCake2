<h1>Situações dos jogos > Nova situação</h1>
<?php
echo $this->Form->create('Situacao');
echo $this->Form->input('nome');
echo $this->Form->input('flgsituacao');
echo $this->Form->end('Salvar');
?>