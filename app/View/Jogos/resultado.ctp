<h1>Jogos > Atualizar jogo</h1>
<?php
echo $this->Form->create('Jogo');
//debug($jogo);
?>
<div class="input text">
    <label for="golsmandante"><?php echo $jogo['Campeonato']['nome_reduzido']; ?></label>
    <br>
    <label for="golsmandante"><?php echo $jogo['Formula']['nome'] . " > " . $jogo['Fase']['nome'] . " > " . $jogo['Grupo']['nome']; ?></label>
    <br>
    <label for="golsmandante"><?php echo date('d/m/Y H:i', strtotime($jogo['Jogo']['datahora'])); ?></label>
    <br>
    <label for="golsmandante">Resultado:</label>
    <br>
    <?php echo $this->Html->image("clubes/simbolos/" . $this->request->data['Clube01']['img_simbolo'], array("title" => $this->request->data['Clube01']['nome_reduzido'])); ?>
    &nbsp;&nbsp;&nbsp;
    <input name="golsmandante" type="number" class="campogols" id="golsmandante" title="Informe os gols do time mandante" value="<?php echo $this->request->data['Jogo']['gols_01']; ?>">
    <?php echo $this->Html->image("vs2.png", array("title" => "vs")); ?>
    <input name="golsvisitante" type="number" class="campogols" id="golsvisitante" title="Informe os gols do time visitante" value="<?php echo $this->request->data['Jogo']['gols_02']; ?>">
    &nbsp;&nbsp;&nbsp;
    <?php echo $this->Html->image("clubes/simbolos/" . $this->request->data['Clube02']['img_simbolo'], array("title" => $this->request->data['Clube02']['nome_reduzido'])); ?>
    <?php echo $this->Html->image("sep.png"); ?>
    <select name="situacao" id="situacao" class="camposituacao" title="Situação do jogo">
        <?php
        if ($this->request->data['Jogo']['situacaojogo'] == 0) {
            ?>
            <option value="0">NÃO INICIADO</option>
            <option value="5">JOGO ADIADO</option>
            <option value="4">ENCERRADO</option>
            <?php
        } elseif ($this->request->data['Jogo']['situacaojogo'] == 5) {
            ?>
            <option value="5">JOGO ADIADO</option>
            <option value="0">NÃO INICIADO</option>
            <option value="4">ENCERRADO</option>
            <?php
        } elseif ($this->request->data['Jogo']['situacaojogo'] == 4) {
            ?>
            <option value="4">ENCERRADO</option>
            <?php
        }
        ?>
    </select>
    <br><br><br>
    <?php
    if ($jogo['Jogo']['penaltis'] == "S") {
        ?><label for="golsmandante"><input type="checkbox" name="penaltis" id="penaltis" value="sim" checked>Decisão por pênaltis</label><?php
    } else if ($jogo['Grupo']['classificacao'] == 2) {
        ?><label for="golsmandante"><input type="checkbox" name="penaltis" id="penaltis" value="sim">Decisão por pênaltis</label><?php
    }
    ?>
    <br>
    <div id="mostrapenaltis">
        <label for="golsmandante">Pênaltis:</label>
        <br>
        <?php echo $this->Html->image("clubes/simbolos/" . $this->request->data['Clube01']['img_simbolo'], array("title" => $this->request->data['Clube01']['nome_reduzido'])); ?>
        &nbsp;&nbsp;&nbsp;
        <input name="penaltismandante" type="number" class="campogols" id="golsmandante" title="Informe os pênaltis convertidos do time mandante" value="<?php echo $this->request->data['Jogo']['gols_penaltis_01']; ?>">
        <?php echo $this->Html->image("vs2.png", array("title" => "vs")); ?>
        <input name="penaltisvisitante" type="number" class="campogols" id="golsvisitante" title="Informe os pênaltis convertidos do time visitante" value="<?php echo $this->request->data['Jogo']['gols_penaltis_02']; ?>">
        &nbsp;&nbsp;&nbsp;
        <?php echo $this->Html->image("clubes/simbolos/" . $this->request->data['Clube02']['img_simbolo'], array("title" => $this->request->data['Clube02']['nome_reduzido'])); ?>
    </div>
</div>



<?php

echo $this->Form->input('campeonato_id', array('type' => 'hidden'));
echo $this->Form->input('ano', array('type' => 'hidden'));
echo $this->Form->input('formula_id', array('type' => 'hidden'));
echo $this->Form->input('fase_id', array('type' => 'hidden'));
echo $this->Form->input('grupo_id', array('type' => 'hidden'));
echo $this->Form->input('rodada_id', array('type' => 'hidden'));
echo $this->Form->input('clube_id_01', array('type' => 'hidden'));
echo $this->Form->input('clube_id_02', array('type' => 'hidden'));
echo $this->Form->input('gols_01', array('type' => 'hidden'));
echo $this->Form->input('gols_02', array('type' => 'hidden'));
echo $this->Form->input('gols_penaltis_01', array('type' => 'hidden'));
echo $this->Form->input('gols_penaltis_02', array('type' => 'hidden'));
echo $this->Form->input('situacaojogo', array('type' => 'hidden'));
echo $this->Form->input('placaraovivo', array('type' => 'hidden'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Atualizar');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#golsmandante').focus();
        if ($("#penaltis").is(":checked")){
            $("#mostrapenaltis").show();
        } else {
            $("#mostrapenaltis").hide();
        }
        $("#penaltis").change( function(){
            if ($("#penaltis").is(":checked")){
                $("#mostrapenaltis").show();
            } else {
                $("#mostrapenaltis").hide();
            }
	});
    });
</script>