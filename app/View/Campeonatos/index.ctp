<h1>Campeonatos</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'campeonatos', 'action' => 'add'), array('escape' => false) );

    echo $data = date("Y");
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>
    
    <!-- Here is where we loop through our $menus array, printing out menu info -->

    <?php foreach ($campeonatos as $campeonato): ?>
    <tr>
        <td><?php echo $campeonato['Campeonato']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($campeonato['Campeonato']['nome_completo'], array('controller' => 'campeonatos', 'action' => 'view', $campeonato['Campeonato']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $campeonato['Campeonato']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $campeonato['Campeonato']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($campeonato); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>