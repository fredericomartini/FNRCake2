<?php

class Group extends AppModel {
    
    public $hasMany = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'group_id',
            'dependent' => false			
        )
    );
    
    public $hasAndBelongsToMany = array(
        'Menu' =>
            array(
                'className'             => 'Menu',
                'joinTable'             => 'group_menus',
                'foreignKey'            => 'group_id',
                'associationForeignKey' => 'menu_id',
                'order'                 => 'Menu.menu, Menu.ordem',
            )
    );
    
    public $actsAs = array('Acl' => array('type' => 'requester'));

    public function parentNode() {
        return null;
    }
    
    public $validate = array(
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.'
        )
    );
    
}

?>
