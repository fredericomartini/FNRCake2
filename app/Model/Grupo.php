<?php

class Grupo extends AppModel {
    
    var $belongsTo = array(
        'Fase' => array(
            'className' => 'Fase'			
        )
    );
    
    public $hasMany = array(
        'Rodada' => array(
            'Rodada' => 'Grupo'		
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
        'classificacao' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        ),
        'fase_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        )
    );
    
}

?>