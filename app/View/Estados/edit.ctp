<h1>Estados > Editar estado</h1>
<?php 
echo $this->Form->create('Estado');
echo $this->Form->input('paise_id', array ('type' => 'select','options' => $paises, 'label' => 'País'));
echo $this->Form->input('sigla');
echo $this->Form->input('nome');
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Salvar');
?>