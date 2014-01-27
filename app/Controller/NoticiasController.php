<?php 

App::uses('File', 'Utility');

	class NoticiasController extends  AppController{

		public $helpers = array('Html', 'Form', 'Js');
		
		function beforeFilter() {
        $this->loadModel('Paise');
        $this->Paise->recursive = 0;
		
		$this->loadModel('Cidade');
		$this->Cidade->recursive = 1;
		$this->loadModel('Clube');
    }
	
		public function index(){
			$noticias = $this->Noticia->find('all');
			$this->paginate['Noticia']['order'] = array(
            'Noticia.id' => 'asc',
            'Noticia.datahora' => 'asc');
			$this->set('noticias', $this->paginate());
		}
		
		public function add(){       
        // busca paises cadastrados
       $paises = $this->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
       $this->set(compact('paises'));

	        if ($this->request->is('post') || $this->request->is('put')) {
        			//FORMATA DATA E HORA de 'DD:MM:YYYY: P/ 'YYYY'MM'DD hh:mm:ss'
					if($this->request->data['datahoras'] == 'programarHora'){
							//TESTA SE CAMPO HORAS E MINUTOS FOI SELECIONADO
							if($this->request->data['horas'] == '' && $this->request->data['minutos'] =='' ){
								$this->request->data['horas'] = "00"; 
								$this->request->data['minutos'] = "00";
							}
						$this->request->data['Noticia']['datahora'] = substr($this->request->data['pdatahora'],6,4) . "-" . 
							substr($this->request->data['pdatahora'],3,2) . "-" . substr($this->request->data['pdatahora'],0,2) . " " .
								$this->request->data['horas'] . ":" . $this->request->data['minutos'] . ":00";
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

							if ($this->Noticia->save($this->request->data)) {
				                
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
		
		public function view($id = null){
			$this->set('title_for_layout','Noticias');
			if($this->request->is('get')){
				$this->set('noticia', $this->Noticia->findById($id));
				
				
			}
		}
			
		public function edit($id = null){
			//debug($this->request->data);
			if (!$id) {
            	throw new NotFoundException(__('Noticia Inválida!'));
        	}
			
			$this->Noticia->recursive = 0;
			$noticia = $this->Noticia->findById($id);
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
			
			if ($this->request->is('post') || $this->request->is('put')) {
				$this->Noticia->id = $id;
				
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
						$this->Session->setFlash('Não foi possível alterar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
				   }
	        }
		        if (!$this->request->data) {
		            $this->request->data = $noticia;
	        	}		
				
		}
		
		public function edit_image($id = null){
			if (!$id) {
            	throw new NotFoundException(__('Noticia Inválida!'));
        	}
			$noticia = $this->Noticia->findById($id);
			if(!$noticia){
				 throw new NotFoundException(__('Noticia Inválida!'));
			}
					
			if ($this->request->is('post') || $this->request->is('put')) {
					$this->Noticia->id = $id;
				
					//REMOVE REGRAS DE VALIDACAO
					$this->Noticia->validator()->remove('cidade_id');
					$this->Noticia->validator()->remove('clube_id');
					$this->Noticia->validator()->remove('titulo');
					$this->Noticia->validator()->remove('corpo');
					//SE FOR SEM IMGEM
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
					//SE FOR UPLOAD
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
					//SE FOR URL
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
			        if (!$this->request->data) {
			            $this->request->data = $noticia;
		        	}		
		        	
		}
		
		public function delete($id){
		 if (!$this->request->is('post')) {
		            throw new MethodNotAllowedException();
		        }
		        
		        $noticia = $this->Noticia->findById($id);
		        if (!$noticia) {
		            throw new NotFoundException(__('Noticia inválida.'));
		        }
		        if ($this->Noticia->delete($id)) {
		            if (!empty($noticia['Noticia']['img_upload'])) {
		                $arquivo = new File(WWW_ROOT.'img/noticias/images/' . $noticia['Noticia']['img_upload'], true, 0755);
		                $arquivo->delete();
		            }
		                      
		            $this->Session->setFlash('Noticia com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
		            $this->redirect(array('action' => 'index'));
		        }
		        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
		        $this->redirect(array('action' => 'index'));
		}
	}
 ?>