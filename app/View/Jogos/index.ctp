<?php
$this->Paginator->options(array(
    'update' => '#content',
    'before' => $this->Js->get('#loader')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#loader')->effect('fadeOut', array('buffer' => false)),
));
?>

<h1>Jogos</h1>

<?php echo $this->Html->link($this->Html->image("adicionar.png", array("title" => "Adicionar novo")), array('action' => 'add'), array('escape' => false)); ?>

<div id="lobao">
    <?php
    echo $this->Search->create('Jogo');
    echo $this->Search->input('filter1', array('class' => 'select-box', 'empty' => '-- Campeonato --'));
    echo $this->Html->image("sep_2.png");
    echo $this->Search->input('filter2', array('class' => 'select-box'));
    echo $this->Html->image("sep_2.png");
    echo $this->Search->input('filter3', array('class' => 'select-box'));
    echo $this->Html->image("sep_2.png");
    echo $this->Search->input('filter4', array('class' => 'select-box'));
    echo $this->Html->image("sep_2.png");
//    echo $this->Search->input('filter5');
    
    ?>
    <input  type="submit" value="Filtrar" class="outroteste"/>
</div>

<form action="/FNRCake/Jogos/delete/1230920390239" name="post_69348294s3efsfd989" id="post_69348294s3efsfd989" style="display:none;" method="post">
    <input type="hidden" name="_method" value="POST"/>
</form>
<a href="#" onclick="if (confirm('Você realmete deseja apagar esse item?')) { document.post_69348294s3efsfd989.submit(); } event.returnValue = false; return false;">
</a>

<table>
    
    <?php
    $tableHeaders = $this->Html->tableHeaders(array(
        $this->Paginator->sort('id'),
        $this->Paginator->sort('Campeonato.nome_reduzido', 'Campeonato'),
        $this->Paginator->sort('Fase.nome', 'Fase'),
        $this->Paginator->sort('Rodada.nome', 'Rodada'),
        $this->Paginator->sort('Jogo.datahora', 'Data/Hora'),
        '',
        '',
        '',
        'Ação',
    ));
    echo $tableHeaders;

    $rows = array();
    
    foreach ($jogos as $item):
        $rows[] = array(
            $item['Jogo']['id'],
            $this->Html->link($item['Campeonato']['nome_reduzido'], array('action' => 'view', $item['Jogo']['id'])),
            $this->Html->link($item['Fase']['nome'], array('action' => 'view', $item['Jogo']['id'])),
            $this->Html->link($item['Rodada']['nome'], array('action' => 'view', $item['Jogo']['id'])),
            $this->Html->link(date('d/m/Y H:i', strtotime($item['Jogo']['datahora'])), array('action' => 'view', $item['Jogo']['id'])),
            array($this->Html->image("clubes/simbolos_pq/" . $item['Clube01']['img_simbolo_pq'], array("title" => $item['Clube01']['nome_reduzido'])), array('class' => 'mandante')),
            ' x ',
            $this->Html->image("clubes/simbolos_pq/" . $item['Clube02']['img_simbolo_pq'], array("title" => $item['Clube02']['nome_reduzido'])),
            $this->Html->link('Editar', array('action' => 'edit', $item['Jogo']['id'])) . " " .
            $this->Html->link('Resultado', array('action' => 'resultado', $item['Jogo']['id'])) . " " .
            //$this->Html->link('Excluir', array('action' => 'delete', $item['Jogo']['id']))
            $this->Form->postLink('Excluir', array('action' => 'delete', $item['Jogo']['id']), array('confirm' => 'Você realmete deseja apagar esse item?')),
        );
    endforeach;

    echo $this->Html->tableCells($rows);
    ?>


</table>

<?php
if ($this->Paginator->counter('{:pages}') > 1) {
    echo "<p> &nbsp; | " . $this->Paginator->numbers() . "| </p>";
}



$this->Js->get('#filterFilter1')->event(
    'change',
    $this->Js->request(
        array('controller' => 'jogos', 'action' => 'buscaFasesFiltro', 'filter', 'filter1'),
        array(  'update' => '#filterFilter2',
                'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => true,
			'inline' => true
			)),
            )
    )
);

$this->Js->get('#filterFilter2')->event(
    'change',
    $this->Js->request(
        array('controller' => 'jogos', 'action' => 'buscaGruposFiltro', 'filter', 'filter2'),
        array(  'update' => '#filterFilter3',
                'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => true,
			'inline' => true
			)),
            )
    )
);

$this->Js->get('#filterFilter3')->event(
    'change',
    $this->Js->request(
        array('controller' => 'jogos', 'action' => 'buscaRodadasFiltro', 'filter', 'filter3'),
        array(  'update' => '#filterFilter4',
                'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		'data'=> $this->Js->serializeForm(array(
			'isForm' => true,
			'inline' => true
			)),
            )
    )
);

?>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $('#filterFilter1').focus();
//        $("#filterFilter2").attr('disabled','disabled');
//        $("#filterFilter1").change( function(){
//            $("#filterFilter2").attr('disabled',false);
//        });
    });
    
</script>


<?php echo $this->Js->writeBuffer(); ?>
