<h1>Participantes dos campeonatos -> Visualizar participante</h1>

<p>

    
    Ano: <i><?php echo $clubes['Grupoclube']['ano']; ?></i> <br> 
    Campeonato: <i><?php echo $clubes['Campeonato']['nome_reduzido']; ?></i> <br>
    Fórmula: <i><?php echo $clubes['Formula']['nome']; ?></i> <br>
    Fase: <i><?php echo $clubes['Fase']['nome']; ?></i> <br>
    Grupo: <i><?php echo $clubes['Grupo']['nome']; ?></i> <br>
    Clube: <i><?php echo $clubes['Clube']['nome_reduzido']; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

