<h1>Divisões</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'divisaos', 'action' => 'add'), array('escape' => false) );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>
    
    <!-- Here is where we loop through our $menus array, printing out menu info -->

    <?php foreach ($divisaos as $divisao): ?>
    <tr>
        <td><?php echo $divisao['Divisao']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($divisao['Divisao']['nome'], array('controller' => 'divisaos', 'action' => 'view', $divisao['Divisao']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $divisao['Divisao']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $divisao['Divisao']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($divisao); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>