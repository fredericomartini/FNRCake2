<?php

class DivisaosController extends AppController {
    
    public $paginate = array(
        'order' => array('nome' => 'asc')
    );

    public function index() {
        $this->Divisao->recursive = 0;
        $this->set('divisaos', $this->paginate());
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Divisão inválida.'));
        }

        $divisao = $this->Divisao->findById($id);
        if (!$divisao) {
            throw new NotFoundException(__('Divisão inválida.'));
        }
        $this->set('divisao', $divisao);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Divisao->create();
            if ($this->Divisao->save($this->request->data)) {
                $this->Session->setFlash('Divisão salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Divisão inválida.'));
        }

        $divisao = $this->Divisao->findById($id);
        if (!$divisao) {
            throw new NotFoundException(__('Divisão inválida.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Divisao->id = $id;
            if ($this->Divisao->save($this->request->data)) {
                $this->Session->setFlash('Divisão alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $divisao;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Divisao->delete($id)) {
            $this->Session->setFlash('Divisão com o id: ' . $id . ' foi deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}
?>
