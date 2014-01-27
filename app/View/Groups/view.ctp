<h1>Grupos do sistema > Visualizar grupo</h1>
<p>
    
   Nome: <i><?php echo $group['Group']['name']; ?></i> <br>
   
   <?php $i = 0; ?>
    
    Menus: <br>
    
    <?php foreach ($group['Menu'] as $menu): ?>
   
        &nbsp;&nbsp;&nbsp;&nbsp; <i><?php echo $menu['nome']; ?></i> <br>
        
    <?php $i++; ?>
    <?php endforeach; ?>
    <?php unset($group); ?>
   
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'groups', 'action' => 'index'), array('escape' => false) );
?>