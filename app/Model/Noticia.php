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
/* 
	public function beforeSave($options = array() ) {
        //add slug
        if (isset($this->data[$this->alias]['titulo'])) {
			//add slug

        }
      
        //validar p/ ver se ja nao tem outro igual 
        if(isset($this->data[$this->alias]['slug'])){
        	
			//se nao for definido o id.. registro novo
	    	if(! isset($this->data[$this->alias]['id'] ) ){
				//procura noticia por slug
				$noticia = $this->find('first',array( 'conditions' => array('Noticia.slug' => $this->data[$this->alias]['slug'] ) ) );
		    	if($noticia){
		    		return FALSE;
		    	}
	    	}
	    	//se id for definido. edicao verificar se ja existe algum slug com o informado
	    	else{
		    	if( (isset($this->data[$this->alias]['id'] ) )  && (isset($this->data[$this->alias]['slug'] ))){
					//procura noticia por slug
					$noticia = $this->find('first',array( 'conditions' => array('Noticia.slug' => $this->data[$this->alias]['slug'] ) ) );
			    	if($noticia){
			    		//verificar se é o mesmo id se for pode editar se nao .. nao pode este titulo pois ja existe noticia
			    		//se noticia no banco é igual a que esta editando
			    		if($noticia['Noticia']['id'] != $this->data[$this->alias]['id']){
			    			return FALSE;
			    		}
			    	}
		    	}
	    	}
        }
        
     return true;  	
	}
 */   

	public function addSlug($dados){
		if(isset($dados['Noticia']['titulo']) && $dados['Noticia']['titulo'] != '' ){
			
			$slug = Inflector::slug($dados['Noticia']['titulo']); // retira acentos e etc
			$slug = strtolower($slug); // passa pra minusculo
			$slug = str_replace("_", "-", $slug); // troca _ por -

            return $slug;		
		}
	}
	
	public $validate = array(

							'titulo' => array(
											  'notEmpty' => array(
																 'rule' 	 => 'notEmpty',
																 'message'   =>'O campo não pode ser vazio!'),
											  'unico'	 => array( 
														    	 'rule' 	 => array('isUnique',true),
																 'message'   =>'Já existe Notícia com este título!')),
	  					     'slug'	 => array( 
									    	 'rule' 	 => 'isUnique',
											 'message'   =>'Já existe Notícia com este título!'),

/*
											  'slug'	 => array(
											  					  'rule'	 => array('validaSlug', 'slug'),
											  					  'message'	 =>	'Já existe título com este nome!' )) , */

/*							'titulo' => array(
											  'rule' => array('validaSlug', 'slug'),
															 'message' => 'Já existe título com este nome!'),*/
										
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
					    	
	public function afterValidate(){
		//se ocorrer erro no campo slug
		if(array_key_exists('slug', $this->validationErrors)){
			//se nao tiver ocorrido o erro em titulo
			if(!array_key_exists('titulo', $this->validationErrors)){
				//invalida o campo titulo e add a msg de erro do campo slug
				$this->invalidate('titulo',$this->validationErrors['slug'][0] );	
			}
		}
	}					    	
}
 ?>
