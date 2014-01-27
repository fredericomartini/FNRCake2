<h1>Grupos dos campeonatos > Visualizar grupo</h1>

<p>
    Fórmula de disputa: <i><?php echo $formula['Formula']['nome']; ?></i> <br>
    Fase do campeonato: <i><?php echo $grupo['Fase']['nome']; ?></i> <br>
    Nome do grupo: <i><?php echo $grupo['Grupo']['nome']; ?></i> <br>
    Ordem: <i><?php echo $grupo['Grupo']['ordem']; ?></i> <br>
    Gera classificação: <i><?php if ($grupo['Grupo']['classificacao'] == "1") { echo "SIM"; } else { echo "NAO"; }; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

