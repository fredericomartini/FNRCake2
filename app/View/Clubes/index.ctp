<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Clubes</h1>

<?php
echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('controller' => 'clubes', 'action' => 'add'), array('escape' => false));
?>

<table>
    <tr>
        <th>Id</th>
        <th>Descrição</th>
        <th>Ação</th>
    </tr>


    <?php foreach ($clubes as $clube): ?>
        <tr>
            <td><?php echo $clube['Clube']['id']; ?></td>
            <td>
                <?php echo $this->Html->link($clube['Clube']['nome_reduzido'], array('controller' => 'clubes', 'action' => 'view', $clube['Clube']['id'])); ?>
            </td>
            <td>
                <?php echo $this->Html->link('Editar', array('action' => 'edit', $clube['Clube']['id'])); ?>
                <?php
                echo $this->Form->postLink(
                        'Apagar', array('action' => 'delete', $clube['Clube']['id']), array('confirm' => 'Você realmete deseja apagar esse item?'));
                ?>
            </td>
        </tr>

    <?php endforeach; ?>

</table>

<?php unset($clube); ?>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}
?>

<?php echo $this->Js->writeBuffer(); ?>