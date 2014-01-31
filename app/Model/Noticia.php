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

	public function addSlug($dados){
		if(isset($dados['Noticia']['titulo']) && $dados['Noticia']['titulo'] != '' ){
			
			$slug = Inflector::slug($dados['Noticia']['titulo']); // retira acentos e etc
			$slug = strtolower($slug); // passa pra minusculo
			$slug = str_replace("_", "-", $slug); // troca _ por -

            return $slug;		
		}
	}
	
	/**
	 * retorna a data no formato
	 * yyyy/dd/mm hh:mm:ss
	 */
	function formatToTimestamp($data){
		if( (isset($data['data']) && $data['data'] =='') || (!isset($data['data'] )) ){
			$datahora = 'now';					
		}
		else{
			if( (isset($data['horas']) && $data['horas'] =='') || (!isset($data['horas'])) )
				$data['horas'] 	 = '00';
			if( (isset($data['minutos']) && $data['minutos'] =='') || (!isset($data['minutos'])) )
				$data['minutos'] = '00';
					
			$datahora  = substr($data['data'],6,4) . "-" . substr($data['data'],3,2) . "-" . substr($data['data'],0,2) . " ". $data['horas'] . ":" . $data['minutos'] . ":00";
		}	
		return $datahora;
	}
	public $validate = array(

							'titulo' => array(
											  'notEmpty' => array(
																 'rule' 	 => 'notEmpty',
																 'message'   =>'O campo não pode ser vazio!'),
											  'unico'	 => array( 
														    	 'rule' 	 => array('isUnique',true),
																 'message'   =>'Já existe Notícia com este título!')),
	  					    'slug'  => array( 
									    'rule' 	 => 'isUnique',
									    'message'   =>'Já existe Notícia com este título!'),
										
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

	/**
	 * após a validação faz um teste p/ ver se o campo slug
	 * pode ser salvo, se gerar erro, verifica se o campo titulo
	 * deu erro , caso nao tenha dado, add msg de erro do campo slug 
	 * no input titulo
	 */					    	
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
