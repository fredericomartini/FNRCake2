<h1>Jogos -> Visualizar jogo</h1>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

<p>
    <?php echo $jogo['Campeonato']['nome_reduzido']; ?>
    <br>
    <?php echo $jogo['Formula']['nome'] . " > " . $jogo['Fase']['nome'] . " > " . $jogo['Grupo']['nome']; ?>
    <br>
    <?php echo $jogo['Rodada']['nome']; ?>
    <br>
    <?php echo $jogo['Jogo']['estadio'] . " > " . date('d/m/Y H:i', strtotime($jogo['Jogo']['datahora'])); ?>
    <?php
        /*
        * Situação do jogo:
        * 0 = Não Iniciado
        * 1 = 1o Tempo
        * 2 = Intervalo
        * 3 = 2o Tempo
        * 4 = Encerrado
        */
        if ($jogo['Jogo']['situacaojogo'] == 0) {
            echo " > <b>Não iniciado</b>";
        } elseif ($jogo['Jogo']['situacaojogo'] == 1) {
            echo " > <b>1o Tempo</b>";
        } elseif ($jogo['Jogo']['situacaojogo'] == 2) {
            echo " > <b>Intervalo</b>";
        } elseif ($jogo['Jogo']['situacaojogo'] == 3) {
            echo " > <b>2o Tempo</b>";
        } elseif ($jogo['Jogo']['situacaojogo'] == 4) {
            echo " > <b>Encerrado</b>";
        }
    ?>
    <br>
    <?php echo $this->Html->image("clubes/simbolos_pq/" . $jogo['Clube01']['img_simbolo_pq'], array("title" => $jogo['Clube01']['nome_reduzido'])); ?>
    <?php echo $jogo['Jogo']['gols_01']; ?>
    x
    <?php echo $jogo['Jogo']['gols_02']; ?>
    <?php echo $this->Html->image("clubes/simbolos_pq/" . $jogo['Clube02']['img_simbolo_pq'], array("title" => $jogo['Clube02']['nome_reduzido'])); ?>
    <br>
    <?php
        if ($jogo['Jogo']['placaraovivo'] == 0) {
            echo "Jogo não transmitido no placar ao vivo";
        } elseif ($jogo['Jogo']['placaraovivo'] == 1) {
            echo "<b>Jogo com transmissão no placar ao vivo</b>";
        }
    ?>
</p>

