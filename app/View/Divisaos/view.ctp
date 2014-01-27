<h1>Divisões > Visualizar divisão</h1>

<p>
   Nome: <i><?php echo $divisao['Divisao']['nome']; ?></i> <br>
   Divisão: <i><?php echo $divisao['Divisao']['divisao']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'divisaos', 'action' => 'index'), array('escape' => false) );
?>

