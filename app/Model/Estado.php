<?php

class Estado extends AppModel {
    
    var $belongsTo = array(
        'Paise' => array(
            'className' => 'Paise'			
        )
    );
    
    public $hasMany = array(
        'Cidade' => array(
            'className' => 'Cidade'		
        ),
        'Campeonato' => array(
            'className' => 'Campeonato'			
        )
    );
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['sigla'])) {
            $this->data[$this->alias]['sigla'] = strtoupper($this->data[$this->alias]['sigla']);
        }
        return true;
    }
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.'
        ),
        'paise_id' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.'
        ),
        'sigla' => array(
            'notEmpty' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'Este campo não pode ser vazio.'
            ),
            'tamanho' => array(
                'rule'    => array('minLength', '2'),
                'message' => 'Este campo deve possuir 2 caracteres.'
            )
        ),
    );
    
    

}
?>
