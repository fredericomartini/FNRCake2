<h1>Menus do sistema > Novo menu</h1>
<?php
    echo $this->Html->script('jquery');

    echo $this->Form->create('Menu');
    echo $this->Form->input('nome');
    echo $this->Form->input('controller');
    echo $this->Form->input('mostramenu', array ('id' => 'mostraMenu', 'type' => 'select','options' => $opcoes, 'label' => 'Mostra menu', 'empty' => ''));
    echo $this->Form->input('menu', array ('id' => 'itemMenu'));
    echo $this->Form->input('ordem', array ('id' => 'itemOrdem'));
    echo $this->Form->end('Salvar');
?>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $("#itemMenu").attr('disabled','disabled');
        $("#itemOrdem").attr('disabled','disabled');
        $("#mostraMenu").change( function(){
            var itemSelecionado = $("#mostraMenu option:selected").val();
            if(itemSelecionado == 1){
                $("#itemMenu").attr('disabled',false);
                $("#itemOrdem").attr('disabled',false);
            } else if (itemSelecionado == 2) {
                $("#itemMenu").attr('disabled','disabled');
                document.getElementById('itemMenu').value = '';
                $("#itemOrdem").attr('disabled','disabled');
                document.getElementById('itemOrdem').value = '';
            }
	});
    });
    
</script>