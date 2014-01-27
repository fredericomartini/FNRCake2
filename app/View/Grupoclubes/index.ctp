<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Participantes dos campeonatos por grupos</h1>

<?php echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('action' => 'add'), array('escape' => false)); ?>

<div id="lobao">
    <?php
    echo $this->Search->create('Grupoclube');
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Campeonato --'));
    echo $this->Html->image("sep_2.png");
    echo $this->Search->input('filter2', array('class' => 'select-box'));
    echo $this->Html->image("sep_2.png");
    echo $this->Search->input('filter3', array('class' => 'select-box'));
    echo $this->Html->image("sep_2.png");
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>
</div>

<table>

    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        'Campeonato',
        'Grupo',
        'Clube',
        'Ano',
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($clubes as $item):
        $rows[] = array(
            $item['Grupoclube']['id'],
            $this->Html->link($item['Campeonato']['nome_reduzido'], array('action' => 'view', $item['Grupoclube']['id'])),
            $this->Html->link($item['Grupo']['nome'], array('action' => 'view', $item['Grupoclube']['id'])),
            $this->Html->link($item['Clube']['nome_reduzido'], array('action' => 'view', $item['Grupoclube']['id'])),
            $this->Html->link($item['Grupoclube']['ano'], array('action' => 'view', $item['Grupoclube']['id'])),
            $this->Form->postLink('Retirar do grupo', array('action' => 'delete', $item['Grupoclube']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>



<?php unset($clubes); ?>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}

$this->Js->get('#filterFilter1')->event(
    'change',
    $this->Js->request(
        array('controller' => 'jogos', 'action' => 'buscaFasesFiltro', 'filter', 'filter1'),
        array(  'update' => '#filterFilter2',
                'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => true,
			'inline' => true
			)),
            )
    )
);

$this->Js->get('#filterFilter2')->event(
    'change',
    $this->Js->request(
        array('controller' => 'jogos', 'action' => 'buscaGruposFiltro', 'filter', 'filter2'),
        array(  'update' => '#filterFilter3',
                'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => true,
			'inline' => true
			)),
            )
    )
);

?>


<?php echo $this->Js->writeBuffer(); ?>
