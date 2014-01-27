<?php

class SituacaosController extends AppController {
    
    public $paginate = array(
        'order' => array('nome' => 'asc')
    );

    public function index() {
        $this->Situacao->recursive = 0;
        $this->set('situacaos', $this->paginate());
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Situação inválida.'));
        }

        $situacao = $this->Situacao->findById($id);
        if (!$situacao) {
            throw new NotFoundException(__('Situação inválida.'));
        }
        $this->set('situacao', $situacao);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Situacao->create();
            if ($this->Situacao->save($this->request->data)) {
                $this->Session->setFlash('Situação salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Situação inválida.'));
        }

        $situacao = $this->Situacao->findById($id);
        if (!$situacao) {
            throw new NotFoundException(__('Situação inválida.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Situacao->id = $id;
            if ($this->Situacao->save($this->request->data)) {
                $this->Session->setFlash('Situação alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $situacao;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Situacao->delete($id)) {
            $this->Session->setFlash('Situação com o id: ' . $id . ' foi deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
