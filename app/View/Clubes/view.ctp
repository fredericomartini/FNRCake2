<h1>Clubes > Visualizar clube</h1>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('controller' => 'clubes', 'action' => 'index'), array('escape' => false) );
?>

<p>
    <?php
    if (!empty($clube['Clube']['img_simbolo'])) {
        echo $this->Html->image("clubes/simbolos/" . $clube['Clube']['img_simbolo'], array("alt" => "Símbolo 51x51", "title" => "Símbolo 51x51"));
    }
    /*
    if (!empty($clube['Clube']['img_simbolo_pq'])) {
        echo $this->Html->image("clubes/simbolos_pq/" . $clube['Clube']['img_simbolo_pq'], array("alt" => "Símbolo 19x19", "title" => "Símbolo 19x19"));
    }
     */
    ?>
</p>

<p>
   Nome completo: <i><?php echo $clube['Clube']['nome_completo']; ?></i> <br>
   Nome reduzido: <i><?php echo $clube['Clube']['nome_reduzido']; ?></i> <br>
   Estádio: <i><?php echo $clube['Clube']['estadio']; ?></i> <br>
   Cidade: <i><?php echo $clube['Cidade']['nome']; ?></i> <br>
   Estado: <i><?php echo $estado['Estado']['nome']; ?></i> <br>
   País: <i><?php echo $estado['Paise']['nome']; ?></i> <br>
   <?php
   /*
    if (!empty($clube['Clube']['img_superior'])) {
        echo "Imagem superior: <br><br>";
        echo $this->Html->image("clubes/superiores/" . $clube['Clube']['img_superior'], array("alt" => "Superior", "title" => "Superior"));
        echo "<br><br>";
    } else {
        echo "<b>Este clube não possui imagens cadastradas.</b>";
    }
    */
    ?>
</p>
