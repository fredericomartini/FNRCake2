<h1>Cidades > Visualizar cidade</h1>
<p>
   Cidade: <i><?php echo $cidade['Cidade']['nome']; ?></i> <br>
   Estado: <i><?php echo $estado['Estado']['nome']; ?></i> <br>
   País: <i><?php echo $pais['Paise']['nome']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'cidades', 'action' => 'index'), array('escape' => false) );
?>
