<h1>Campeonatos > Editar campeonato</h1>
<?php
    echo $this->Form->create('Campeonato', array('type' => 'file'));
    echo $this->Form->input('nome_completo', array('label' => 'Nome completo'));
    echo $this->Form->input('nome_reduzido', array('label' => 'Nome reduzido'));
    echo $this->Form->input('superior', array('type' => 'file','class' => 'file','label' => 'Imagem superior (776x93)'));
    echo $this->Form->input('img_superior', array('type' => 'hidden'));
    echo $this->Form->input('divisao_id', array('type' => 'hidden'));
    echo $this->Form->input('nivei_id', array('type' => 'hidden'));
    echo $this->Form->input('paise_id', array('type' => 'hidden'));
    echo $this->Form->input('estado_id', array('type' => 'hidden'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Salvar');
?>
