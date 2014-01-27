<?php

class Menu extends AppModel {
    
    var $name = 'Menu';
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        )
    );
    
}
?>
