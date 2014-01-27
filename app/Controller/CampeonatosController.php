<?php

App::uses('File', 'Utility');

class CampeonatosController extends AppController {
    
    function beforeFilter() {
        $this->Campeonato->recursive = 0;
    }
    
    public function index() {
        $this->Campeonato->recursive = -1;
        $this->Paginator->settings = array(
            'limit' => 20,
            'fields' => array('id', 'nome_completo'),
            'order' => array('nome_completo' => 'asc')
        );
        $this->set('campeonatos', $this->Paginator->paginate('Campeonato'));
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Campeonato inválido.'));
        }

        $campeonato = $this->Campeonato->findById($id);
        if (!$campeonato) {
            throw new NotFoundException(__('Campeonato inválido.'));
        }
        $this->set('campeonato', $campeonato);
        
    }
    
    public function add() {
        
        // busca divisões cadastradas
        $divisoes = $this->Campeonato->Divisao->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('divisoes'));
        
        // busca níveis cadastrados
        $niveis = $this->Campeonato->Nivei->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('niveis'));
        
        // busca níveis para desabilitar campos
        $tipoNivel = $this->Campeonato->Nivei->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'tipo')));
        $this->set(compact('tipoNivel'));
        
        // busca fórmulas cadastradas
        $paises = $this->Campeonato->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('paises'));
        
        if ($this->request->is('post')) {
            
            $this->Campeonato->create();
            
            if ($this->Campeonato->save($this->request->data)) {
                
                $id = $this->Campeonato->getLastInsertID();
                $this->Campeonato->id = $id;
                
                if ($this->request->data['Campeonato']['superior']['error'] == 0) {
                    $nome_arquivo = "sup_" . $id . "." . substr($this->request->data['Campeonato']['superior']['type'],6,3);
                    $arquivo = new File($this->request->data['Campeonato']['superior']['tmp_name'],false);
                    $imagem = $arquivo->read();
                    $arquivo->close();
                    $arquivo = new File(WWW_ROOT.'img/campeonatos/superiores/' . $nome_arquivo, false ,0777);
                    if($arquivo->create()) {
                        $arquivo->write($imagem);
                        $arquivo->close();
                    }
                    $this->request->data['Campeonato']['img_superior'] = $nome_arquivo;
                }
                
                $this->Campeonato->save($this->request->data);
                $this->Session->setFlash('Campeonato salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
                
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
        
        
    }
    
    public function edit($id = null) {
        
        if (!$id) {
            throw new NotFoundException(__('Campeonato inválido.'));
        }

        $campeonato = $this->Campeonato->findById($id);
        if (!$campeonato) {
            throw new NotFoundException(__('Campeonato inválido.'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Campeonato->id = $id;
            
            if ($this->request->data['Campeonato']['superior']['error'] == 0) {
                // Apaga a imagem antiga
                if (!empty($campeonato['Campeonato']['img_superior'])) {
                    $img_antiga = new File(WWW_ROOT.'img/campeonatos/superiores/' . $campeonato['Campeonato']['img_superior'], true, 0755);
                    $img_antiga->delete();
                }
                // Insere a imagem nova
                $nome_arquivo = "sup_" . $id . "." . substr($this->request->data['Campeonato']['superior']['type'],6,3);
                $arquivo = new File($this->request->data['Campeonato']['superior']['tmp_name'],false);
                $imagem = $arquivo->read();
                $arquivo->close();
                $arquivo = new File(WWW_ROOT.'img/campeonatos/superiores/' . $nome_arquivo, false ,0777);
                if($arquivo->create()) {
                    $arquivo->write($imagem);
                    $arquivo->close();
                }
                $this->request->data['Campeonato']['img_superior'] = $nome_arquivo;
            } else {
                $this->Campeonato->validator()->remove('superior');
            }
            
            if ($this->Campeonato->save($this->request->data)) {
                $this->Session->setFlash('Campeonato alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $campeonato;
        }
        
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        $campeonato = $this->Campeonato->findById($id);
        if (!$campeonato) {
            throw new NotFoundException(__('Campeonato inválido.'));
        }
        
        if ($this->Campeonato->delete($id)) {
            if (!empty($campeonato['Campeonato']['img_superior'])) {
                $arquivo = new File(WWW_ROOT.'img/campeonatos/superiores/' . $campeonato['Campeonato']['img_superior'], true, 0755);
                $arquivo->delete();
            }        
            $this->Session->setFlash('Campeonato com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível apagar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}
?>
