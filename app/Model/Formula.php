<?php
class Formula extends AppModel {
    
    public $hasMany = array(
        'Fase' => array(
            'className' => 'Fase'		
        ),
        'Campformula' => array(
            'className' => 'Campformula'		
        ),
        'Campformclube' => array(
            'className' => 'Campformclube'		
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
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'numclubes' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
    );  
}
?>