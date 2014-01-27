<?php
class Campeonato extends AppModel {
    
    var $belongsTo = array(
        'Divisao' => array(
            'className' => 'Divisao'		
        ),
        'Nivei' => array(
            'className' => 'Nivei'			
        ),
        'Paise' => array(
            'className' => 'Paise'			
        ),
        'Estado' => array(
            'className' => 'Estado'			
        ),
    );
    
    public $hasMany = array(
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
        'nome_completo' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'nome_reduzido' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'nivei_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
            
        ),
        'superior' => array(
            'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
            'message' => 'Informe uma imagem válida (gif, jpeg, jpg, png).'
        )
    );  
}
?>
