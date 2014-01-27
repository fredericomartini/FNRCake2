<?php
class Situacao extends AppModel {
    
    public $validate = array(
        'nome' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'flgsituacao' => array(
            'notEmpty' => array(
                'rule'     => 'notEmpty',
                'required' => true,
                'message'  => 'Este campo não pode ser vazio.',
                'last' => false
            ),
            'tamanho' => array(
                'rule'    => array('maxLength', '1'),
                'message' => 'Este campo deve possuir 1 caracter.'
            )
        ),
    );  
}
?>