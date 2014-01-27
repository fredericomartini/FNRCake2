<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Menus do sistema</h1>

<?php
echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('action' => 'add'), array('escape' => false));
?>

<div id="lobao">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Categoria --'));
    echo $this->Html->image("sep_2.png");
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>
</div>

<table>

    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('nome'),
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($menus as $menu):
        $rows[] = array(
            $menu['Menu']['id'],
            $this->Html->link($menu['Menu']['nome'], array('controller' => 'menus', 'action' => 'view', $menu['Menu']['id'])),
            $this->Html->link('Editar', array('action' => 'edit', $menu['Menu']['id'])) . " " .
            $this->Form->postLink('Apagar', array('action' => 'delete', $menu['Menu']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>



<?php unset($menu); ?>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}
?>


<?php echo $this->Js->writeBuffer(); ?>