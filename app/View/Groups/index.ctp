<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Grupos do sistema</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'groups', 'action' => 'add'), array('escape' => false) );
?>

<table>
    
    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('name'),
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();

    foreach ($groups as $group):
        $rows[] = array(
            $group['Group']['id'],
            $this->Html->link($group['Group']['name'], array('controller' => 'menus', 'action' => 'view', $group['Group']['id'])),
            $this->Html->link('Editar', array('action' => 'edit', $group['Group']['id'])) . " " .
            $this->Form->postLink('Apagar', array('action' => 'delete', $group['Group']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>
    
    

</table>

    <?php unset($group); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>