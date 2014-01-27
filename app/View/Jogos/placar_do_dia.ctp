<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Jogos do dia</h1>


<table>

    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('Campeonato.nome_reduzido', 'Campeonato'),
        $this->Paginator->sort('Fase.nome', 'Fase'),
        $this->Paginator->sort('Rodada.nome', 'Rodada'),
        $this->Paginator->sort('Jogo.datahora', 'Data/Hora'),
        '',
        '',
        '',
        '',
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();
    
    //debug($jogos);

    foreach ($jogos as $item):
        if ($item['Jogo']['situacaojogo'] == 4) { $situacao = "E"; } else { $situacao = "N"; }
        $rows[] = array(
            $item['Jogo']['id'],
            $this->Html->link($item['Campeonato']['nome_reduzido'], array('action' => 'view', $item['Jogo']['id'])),
            $this->Html->link($item['Fase']['nome'], array('action' => 'view', $item['Jogo']['id'])),
            $this->Html->link($item['Rodada']['nome'], array('action' => 'view', $item['Jogo']['id'])),
            $this->Html->link(date('d/m/Y H:i', strtotime($item['Jogo']['datahora'])), array('action' => 'view', $item['Jogo']['id'])),
            array($this->Html->image("clubes/simbolos_pq/" . $item['Clube01']['img_simbolo_pq'], array("title" => $item['Clube01']['nome_reduzido'])), array('class' => 'mandante')),
            $item['Jogo']['gols_01'] . ' x ' . $item['Jogo']['gols_02'],
            $this->Html->image("clubes/simbolos_pq/" . $item['Clube02']['img_simbolo_pq'], array("title" => $item['Clube02']['nome_reduzido'])),
            $situacao,
            $this->Html->link('Editar', array('action' => 'edit', $item['Jogo']['id'], 'placarDoDia')) . " " .
            $this->Html->link('Resultado', array('action' => 'resultado', $item['Jogo']['id'], 'placarDoDia')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}
?>

<?php echo $this->Js->writeBuffer(); ?>



