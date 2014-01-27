<h1>Jogos > Atualizar jogo</h1>
<?php echo $this->Form->create('Jogo'); ?>
<div class="input text">
    <label for="teste"><?php echo $jogo['Campeonato']['nome_reduzido']; ?></label>
    <br>
    <label for="teste"><?php echo $jogo['Formula']['nome'] . " > " . $jogo['Fase']['nome'] . " > " . $jogo['Grupo']['nome']; ?></label>
    <br>
    <?php echo $this->Html->image("clubes/simbolos/" . $this->request->data['Clube01']['img_simbolo'], array("title" => $this->request->data['Clube01']['nome_reduzido'])); ?>
    <?php echo $this->Html->image("vs2.png", array("title" => "vs")); ?>
    <?php echo $this->Html->image("clubes/simbolos/" . $this->request->data['Clube02']['img_simbolo'], array("title" => $this->request->data['Clube02']['nome_reduzido'])); ?>
</div>
<?php
echo $this->Form->input('estadio', array ('id' => 'estadioClube', 'label' => 'Local'));
echo $this->Form->input('rodada_id', array ('id' => 'rodadaID', 'type' => 'select','options' => $rodadas, 'label' => 'Rodada', 'empty' => ''));

$datajogo = date('d/m/Y', strtotime($this->request->data['Jogo']['datahora']));
$horajogo = date('H', strtotime($this->request->data['Jogo']['datahora']));
$minutojogo = date('i', strtotime($this->request->data['Jogo']['datahora']));
?>

<div class="input text">
    <label for="datepicker">Data / Hora</label>
    <input name="datajogo" type="text" class="datepicker" id="datepicker" title="Informe a data" value="<?php echo $datajogo; ?>">
    <select name="horas" id="horas" class="campohora" title="Informe a hora">
        <option value="<?php echo $horajogo; ?>"><?php echo $horajogo; ?></option>
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
        <option value="<?php echo $minutojogo; ?>"><?php echo $minutojogo; ?></option>
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
echo $this->Form->input('placaraovivo', array ('id' => 'placaraovivo', 'type' => 'select','options' => $opcoes, 'label' => 'Transmissão ao vivo no placar', 'empty' => ''));

echo $this->Form->input('campeonato_id', array('type' => 'hidden'));
echo $this->Form->input('ano', array('type' => 'hidden'));
echo $this->Form->input('formula_id', array('type' => 'hidden'));
echo $this->Form->input('fase_id', array('type' => 'hidden'));
echo $this->Form->input('grupo_id', array('type' => 'hidden'));
echo $this->Form->input('clube_id_01', array('type' => 'hidden'));
echo $this->Form->input('clube_id_02', array('type' => 'hidden'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Atualizar');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#estadioClube').focus();
        
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