<h1>Fases dos campeonatos > Visualizar fase</h1>

<p>
    Fórmula de disputa: <i><?php echo $fase['Formula']['nome']; ?></i> <br>
    Nome da fase: <i><?php echo $fase['Fase']['nome']; ?></i> <br>
    Ordem: <i><?php echo $fase['Fase']['ordem']; ?></i> <br>
    Gera classificação geral: <i><?php if ($fase['Fase']['classificacaogeral'] == "1") { echo "SIM"; } else { echo "NAO"; }; ?></i> <br>
    Permite jogos com clubes de outro grupo: <i><?php if ($fase['Fase']['jogosentregrupos'] == "1") { echo "SIM"; } else { echo "NAO"; }; ?></i> <br>
</p>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

