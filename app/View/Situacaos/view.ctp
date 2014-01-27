<h1>Situações dos jogos > Visualizar situação</h1>

<p>
   Nome: <i><?php echo $situacao['Situacao']['nome']; ?></i> <br>
   Flag: <i><?php echo $situacao['Situacao']['flgsituacao']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'situacaos', 'action' => 'index'), array('escape' => false) );
?>

