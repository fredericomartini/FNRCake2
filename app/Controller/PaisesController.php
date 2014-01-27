<?php
class PaisesController extends AppController {
    
    public $paginate = array(
        'order' => array('nome' => 'asc')
    );

    public function index() {
        $this->Paise->recursive = 0;
        $this->set('paises', $this->paginate());
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('País inválido.'));
        }

        $paise = $this->Paise->findById($id);
        if (!$paise) {
            throw new NotFoundException(__('Menu inválido.'));
        }
        $this->set('paise', $paise);
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Paise->create();
            if ($this->Paise->save($this->request->data)) {
                $this->Session->setFlash('País salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('País inválido.'));
        }

        $paise = $this->Paise->findById($id);
        if (!$paise) {
            throw new NotFoundException(__('País inválido.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Paise->id = $id;
            if ($this->Paise->save($this->request->data)) {
                $this->Session->setFlash('País alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $paise;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Paise->delete($id)) {
            $this->Session->setFlash('País com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function buscaPaises() {
        $this->layout = 'ajax';
        $paises = $this->Paise->find('list' , array('fields' => array('id', 'nome'), 'order' => array('nome')));
        echo "<option value=\"\"></option>";
        foreach($paises as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
}
?>
