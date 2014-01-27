<?php

class FormulasController extends AppController {
    
    function beforeFilter() {
        $this->Formula->recursive = 0;
    }

    public function index() {
        $this->Formula->recursive = -1;
        $this->Paginator->settings = array(
            'limit' => 20,
            'fields' => array('id', 'nome'),
            'order' => array('nome' => 'asc')
        );
        $this->set('formulas', $this->Paginator->paginate('Formula'));
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Fórmula inválida.'));
        }

        $formula = $this->Formula->findById($id);
        if (!$formula) {
            throw new NotFoundException(__('Fórmula inválida.'));
        }
        $this->set('formula', $formula);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Formula->create();
            if ($this->Formula->save($this->request->data)) {
                $this->Session->setFlash('Fórmula salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Fórmula inválida.'));
        }

        $formula = $this->Formula->findById($id);
        if (!$formula) {
            throw new NotFoundException(__('Fórmula inválida.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Formula->id = $id;
            if ($this->Formula->save($this->request->data)) {
                $this->Session->setFlash('Fórmula alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $formula;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Formula->delete($id)) {
            $this->Session->setFlash('Fórmula com o id: ' . $id . ' foi deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
