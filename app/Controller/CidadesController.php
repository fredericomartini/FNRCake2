<?php
class CidadesController extends AppController {
    
    function beforeFilter() {
        $this->loadModel('Paise');
    }
    
    public function buscaCidades($chave) {
        $this->layout = 'ajax';
        $catID = $this->request->data[$chave]['estado'];
        $cidades = $this->Cidade->find('list' , array('fields' => array('Cidade.id', 'Cidade.nome'),'conditions' => array('Cidade.estado_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($cidades as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public $paginate = array(
        'fields' => array('Cidade.id', 'Cidade.nome'),
        'order' => array('Cidade.nome' => 'asc')
    );

    public function index() {
        $this->Cidade->recursive = 0;
        $this->set('cidades', $this->paginate());
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Cidade inválida.'));
        }

        $cidade = $this->Cidade->findById($id);
        if (!$cidade) {
            throw new NotFoundException(__('Cidade inválida.'));
        }
        $this->set('cidade', $cidade);
        
        $estado = $this->Cidade->Estado->findById($cidade['Cidade']['estado_id']);
        if (!$estado) {
            throw new NotFoundException(__('Estado inválido.'));
        }
        $this->set('estado', $estado);
        
        $pais = $this->Paise->findById($estado['Estado']['paise_id']);
        if (!$pais) {
            throw new NotFoundException(__('País inválido.'));
        }
        $this->set('pais', $pais);
        
    }
    
    public function add() {
        
        $paises = $this->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
        $this->set(compact('paises'));
        
        if ($this->request->is('post')) {
            $this->Cidade->create();
            if ($this->Cidade->save($this->request->data)) {
                $this->Session->setFlash('Cidade salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
        
    }
    
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Cidade inválida.'));
        }

        $cidade = $this->Cidade->findById($id);
        if (!$cidade) {
            throw new NotFoundException(__('Cidade inválida.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Cidade->id = $id;
            if ($this->Cidade->save($this->request->data)) {
                $this->Session->setFlash('Cidade alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $cidade;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Cidade->id = $id;
        if (!$this->Cidade->exists()) {
            throw new NotFoundException(__('Cidade inválido.'));
        }
        if ($this->Cidade->delete()) {
            $this->Session->setFlash('Cidade excluída com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
        
    }
    
}

?>
