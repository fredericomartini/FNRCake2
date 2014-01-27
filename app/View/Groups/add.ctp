<h1>Grupos do sistema > Novo grupo</h1>
<?php
echo $this->Form->create('Group');
echo $this->Form->input('name',array('label'=>'Nome'));
echo $this->Form->input('Menu.Menu',array('title' => 'CTRL + Click (para selecionar mais de um)', 'label'=>'Escolha os menus', 'type'=>'select', 'multiple'=>true));
echo $this->Form->end('Salvar');
?>