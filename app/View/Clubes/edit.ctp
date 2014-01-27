<h1>Clubes > Editar clube</h1>
<?php
    echo $this->Form->create('Clube', array('type' => 'file'));
    echo $this->Form->input('nome_completo', array('label' => 'Nome completo'));
    echo $this->Form->input('nome_reduzido', array('label' => 'Nome reduzido'));
    echo $this->Form->input('estadio', array('label' => 'Estádio'));
    echo $this->Form->input('simbolo', array('type' => 'file','class' => 'file','label' => 'Símbolo (51x51)'));
    echo $this->Form->input('simbolo_pq', array('type' => 'file','class' => 'file','label' => 'Símbolo (19x19)'));
    echo $this->Form->input('superior', array('type' => 'file','class' => 'file','label' => 'Imagem superior (776x93)'));
    echo $this->Form->input('img_simbolo_pq', array('type' => 'hidden'));
    echo $this->Form->input('img_simbolo', array('type' => 'hidden'));
    echo $this->Form->input('img_superior', array('type' => 'hidden'));
    echo $this->Form->input('cidade_id', array('type' => 'hidden'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Salvar');
?>
