<?php

class Grupoclube extends AppModel {
    
    var $belongsTo = array(
        'Campeonato' => array(
            'className' => 'Campeonato'		
        ),
        'Formula' => array(
            'className' => 'Formula'			
        ),
        'Clube' => array(
            'className' => 'Clube'			
        ),
        'Fase' => array(
            'className' => 'Fase'			
        ),
        'Grupo' => array(
            'className' => 'Grupo'			
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
            
        ),
        'clube_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'fase_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'grupo_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        )
    );
    
}

?>
