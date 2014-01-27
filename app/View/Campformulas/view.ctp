<h1>Fórmulas de disputa dos campeonatos -> Vizualizar fórmula</h1>

<p>
    Campeonato: <i><?php echo $formula['Campeonato']['nome_reduzido']; ?></i> <br>
    Fórmula: <i><?php echo $formula['Formula']['nome']; ?></i> <br>
    Ano: <i><?php echo $formula['Campformula']['ano']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

