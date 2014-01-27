<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Grupos dos campeonatos</h1>

<?php
echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'grupos', 'action' => 'add'), array('escape' => false));
?>

<div id="lobao">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Fórmula --'));
    echo $this->Html->image("sep_2.png");
    echo $this->Search->input('filter2', array('class' => 'select-box'));
    echo $this->Html->image("sep_2.png");
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>

</div>

<table>

    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('nome', 'Fase', array('escape' => false)),
        $this->Paginator->sort('nome', 'Grupo'),
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($grupos as $grupo):
        $rows[] = array(
            $grupo['Grupo']['id'],
            $this->Html->link($grupo['Fase']['nome'], array('action' => 'view', $grupo['Grupo']['id'])),
            $this->Html->link($grupo['Grupo']['nome'], array('action' => 'view', $grupo['Grupo']['id'])),
            $this->Html->link('Editar', array('action' => 'edit', $grupo['Grupo']['id'])) . " " .
            $this->Form->postLink('Apagar', array('action' => 'delete', $grupo['Grupo']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>



<?php unset($grupo); ?>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}

$this->Js->get('#filterFilter1')->event(
    'change',
    $this->Js->request(
        array('controller' => 'grupos', 'action' => 'buscaFasesFiltro', 'filter', 'filter1'),
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

?>


<?php echo $this->Js->writeBuffer(); ?>