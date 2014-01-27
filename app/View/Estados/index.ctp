<h1>Estados</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'estados', 'action' => 'add'), array('escape' => false) );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>

    <?php foreach ($estados as $estado): ?>
    <tr>
        <td><?php echo $estado['Estado']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($estado['Estado']['nome'], array('controller' => 'estados', 'action' => 'view', $estado['Estado']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $estado['Estado']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $estado['Estado']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($estado); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>