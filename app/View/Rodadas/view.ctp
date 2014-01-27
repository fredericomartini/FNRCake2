<h1>Rodadas dos campeonatos > Visualizar rodada</h1>

<p>
    Fórmula de disputa: <i><?php echo $fase['Formula']['nome']; ?></i> <br>
    Fase do campeonato: <i><?php echo $fase['Fase']['nome']; ?></i> <br>
    Grupo do campeonato: <i><?php echo $rodada['Grupo']['nome']; ?></i> <br>
    Nome da Rodada: <i><?php echo $rodada['Rodada']['nome']; ?></i> <br>
    Ordem: <i><?php echo $rodada['Rodada']['ordem']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

