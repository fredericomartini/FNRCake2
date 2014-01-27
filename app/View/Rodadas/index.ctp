<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Rodadas dos campeonatos</h1>

<?php
echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'rodadas', 'action' => 'add'), array('escape' => false));
?>

<div id="lobao">
    <?php
    echo $this->Search->create('Rodada');
    ?>
    <select name="data[filter][filter1]" class="select-box" id="filterFilter1">
        <option value="">-- Fórmula --</option>
        <?php
        foreach($formulas as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
        ?>
    </select>
    <?php
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
        $this->Paginator->sort('nome', 'Grupo', array('escape' => false)),
        $this->Paginator->sort('nome', 'Rodada'),
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($rodadas as $item):
        $rows[] = array(
            $item['Rodada']['id'],
            $this->Html->link($item['Grupo']['nome'], array('action' => 'view', $item['Rodada']['id'])),
            $this->Html->link($item['Rodada']['nome'], array('action' => 'view', $item['Rodada']['id'])),
            $this->Html->link('Editar', array('action' => 'edit', $item['Rodada']['id'])) . " " .
            $this->Form->postLink('Apagar', array('action' => 'delete', $item['Rodada']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>



<?php unset($item); ?>

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