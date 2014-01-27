<?php

class Jogo extends AppModel {
    
    var $belongsTo = array(
        'Campeonato' => array(
            'className' => 'Campeonato'		
        ),
        'Formula' => array(
            'className' => 'Formula'			
        ),
        'Fase' => array(
            'className' => 'Fase'			
        ),
        'Grupo' => array(
            'className' => 'Grupo'			
        ),
        'Rodada' => array(
            'className' => 'Rodada'			
        ),
        'Clube01' => array(
            'className' => 'Clube',
            'foreignKey'   => 'clube_id_01'
        ),
        'Clube02' => array(
            'className' => 'Clube',
            'foreignKey'   => 'clube_id_02'
        ),
    );
    
    public $validate = array(
        'campeonato_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'formula_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.'
        ),
        'ano' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
            
        ),
        'fase_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'grupo_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'rodada_id' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'clube_id_01' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'clube_id_02' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
        'placaraovivo' => array(
            'rule' => 'notEmpty',
            'required'   => true,
            'message' => 'Este campo não pode ser vazio.',
        ),
    );
    
//    public function beforeSave($dados) {
//        foreach ($dados as $key => $value) {
//            if (!empty($value["Jogo"]["datahora"])) {
//                $dados[$key]["Jogo"]["datahora"] = $this->formataDataAmericana($value["Jogo"]["datahora"]);
//            }
//        }
//        return $dados;
//    }
//    
//    public function afterFind($dados) {
//        foreach ($dados as $key => $value) {
//            if (!empty($value["Jogo"]["datahora"])) {
//                $dados[$key]["Jogo"]["datahora"] = $this->formataDataBrasil($value["Jogo"]["datahora"]);
//            }
//        }
//        return $dados;
//    }
    
}

?>
