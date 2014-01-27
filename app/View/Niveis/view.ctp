<h1>Níveis dos campeonatos > Visualizar nível</h1>

<p>
   Nome: <i><?php echo $nivel['Nivei']['nome']; ?></i> <br>
   Tipo: <i><?php echo $nivel['Nivei']['tipo']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'niveis', 'action' => 'index'), array('escape' => false) );
?>

