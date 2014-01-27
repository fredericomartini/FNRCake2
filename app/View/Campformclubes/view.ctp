<h1>Participantes dos campeonatos -> Visualizar participante</h1>

<p>
    Campeonato: <i><?php echo $clubes['Campeonato']['nome_reduzido']; ?></i> <br>
    Clube: <i><?php echo $clubes['Clube']['nome_reduzido']; ?></i> <br>
    Fórmula: <i><?php echo $clubes['Formula']['nome']; ?></i> <br>
    Ano: <i><?php echo $clubes['Campformclube']['ano']; ?></i> <br> 
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

