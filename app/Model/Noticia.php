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
   
   	/*
   	 * ANTES DE SALVAR ADICIONA SLUG A NOTICIA
   	 * PEGA O TITULO E FORMATA NO PADRAO:
   	 * texto-em-minusculo-separdo-por-hifen
   	 */
	public function beforeSave($options = array() ) {
        //add slug
        if (isset($this->data[$this->alias]['titulo'])) {
			//add slug
			$slug = Inflector::slug($this->data[$this->alias]['titulo']); // retira acentos e etc
			$slug = strtolower($slug); // passa pra minusculo
			$slug = str_replace("_", "-", $slug); // troca _ por -

            $this->data[$this->alias]['slug'] = $slug;
        }
		//valida titulo p/ se ja existe dar erro
		if(isset($this->data[$this->alias]['titulo'] ) ){
			//debug(find);
			//$noticia  = Noticia->find('first',array( 'conditions' => array('Noticia.slug' => $this->data[$this->alias]['slug'] ) ) );
			//if($noticia)
			//	$this->Session->setFlash('Já existe notícia com este título!', 'default', array('class' => 'mensagem_erro'));
				//throw new NotFoundException(__('Noticia Inválida!'));
		}        
        
       return true;
    }	

		
	public $validate = array(
							'titulo' => array(
										'rule' => 'notEmpty',
										'message' => 'O campo não pode ser vazio!' ),
										
							'corpo' => array(
										'rule' => 'notEmpty',
										'message' => 'O campo não pode ser vazio!' ),
										
			  			    'imagemUpload' => array(
			        					'rule'    => array('extension', array('gif', 'jpeg', 'png', 'jpg')),
			        					'message' => 'Informe uma imagem válida (gif, jpeg, jpg, png.)' ),
			        					
			        		'img_url' => array(
			        					'rule' =>   array('extension', array('gif', 'jpeg', 'png', 'jpg')),
			        					'message' => 'Informe um link válido c/ terminação (gif, jpeg, jpg, png.)'),
			        					
							'cidade_id' => array(
											'rule' => 'notEmpty',
											'required' => true,
											'message' => 'Selecionar uma cidade, campo obrigatório' ),
											
							'clube_id'  => array(
											'rule' => 'notEmpty',
											'required' => true,
					 						'message' => 'Selecionar um time, campo obrigatório' )
					    	);
								
}
 ?>
