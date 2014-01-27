<h1>Situações dos jogos</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'situacaos', 'action' => 'add'), array('escape' => false) );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>
    
    <!-- Here is where we loop through our $menus array, printing out menu info -->

    <?php foreach ($situacaos as $situacao): ?>
    <tr>
        <td><?php echo $situacao['Situacao']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($situacao['Situacao']['nome'], array('controller' => 'situacaos', 'action' => 'view', $situacao['Situacao']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $situacao['Situacao']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $situacao['Situacao']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($situacao); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>