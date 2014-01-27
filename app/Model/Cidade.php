<?php

class Cidade extends AppModel {

    var $belongsTo = array(
        'Estado' => array(
            'className' => 'Estado'	
        )
    );
    
    public $hasMany = array(
        'Clube' => array(
            'className' => 'Clube'		
        )
    );
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        ),
        'estado_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
            
        )
    );
    
}
?>
