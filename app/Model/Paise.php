<?php
class Paise extends AppModel {
    
    public $hasMany = array(
        'Estado' => array(
            'className' => 'Estado'		
        ),
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
