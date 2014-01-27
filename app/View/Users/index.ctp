<h1>Usuários do sistema</h1>

<?php echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'users', 'action' => 'add'), array('escape' => false)); ?>

<div id="lobao">
    <?php
    echo $this->Search->create();
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Grupo --'));
    echo $this->Html->image("sep_2.png");
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>
</div>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>

    <!-- Here is where we loop through our $menus array, printing out menu info -->

<?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['User']['id']; ?></td>
            <td>
    <?php echo $this->Html->link($user['User']['nome'], array('controller' => 'users', 'action' => 'view', $user['User']['id'])); ?>
            </td>
            <td>
    <?php echo $this->Html->link('Editar', array('action' => 'edit', $user['User']['id'])); ?>
                <?php
                echo $this->Form->postLink(
                        'Apagar', array('action' => 'delete', $user['User']['id']), array('confirm' => 'Você realmete deseja apagar esse item?'));
                ?>
            </td>
        </tr>

<?php endforeach; ?>

</table>

<?php unset($user); ?>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}
?>
