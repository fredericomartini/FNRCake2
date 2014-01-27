<?php
class Nivei extends AppModel {
    
    public $hasMany = array(
        'Campeonatos' => array(
            'className' => 'Campeonato'		
        )
    );
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        )
    );
    
}
?>
