<?php
class Clube extends AppModel {
    
    var $belongsTo = array(
        'Cidade' => array(
            'className' => 'Cidade'			
        )
    );
    
    public $hasMany = array(
        'Campformclube' => array(
            'className' => 'Campformclube'		
        ),
        'Grupoclube' => array(
            'className' => 'Grupoclube'		
        ),
        'Jogo01' => array(
            'className' => 'Jogo'		
        ),
        'Jogo02' => array(
            'className' => 'Jogo'		
        ),
    );
    
    public $validate = array(
        'nome_completo' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        ),
        'nome_reduzido' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        ),
        'estadio' => array(
            'rule' => 'notEmpty',
            'message' => 'Este campo não pode ser vazio.',
            'last' => false
        ),
        'cidade_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
            
        ),
        'simbolo' => array(
            'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
            'message' => 'Informe uma imagem válida (gif, jpeg, jpg, png).'
        ),
        'simbolo_pq' => array(
            'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
            'message' => 'Informe uma imagem válida (gif, jpeg, jpg, png).'
        ),
        'superior' => array(
            'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
            'message' => 'Informe uma imagem válida (gif, jpeg, jpg, png).'
        )
    );
    
}
?>
