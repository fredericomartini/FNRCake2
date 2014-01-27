<?php 
    echo $this->Html->script('jquery');
    $this->Paginator->options(array(
        'update' => '#content',
        'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
        'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
    ));
?>

<h1>Fórmulas de disputa dos campeonatos</h1>

<?php 
    echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('action' => 'add'), array('escape' => false) );
?>

<table>
    
    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        'Campeonato',
        'Fórmula',
        'Ano',
        'Ação',
    ));
    echo $tableHeaders;
    
    $rows = array();
    
    foreach ($campeonatos as $item):
        $rows[] = array(
            $item['Campformula']['id'],
            $this->Html->link($item['Campeonato']['nome_reduzido'], array('action' => 'view', $item['Campformula']['id'])),
            $this->Html->link($item['Formula']['nome'], array('action' => 'view', $item['Campformula']['id'])),
            $this->Html->link($item['Campformula']['ano'], array('action' => 'view', $item['Campformula']['id'])),
            $this->Form->postLink('Apagar',array('action' => 'delete', $item['Campformula']['id']),array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;
    
    echo $this->Html->tableCells($rows);
    
    
    ?>
    

</table>



    <?php unset($grupo); ?>

<?php
    if ($this->Paginator->counter('{:pages}') > 1) {
        echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
    }
?>


<?php echo $this->Js->writeBuffer(); ?>
