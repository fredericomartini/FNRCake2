<h1>Fórmulas > Visualizar fórmula</h1>

<p>
   Nome: <i><?php echo $formula['Formula']['nome']; ?></i> <br>
   Número de clubes participantes: <i><?php echo $formula['Formula']['numclubes']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'formulas', 'action' => 'index'), array('escape' => false) );
?>

