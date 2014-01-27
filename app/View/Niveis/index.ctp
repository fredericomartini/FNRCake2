<h1>Níveis dos campeonatos</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'niveis', 'action' => 'add'), array('escape' => false) );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>
    
    <!-- Here is where we loop through our $menus array, printing out menu info -->

    <?php foreach ($niveis as $nivei): ?>
    <tr>
        <td><?php echo $nivei['Nivei']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($nivei['Nivei']['nome'], array('controller' => 'niveis', 'action' => 'view', $nivei['Nivei']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $nivei['Nivei']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $nivei['Nivei']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($nivei); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>