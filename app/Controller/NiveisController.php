<?php
class NiveisController extends AppController {
    
    public $paginate = array(
        'order' => array('nome' => 'asc')
    );

    public function index() {
        $this->Nivei->recursive = 0;
        $this->set('niveis', $this->paginate());
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Nível inválido.'));
        }

        $nivel = $this->Nivei->findById($id);
        if (!$nivel) {
            throw new NotFoundException(__('Nível inválido.'));
        }
        $this->set('nivel', $nivel);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Nivei->create();
            if ($this->Nivei->save($this->request->data)) {
                $this->Session->setFlash('Nível salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Nível inválido.'));
        }

        $nivel = $this->Nivei->findById($id);
        if (!$nivel) {
            throw new NotFoundException(__('Nível inválido.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Nivei->id = $id;
            if ($this->Nivei->save($this->request->data)) {
                $this->Session->setFlash('Nível alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $nivel;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Nivei->delete($id)) {
            $this->Session->setFlash('Nível com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}
?>
