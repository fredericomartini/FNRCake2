<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Participantes dos campeonatos</h1>

<?php echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('action' => 'add'), array('escape' => false)); ?>

<div id="lobao">
    <?php
    echo $this->Search->create('Campformclube');
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Campeonato --'));
    echo $this->Html->image("sep_2.png");
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>

</div>

<table>

    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        'Campeonato',
        'Clube',
        'Ano',
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($clubes as $item):
        $rows[] = array(
            $item['Campformclube']['id'],
            $this->Html->link($item['Campeonato']['nome_reduzido'], array('action' => 'view', $item['Campformclube']['id'])),
            $this->Html->link($item['Clube']['nome_reduzido'], array('action' => 'view', $item['Campformclube']['id'])),
            $this->Html->link($item['Campformclube']['ano'], array('action' => 'view', $item['Campformclube']['id'])),
            $this->Form->postLink('Retirar do campeonato', array('action' => 'delete', $item['Campformclube']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>



<?php unset($clubes); ?>

<p>
<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "&nbsp; | " . $this->Paginator->numbers() . " |";
}
?>
</p>

