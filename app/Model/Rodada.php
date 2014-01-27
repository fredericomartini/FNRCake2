<?php

class Rodada extends AppModel {
    
    var $belongsTo = array(
        'Grupo' => array(
            'className' => 'Grupo'			
        )
    );
    
    public $hasMany = array(
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
        'grupo_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'required'   => true,
        )
    );
    
}

?>
