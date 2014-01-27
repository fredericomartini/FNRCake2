<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Fases dos campeonatos</h1>

<?php
echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'fases', 'action' => 'add'), array('escape' => false));
?>

<div id="lobao">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Fórmula --'));
    echo $this->Html->image("sep_2.png");
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>

</div>

<table>

    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('nome', 'Fórmula', array('escape' => false)),
        $this->Paginator->sort('nome', 'Fase'),
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($fases as $fase):
        $rows[] = array(
            $fase['Fase']['id'],
            $this->Html->link($fase['Formula']['nome'], array('action' => 'view', $fase['Fase']['id'])),
            $this->Html->link($fase['Fase']['nome'], array('action' => 'view', $fase['Fase']['id'])),
            $this->Html->link('Editar', array('action' => 'edit', $fase['Fase']['id'])) . " " .
            $this->Form->postLink('Apagar', array('action' => 'delete', $fase['Fase']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>



<?php unset($fase); ?>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}
?>


<?php echo $this->Js->writeBuffer(); ?>