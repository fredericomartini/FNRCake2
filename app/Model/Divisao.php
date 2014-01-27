<?php
class Divisao extends AppModel {
    
    public $hasMany = array(
        'Campeonatos' => array(
            'className' => 'Campeonato'		
        )
    );
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'divisao' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        )
    );
    
}
?>
