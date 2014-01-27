<h1>Usuários do sistema > Novo usuário</h1>
<?php 
echo $this->Form->create('User');
echo $this->Form->input('nome');
echo $this->Form->input('sobrenome');
echo $this->Form->input('email', array('type' => 'email'));
echo $this->Form->input('radio');
echo $this->Form->input('username');
echo $this->Form->input('password');

echo $this->Form->input('group_id', array ('type' => 'select','options' => $groups, 'label' => 'Grupo'));

echo $this->Form->end('Criar usuário');
?>