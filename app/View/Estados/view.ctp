<h1>Estados > Visualizar estado</h1>
<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'estados', 'action' => 'index'), array('escape' => false) );
?>
<p>
   Nome: <i><?php echo $estado['Estado']['nome']; ?></i> <br>
   Sigla: <i><?php echo $estado['Estado']['sigla']; ?></i> <br>
   País: <i><?php echo $paises[$estado['Estado']['paise_id']]; ?></i> <br>
</p>
