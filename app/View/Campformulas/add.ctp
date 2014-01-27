<h1>Fórmulas de disputa dos campeonatos > Fórmula <?php echo date("Y"); ?></h1>

<?php
echo $this->Form->create('Campformula');
echo $this->Form->input('campeonato_id', array ('id' => 'campeonatoID', 'type' => 'select','options' => $campeonatos, 'label' => 'Campeonato', 'empty' => ''));
echo $this->Form->input('formula_id', array ('id' => 'formulaID', 'type' => 'select','options' => $formulas, 'label' => 'Fórmula', 'empty' => ''));
echo $this->Form->input('ano', array('type' => 'hidden', 'value' => date("Y")));
echo $this->Form->end('Salvar');
?>

<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#campeonatoID').focus();
    });
</script>

<?php echo $this->Js->writeBuffer(); ?>