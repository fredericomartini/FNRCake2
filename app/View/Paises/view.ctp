<h1>Países do sistema > Visualizar país</h1>

<p>
   Nome: <i><?php echo $paise['Paise']['nome']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'paises', 'action' => 'index'), array('escape' => false) );
?>

