<?php 
	class Noticia extends  AppModel{
		
		public $name = 'Noticia';
		
    var $belongsTo = array(
        'Clube' => array(
            'className' => 'Clube'		
        ),
        'Cidade' => array(
            'className' => 'Cidade'			
        ),
    );			
		
		public $validate = array(
					'titulo' => array(
								'rule' => 'notEmpty',
								'message' => 'O campo não pode ser vazio!'
							),
					'corpo' => array(
								'rule' => 'notEmpty',
								'message' => 'O campo não pode ser vazio!'
							),
      			    'imagemUpload' => array(
            					'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
            					'message' => 'Informe uma imagem válida (gif, jpeg, jpg, png.)'),
            		'img_url' => array(
            					'rule' =>   array('extension', array('gif', 'jpeg', 'png', 'jpg')),
            					'message' => 'Informe um link válido c/ terminação (gif, jpeg, jpg, png.)'),
            					
					'cidade_id' => array(
									'rule' => 'notEmpty',
									'required' => true,
									'message' => 'Selecionar uma cidade, campo obrigatório'),
					'clube_id'  => array(
									'rule' => 'notEmpty',
									'required' => true,
									'message' => 'Selecionar um time, campo obrigatório')
							);
	}
 ?>
