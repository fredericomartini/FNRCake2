<?php

class Campformula extends AppModel {
    
    var $belongsTo = array(
        'Campeonato' => array(
            'className' => 'Campeonato'		
        ),
        'Formula' => array(
            'className' => 'Formula'			
        ),
    );
    
    public $validate = array(
        'campeonato_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'formula_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'ano' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
            
        )
    );
}

?>
