<?php 

App::uses('File', 'Utility');

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
			
			//validacao p/ ver se ja existe alguma noticia com o mesmo slug
	  			//formata data e hora de 'DD:MM:YYYY: p/ 'YYYY'MM'DD hh:mm:ss'
				if($this->request->data['datahoras'] == 'programarHora'){
						//se campo horas e minutos for vazio coloca horas 00 & minutos 00
						if($this->request->data['horas'] == '' && $this->request->data['minutos'] =='' ){
							$this->request->data['horas']   = "00"; 
							$this->request->data['minutos'] = "00";
						}
					//pdatahora entra no formato: DD/MM/YYYY e é transformado p/ YYYY-DD-MM 00:00:00 padrao americano
					$this->request->data['Noticia']['datahora'] = substr($this->request->data['pdatahora'],6,4) . "-" . 
						substr($this->request->data['pdatahora'],3,2) . "-" . substr($this->request->data['pdatahora'],0,2) . " " .
							$this->request->data['horas'] . ":" . $this->request->data['minutos'] . ":00";
	//					substr($this->request->data['pdatahora'],3,2) . "-" . substr($this->request->data['pdatahora'],0,2) . " " .
	//						$this->request->data['horas'] . ":" . $this->request->data['minutos'] . ":00";
				}
			   	//SE FOR SEM IMGEM
				if($this->request->data['image'] == 'semImagem'){
				      	  $this->request->data['Noticia']['img_upload'] = null;//LIMPA CAMPOS P/ IR P/ BANCO
						  $this->request->data['Noticia']['img_url'] = null;	
				      	  $this->Noticia->validator()->remove('imagemUpload'); //REMOVE REGRAS DE VALIDACAO
				     	  $this->Noticia->validator()->remove('img_url');
				}
				//SE FOR UPLOAD
				else if($this->request->data['image'] == 'uploadImagem'){
							$this->Noticia->validator()->remove('img_url'); //REMOVE VALIDACAO URL
							$this->request->data['Noticia']['img_url'] = null; //LIMPA ARRAY
							
							//salva p/ pegar o nome da imagem
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
				                //$this->Session->setFlash('Noticia salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
				                //$this->redirect(array('action' => 'index'));
					                
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
/*
				//valida slug
				if($this->Noticia->validaSlug($this->request->data) ){
	                //tenta salvar
	                if($this->Noticia->save($this->request->data)){
		                $this->Session->setFlash('Noticia salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
		                $this->redirect(array('action' => 'index'));
	                }
					else {
			        	$this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
			        }				
		        }
				else {
		        	$this->Session->setFlash('Já existe Notícia com este título, favor alterar!', 'default', array('class' => 'mensagem_erro'));
		        }
*/		        			        	
        }	 
	}
	
	/*
	 * alterado nome da funcao era VIEW
	 */
	public function futebol($slug = null){
		$noticia = $this->Noticia->find('first',array( 'conditions' => array('Noticia.slug' => str_ireplace('.html', '', $slug) )) ) ;
		if(!$noticia){
			throw new NotFoundException(__('Noticia Inválida!'));
		}
		$this->set('title_for_layout','Noticias');
		$this->set('noticia', $noticia);
	}

/*
 * FUNCAO P/ EDITAR A NOTICIA
 */		
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
		//PEGA TODAS AS CIDADES QUE PERTENCEM AO ESTADO DA NOTICIA
		$cidades = $this->Cidade->find('list' , array('fields' => array(
																		'Cidade.id', 'Cidade.nome'),
													  'conditions' => array(
		
												  						'Cidade.estado_id' => $noticia['Cidade']['estado_id'] )));
		$this->set(compact('cidades'));
		
		//PEGA CLUBES QUE PERTENCEM A CIDADE CADASTRADA NA NOTICIA
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
			
				//FORMATA DATAHORA em yyyy/mm/dd
				$this->request->data['Noticia']['datahora'] = substr($this->request->data['datanoticia'],6,4) . "-" . 
						substr($this->request->data['datanoticia'],3,2) . "-" . substr($this->request->data['datanoticia'],0,2) . " " .
							$this->request->data['horas'] . ":" . $this->request->data['minutos'] . ":00";
			
			    //REMOVE REGRAS DE VALIDACAO
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
			
			//REMOVE REGRAS DE VALIDACAO
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
				            } //SE TIVER IMG EM CAMPO HIDDEN
				            else if(!empty($this->request->data['Noticia']['img_upload'])){
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