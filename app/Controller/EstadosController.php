<?php

class EstadosController extends AppController {
    
    public function buscaEstados($chave) {
        $this->layout = 'ajax';
        if (array_key_exists("pais", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['pais'];
        } elseif (array_key_exists("paise_id", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['paise_id'];
        }
        $estados = $this->Estado->find('list' , array('order' => 'nome ASC','fields' => array('Estado.id', 'Estado.nome'),'conditions' => array('Estado.paise_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($estados as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public $paginate = array(
        'fields' => array('Estado.id', 'Estado.nome'),
        'order' => array('Estado.nome' => 'asc')
    );

    public function index() {
        $this->Estado->recursive = 0;
        $this->set('estados', $this->paginate());
    }
    
    public function view($id = null) {
        $this->Estado->id = $id;
        if (!$this->Estado->exists()) {
            throw new NotFoundException(__('Estado inválido'));
        }
        $this->set('estado', $this->Estado->read(null, $id));
        
        $paises = $this->Estado->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
        $this->set(compact('paises'));
    }
    
    public function add() {
        if ($this->request->is('post')) {
            $this->Estado->create();
            if ($this->Estado->save($this->request->data)) {
                $this->Session->setFlash('Estado salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
        
        // busca grupos cadastrados
        $paises = $this->Estado->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
        $this->set(compact('paises'));
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Estado inválido.'));
        }

        $estado = $this->Estado->findById($id);
        if (!$estado) {
            throw new NotFoundException(__('Estado inválido.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Estado->id = $id;
            if ($this->Estado->save($this->request->data)) {
                $this->Session->setFlash('Estado alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $estado;
        }
        
        // busca grupos cadastrados
        $paises = $this->Estado->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
        $this->set(compact('paises'));
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Estado->id = $id;
        if (!$this->Estado->exists()) {
            throw new NotFoundException(__('Estado inválido.'));
        }
        if ($this->Estado->delete()) {
            $this->Session->setFlash('Estado excluído com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
    
}

?>
