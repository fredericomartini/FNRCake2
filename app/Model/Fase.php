<?php

class Fase extends AppModel {
    
    var $belongsTo = array(
        'Formula' => array(
            'className' => 'Formula'			
        )
    );
    
    public $hasMany = array(
        'Grupo' => array(
            'className' => 'Grupo'		
        ),
        'Grupoclube' => array(
            'className' => 'Grupoclube'		
        ),
        'Jogo' => array(
            'className' => 'Jogo'		
        ),
    );
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        ),
        'ordem' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        ),
        'classificacaogeral' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        ),
        'jogosentregrupos' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        ),
        'formula_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        )
    );
    
}

?>
