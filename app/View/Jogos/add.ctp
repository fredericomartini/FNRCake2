<h1>Jogos > Cadastrar jogo</h1>

<?php
echo $this->Form->create('Jogo');

echo $this->Form->input('campeonato_id', array ('id' => 'campeonatoID', 'type' => 'select','options' => $campeonatos, 'label' => 'Campeonato', 'empty' => ''));
echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select', 'label' => 'Fórmula', 'empty' => ''));
echo $this->Form->input('fase_id', array ('id' => 'faseID', 'type' => 'select', 'label' => 'Fase', 'empty' => ''));
echo $this->Form->input('grupo_id', array ('id' => 'grupoID', 'type' => 'select', 'label' => 'Grupo', 'empty' => ''));
echo $this->Form->input('rodada_id', array ('id' => 'rodadaID', 'type' => 'select', 'label' => 'Rodada', 'empty' => ''));
echo $this->Form->input('clube_id_01', array ('id' => 'clubeMID', 'type' => 'select', 'label' => 'Clube mandante', 'empty' => ''));
echo $this->Form->input('estadio', array ('id' => 'estadioClube', 'label' => 'Local'));
?>

<div class="input text">
    <label for="datepicker">Data / Hora</label>
    <input name="datajogo" type="text" class="datepicker" id="datepicker" title="Informe a data" maxlenght="10">
    <select name="horas" id="horas" class="campohora" title="Informe a hora">
        <option value=""></option>
        <?php
        for($i=23; $i>=0; $i--) {
            if ($i < 10) {
                ?><option value="0<?php echo $i; ?>">0<?php echo $i; ?></option><?php
            } else {
                ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
            }
        }
        ?>
    </select>
    <select name="minutos" id="minutos" class="campohora" title="Informe os minutos">
        <option value=""></option>
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
    </select>
</div>
<?php
echo $this->Form->input('clube_id_02', array ('id' => 'clubeVID', 'type' => 'select', 'label' => 'Clube visitante', 'empty' => ''));
echo $this->Form->input('placaraovivo', array ('id' => 'placaraovivo', 'type' => 'select','options' => $opcoes, 'label' => 'Transmissão ao vivo no placar', 'empty' => ''));
echo $this->Form->input('datahora', array('type' => 'hidden'));
echo $this->Form->input('penaltis', array('type' => 'hidden', 'value' => 'N'));
echo $this->Form->input('ano', array('type' => 'hidden', 'value' => date("Y")));
echo $this->Form->end('Salvar');

$this->Js->get('#campeonatoID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'campformulas', 'action' => 'buscaFormula', 'Jogo', date("Y")),
        array(  'update' => '#formulaID',
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

$this->Js->get('#formulaID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'fases', 'action' => 'buscaFases', 'Jogo', 'formula_id'),
        array(  'update' => '#faseID',
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

$this->Js->get('#faseID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'grupos', 'action' => 'buscaGrupos', 'Jogo'),
        array(  'update' => '#grupoID',
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

$this->Js->get('#grupoID')->event(
    'change',
    $this->Js->request(
        array('controller' => 'rodadas', 'action' => 'buscaRodadas', 'Jogo'),
        array(  'update' => '#rodadaID',
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
    jQuery(document).ready(function(){
        
        $('#campeonatoID').focus();
        
        $("#clubeMID").change( function(){
            $.ajax({async:true, 
                    data:$("#clubeMID").serialize(), 
                    dataType:"html",
                    success:function (data, textStatus) {
                        $("#estadioClube").val(data);}, 
                        type:"post", 
                        url:"\/FNRCake\/clubes\/buscaEstadio\/Jogo"}
            );
        });
        
        $("#grupoID").change( function(){
            $.ajax({async:true, 
                    data:$("#grupoID").serialize(), 
                    dataType:"html", 
                    success:function (data, textStatus) {
                        $("#clubeMID").html(data);
                    }, 
                    type:"post", 
                    url:"\/FNRCake\/clubes\/buscaClubesJogos\/Jogo\/2014\/" + $("#campeonatoID option:selected").val()
            });
        });
        
        $("#grupoID").change( function(){
            $.ajax({async:true, 
                    data:$("#grupoID").serialize(), 
                    dataType:"html", 
                    success:function (data, textStatus) {
                        $("#clubeVID").html(data);
                    }, 
                    type:"post", 
                    url:"\/FNRCake\/clubes\/buscaClubesJogos\/Jogo\/2014\/" + $("#campeonatoID option:selected").val()
            });
        });
        
        $("#datepicker").mask("99/99/9999");
        
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
            monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            nextText: 'Próximo',
            prevText: 'Anterior'
        });
    });
</script>

<?php echo $this->Js->writeBuffer(); ?>