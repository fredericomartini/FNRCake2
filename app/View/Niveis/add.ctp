<h1>Níveis dos campeonatos > Novo nível</h1>
<?php
echo $this->Form->create('Nivei');
echo $this->Form->input('nome');
echo $this->Form->input('tipo');
echo $this->Form->end('Salvar');
?>