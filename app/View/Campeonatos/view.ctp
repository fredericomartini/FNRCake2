<h1>Campeonatos > Visualizar campeonato</h1>

<?php 
    echo $this->Html->link($this->Html->image("voltar.png", array("title" => "Voltar")), array('action' => 'index'), array('escape' => false) );
?>

<p>
    <?php
    if (!empty($campeonato['Campeonato']['img_superior'])) {
       echo $this->Html->image("campeonatos/superiores/" . $campeonato['Campeonato']['img_superior'], array("alt" => "Superior", "title" => "Superior"));
       echo "<br><br>";
   } else {
       echo "<b>Este campeonato não possui imagens cadastradas.</b>";
   }
   ?>
</p>

<p>
   Nome completo: <i><?php echo $campeonato['Campeonato']['nome_completo']; ?></i> <br>
   Nome reduzido: <i><?php echo $campeonato['Campeonato']['nome_reduzido']; ?></i> <br>
   Nível: <i><?php echo $campeonato['Nivei']['nome']; ?></i> <br>
   <?php
   if (!empty($campeonato['Divisao']['nome'])) {
       echo "Divisão: <i>" . $campeonato['Divisao']['nome'] . "</i><br>";
   }
   if (!empty($campeonato['Paise']['nome'])) {
       echo "País: <i>" . $campeonato['Paise']['nome'] . "</i><br>";
   }
   if (!empty($campeonato['Estado']['nome'])) {
       echo "Estado: <i>" . $campeonato['Estado']['nome'] . "</i><br>";
   }
   ?>
</p>

