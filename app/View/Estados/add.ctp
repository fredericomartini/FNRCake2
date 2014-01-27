<h1>Estados > Novo estado</h1>
<?php 
echo $this->Form->create('Estado');
echo $this->Form->input('paise_id', array ('id' => 'paisID', 'type' => 'select','options' => $paises, 'label' => 'País', 'empty' => ''));
echo $this->Form->input('nome');
echo $this->Form->input('sigla');
echo $this->Form->end('Salvar');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#paisID').focus();
    });
</script>