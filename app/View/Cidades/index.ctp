<h1>Cidades</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'cidades', 'action' => 'add'), array('escape' => false) );
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>

    <?php foreach ($cidades as $cidade): ?>
    <tr>
        <td><?php echo $cidade['Cidade']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($cidade['Cidade']['nome'], array('controller' => 'cidades', 'action' => 'view', $cidade['Cidade']['id'])); ?>
        </td>
        <td>
            <?php echo $this->Html->link('Editar', array('action' => 'edit', $cidade['Cidade']['id'])); ?>
            <?php echo $this->Form->postLink(
                'Apagar',
                array('action' => 'delete', $cidade['Cidade']['id']),
                array('confirm' => 'Você realmete deseja apagar esse item?'));
            ?>
        </td>
    </tr>

    <?php endforeach; ?>

</table>

    <?php unset($cidade); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>