<?php
App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    
    var $belongsTo = array(
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'id'			
        )
    );
    
    public $actsAs = array('Acl' => array('type' => 'requester'));
    
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Este campo não pode ser vazio.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Este campo não pode ser vazio.'
            )
        ),
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        ),
        'sobrenome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        ),
        'email' => array(
            'notEmpty' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'Este campo não pode ser vazio.',
                'last' => false
            ),
            'valido' => array(
                'rule'    => array('email', true),
                'message' => 'Informe um e-mail válido.'
            ),
        ),
    );
    
}
?>
