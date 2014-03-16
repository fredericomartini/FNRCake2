<?php 

App::uses('File', 'Utility');
App::uses('GoogleUrlShortener', 'Lib');


class NoticiasController extends  AppController{

	function beforeFilter() {
	    $this->loadModel('Paise');
	    $this->Paise->recursive = 0;
		
		$this->loadModel('Cidade');
		$this->Cidade->recursive = 1;
		$this->loadModel('Clube');
    }
	
	
    public $paginate = array(
        'fields' => array('Noticia.id', 'Noticia.titulo'),
        'order' => array('Noticia.titulo' => 'asc')
    );	
	
	
	public function index(){
        $this->Paginator->settings = array(
            'limit'  => 20,
            'fields' => array('Noticia.id', 'Noticia.titulo', 'datahora', 'slug'),
        	'order'  => array('Noticia.titulo' => 'asc')
        );
        
        $this->set('noticias', $this->Paginator->paginate('Noticia'));
	}
	
	
	public function add(){       
    // busca paises cadastrados
    $paises = $this->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
   	$this->set(compact('paises'));
	
        if ($this->request->is('post') || $this->request->is('put')) {
			//add slug
			$this->request->data['Noticia']['slug'] = $this->Noticia->addSlug($this->request->data);
			
				if($this->request->data['datahoras'] == 'programarHora'){ //opcao programar hora
					//formata datahora no formato timestamp
					$this->request->data['Noticia']['datahora'] = 	$this->Noticia->formatToTimestamp(array('data'=> $this->request->data['pdatahora'], 
																											'horas' => $this->request->data['horas'], 
																											'minutos' => $this->request->data['minutos']) );
				}
			   	//SE FOR SEM IMGEM
				if($this->request->data['image'] == 'semImagem'){
						  //limpa campos p/ ir p/ banco
				      	  $this->request->data['Noticia']['img_upload'] = null;
						  $this->request->data['Noticia']['img_url'] = null;	
				      	  //remove regras validacao
				      	  $this->Noticia->validator()->remove('imagemUpload'); 
				     	  $this->Noticia->validator()->remove('img_url');
				}
				//SE FOR UPLOAD
				else if($this->request->data['image'] == 'uploadImagem'){
							//remove validacao
							$this->Noticia->validator()->remove('img_url'); 
							//limpa campo
							$this->request->data['Noticia']['img_url'] = null; 
							
							//salva p/ pegar id da noticia
							if($this->Noticia->save($this->request->data)){
				                
					                $id = $this->Noticia->getLastInsertID();
					                $this->Noticia->id = $id;
					                
					                	if ($this->request->data['Noticia']['imagemUpload']['error'] == 0) {
	
						                	$nome_arquivo = "not_" . $id . "." . substr($this->request->data['Noticia']['imagemUpload']['type'],6,4);
						                	
						                    $arquivo = new File($this->request->data['Noticia']['imagemUpload']['tmp_name'],false);
						                    $imagem = $arquivo->read();
						                    $arquivo->close();
						                    $arquivo = new File(WWW_ROOT.'img/noticias/images/' . $nome_arquivo, false ,0777);
					                    if($arquivo->create()) {
					                        $arquivo->write($imagem);
					                        $arquivo->close();
					                    }
					                    $this->request->data['Noticia']['img_upload'] = $nome_arquivo;
					                }
				            }
							 else {
				                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
				            }
				}
				//SE FOR URL
				else if($this->request->data['image'] == 'urlImagem'){
					$this->Noticia->validator()->remove('imagemUpload'); //REMOVE REGRAS DE VALIDACAO
					$this->request->data['Noticia']['img_upload'] = null;
				}

				//TENTA SALVAR
				if($this->Noticia->save($this->request->data)){
	                $this->Session->setFlash('Noticia salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
	                $this->redirect(array('action' => 'index'));
		        }
				else {
		        	$this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
		        }
        }	 
	}

	
	public function futebol($slug = null){
		$noticia = $this->Noticia->find('first',array( 'conditions' => array('Noticia.slug' => str_ireplace('.html', '', $slug) )) ) ;
		if(!$noticia){
			throw new NotFoundException(__('Noticia Inválida!'));
		}
		//cria um encurtador de Url
	   	$shorUrl = new GoogleUrlShortener();
        $noticia['url_shortened']  = $shorUrl->shortenUrl($_SERVER['HTTP_HOST'].$this->here)->id; //chama o metodo p/ encurtar url passando a localização atual
		
		$this->set('title_for_layout',$noticia['Noticia']['titulo']);
		$this->set('noticia', $noticia);
	}


	public function edit($slug = null){
		if (!$slug) {
        	throw new NotFoundException(__('Noticia Inválida!'));
    	}
		$this->Noticia->recursive = 0;
		
		//pesquisa noticia por slug
		$noticia = $this->Noticia->find('first',array( 'conditions' => array('Noticia.slug' => str_ireplace('.html', '', $slug) )) ) ;
		
		//nao encontrou a noticia
		if(!$noticia){
			 throw new NotFoundException(__('Noticia Inválida!'));
		}
		//pega todas as cidades que pertencem ao estado da noticia
		$cidades = $this->Cidade->find('list' , array('fields' => array(
																		'Cidade.id', 'Cidade.nome'),
													  'conditions' => array(
												  							'Cidade.estado_id' => $noticia['Cidade']['estado_id'] )));
		$this->set(compact('cidades'));
		
		//pega os clubes que pertencem a cidade da noticia
		$clubes = $this->Clube->find('list' , array('fields' => array(
															 		  'Clube.id', 'Clube.nome_reduzido'),
													  'conditions' => array(
													  						'Clube.cidade_id' => $noticia['Noticia']['cidade_id'] )));
		$this->set(compact('clubes'));
		
		//se requisicao é p/ salvar
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->Noticia->id = $this->request->data['Noticia']['id'];
			//add slug
			$this->request->data['Noticia']['slug'] = $this->Noticia->addSlug($this->request->data);
				//formata datahora no formato timestamp
				$this->request->data['Noticia']['datahora'] = 	$this->Noticia->formatToTimestamp(array('data'=> $this->request->data['datanoticia'], 
																										'horas' => $this->request->data['horas'], 
																										'minutos' => $this->request->data['minutos']) );
			    //remove regras de validacao
			    $this->Noticia->remove('img_url');
			    $this->Noticia->remove('imagemUpload');

			    //TENTA SALVAR
			    if($this->Noticia->save($this->request->data)){
						$this->Session->setFlash('Noticia alterada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
					  	$this->redirect(array('action' => 'index'));
				}
		 	    else{
					$this->Session->setFlash('Não foi possível alterar. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
			   }
        }
        //mantem dados form
	    if (!$this->request->data) {
	        $this->request->data = $noticia;
    	}		
	}
	
	
	public function edit_image($slug = null){
		if (!$slug) {
        	throw new NotFoundException(__('Noticia Inválida!'));
    	}
		//pesquisa noticia por slug
		$noticia = $this->Noticia->find('first',array( 'conditions' => array('Noticia.slug' => str_ireplace('.html', '', $slug) )) ) ;

		if(!$noticia){
			 throw new NotFoundException(__('Noticia Inválida!'));
		}
				
		if($this->request->is('post') || $this->request->is('put')) {
			$this->Noticia->id = $noticia['Noticia']['id'];
			
			//remove regras de validacao
			$this->Noticia->validator()->remove('cidade_id');
			$this->Noticia->validator()->remove('clube_id');
			$this->Noticia->validator()->remove('titulo');
			$this->Noticia->validator()->remove('corpo');
			
			//opcao sem imagem
			if($this->request->data['image'] == 'semImagem'){
				// Apaga a imagem antiga
                if (!empty($noticia['Noticia']['img_upload'])) {
                    $img_antiga = new File(WWW_ROOT.'img/noticias/images/' . $noticia['Noticia']['img_upload'], true, 0755);
                    $img_antiga->delete();
                }
		      	  $this->request->data['Noticia']['img_upload'] = null;//LIMPA CAMPOS P/ IR P/ BANCO
				  $this->request->data['Noticia']['img_url'] = null;	
		      	  $this->Noticia->validator()->remove('imagemUpload'); //REMOVE REGRAS DE VALIDACAO
		     	  $this->Noticia->validator()->remove('img_url');
			}
			//opcao upload
			else if($this->request->data['image'] == 'uploadImagem'){
                
				$this->Noticia->validator()->remove('img_url'); //REMOVE VALIDACAO URL
				$this->request->data['Noticia']['img_url'] = null; //LIMPA ARRAY
		        
		        $id = $this->Noticia->id;

	            if ($this->request->data['Noticia']['imagemUpload']['error'] == 0){ //SE NAO TIVER ERRO AO FAZER UPLOAD
	                // Apaga a imagem antiga
	                if (!empty($noticia['Noticia']['img_upload'])) {
	                    $img_antiga = new File(WWW_ROOT.'img/noticias/images/' . $noticia['Noticia']['img_upload'], true, 0755);
	                    $img_antiga->delete();
	                }
               		// Insere a imagem nova
                	$nome_arquivo = "not_" . $id . "." . substr($this->request->data['Noticia']['imagemUpload']['type'],6,4);
                    $arquivo = new File($this->request->data['Noticia']['imagemUpload']['tmp_name'],false);
                    $imagem = $arquivo->read();
                    $arquivo->close();
                    $arquivo = new File(WWW_ROOT.'img/noticias/images/' . $nome_arquivo, false ,0777);
                    if($arquivo->create()) {
                        $arquivo->write($imagem);
                        $arquivo->close();
                	}
	                $this->request->data['Noticia']['img_upload'] = $nome_arquivo;
	            } 
	            else if(!empty($this->request->data['Noticia']['img_upload'])){ //SE TIVER IMG EM CAMPO HIDDEN
	            	$this->Noticia->validator()->remove('imagemUpload'); //REMOVE VALIDACAO URL
					$this->request->data['Noticia']['imagemUpload'] = null; //LIMPA ARRAY
				}
			}
			//opcao url
			else if($this->request->data['image'] == 'urlImagem'){
				// Apaga a imagem antiga
                if (!empty($noticia['Noticia']['img_upload'])) {
                    $img_antiga = new File(WWW_ROOT.'img/noticias/images/' . $noticia['Noticia']['img_upload'], true, 0755);
                    $img_antiga->delete();
                }	
				$this->Noticia->validator()->remove('imagemUpload'); //REMOVE REGRAS DE VALIDACAO
				$this->request->data['Noticia']['img_upload'] = null;
			}
		    //TENTA SALVAR
		    if($this->Noticia->save($this->request->data)){
				$this->Session->setFlash('Imagem alterada com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
			  	$this->redirect(array('action' => 'index'));
			}
	 	   else{
				$this->Session->setFlash('Não foi possível alterar a imagem. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
		   }
        }
		//mantem dados form
        if (!$this->request->data) {
            $this->request->data = $noticia;
    	}		
	}
	
	public function delete($slug){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
	        
        $noticia = $this->Noticia->find('first',array( 'conditions' => array('Noticia.slug' => str_ireplace('.html', '', $slug))) ) ;
        //sem noticia
        if (!$noticia) {
            throw new NotFoundException(__('Noticia inválida.'));
        }
        if ($this->Noticia->delete($noticia['Noticia']['id'])) {
            if (!empty($noticia['Noticia']['img_upload'])) {
                $arquivo = new File(WWW_ROOT.'img/noticias/images/' . $noticia['Noticia']['img_upload'], true, 0755);
                $arquivo->delete();
            }
                      
            $this->Session->setFlash('Noticia com o titulo: ' . $noticia['Noticia']['titulo'] . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
	}
}
 ?>