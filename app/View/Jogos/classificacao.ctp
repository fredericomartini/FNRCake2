<h1>Jogos -> Classificação</h1>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

<p>
    
    <table>
        <tr>
            <td>Pos.</td>
            <td></td>
            <td>Clube</td>
            <td>P</td>
            <td>J</td>
            <td>V</td>
            <td>E</td>
            <td>D</td>
            <td>GP</td>
            <td>GC</td>
            <td>SG</td>
            <td>AP</td>
        </tr>
        
        <?php
        for ($i=0; $i<20; $i++) {
            ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $this->Html->image("clubes/simbolos_pq/" . $campeonatos[$i]['Clube']['img_simbolo_pq'], array("title" => $campeonatos[$i]['Clube']['nome_reduzido'])); ?></td>
                <td><?php echo $campeonatos[$i]['Clube']['nome_reduzido']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['pontos']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['jogos']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['vitorias']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['empates']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['derrotas']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['gols_pro']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['gols_contras']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['saldo']; ?></td>
                <td><?php echo $campeonatos[$i]['Grupoclube']['aproveitamento']; ?></td>
            </tr>
            <?php
        }
        
        ?>
        
    </table>
    
    <?php echo $campeonatos[0]['Clube']['nome_reduzido']; ?>
</p>

