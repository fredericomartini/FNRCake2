<h1>Fórmulas</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'formulas', 'action' => 'add'), array('escape' => false) );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>
    
    <!-- Here is where we loop through our $menus array, printing out menu info -->

    <?php foreach ($formulas as $formula): ?>
    <tr>
        <td><?php echo $formula['Formula']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($formula['Formula']['nome'], array('controller' => 'formulas', 'action' => 'view', $formula['Formula']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $formula['Formula']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $formula['Formula']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($formula); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>