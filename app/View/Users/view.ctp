<h1>Usuários do sistema > Visualizar usuário</h1>
<p>
   Nome: <i><?php echo $user['User']['nome'] . " " . $user['User']['sobrenome']; ?></i> <br>
   E-mail: <i><?php echo $user['User']['email']; ?></i> <br>
   Rádio: <i><?php if(empty($user['User']['radio'])) { echo " - "; } else { echo $user['User']['radio']; } ?></i> <br>
   Perfil: <i><?php echo $groups[$user['User']['group_id']]; ?></i> <br>
   Data de criação: <i><?php echo date('d/m/Y H:i', strtotime($user['User']['created'])); ?></i> <br>
    
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'users', 'action' => 'index'), array('escape' => false) );
?>
