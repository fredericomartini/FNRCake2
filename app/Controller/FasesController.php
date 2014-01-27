<?php

class FasesController extends AppController {
    
    function beforeFilter() {
        $this->Fase->recursive = 0;
    }

    public function index() {
        
        // busca fórmulas cadastradas
        $this->Fase->Formula->recursive = -1;
        $formulas = $this->Fase->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'formula_id' => array(
                        'select' => $formulas
                    )
                ),
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        $this->set('fases', $this->paginate());
    }
    
    public function buscaFases($chave, $campo) {
        $this->layout = 'ajax';
        if (array_key_exists($campo, $this->request->data[$chave])) {
            $catID = $this->request->data[$chave][$campo];
        } else {
            $catID = 500;
        }
        $fases = $this->Fase->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('formula_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($fases as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Fase inválida.'));
        }

        $fase = $this->Fase->findById($id);
        if (!$fase) {
            throw new NotFoundException(__('Fase inválida.'));
        }
        $this->set('fase', $fase);
    }
    
    public function add() {
        
        // Opções se gera classificação geral ou não
        $opcoes = array(1 => 'SIM', 2 => 'NAO');
        $this->set('opcoes', $opcoes);
        
        // busca fórmulas cadastradas
        $this->Fase->Formula->recursive = -1;
        $formulas = $this->Fase->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('formulas'));
        
        if ($this->request->is('post')) {
            $this->Fase->create();
            if ($this->Fase->save($this->request->data)) {
                $this->Session->setFlash('Fase salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        
        if (!$id) {
            throw new NotFoundException(__('Fase inválida.'));
        }
        
        $fase = $this->Fase->findById($id);
        if (!$fase) {
            throw new NotFoundException(__('Fase inválida.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Fase->id = $id;
            if ($this->Fase->save($this->request->data)) {
                $this->Session->setFlash('Fase alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $fase;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Fase->delete($id)) {
            $this->Session->setFlash('Fase com o id: ' . $id . ' foi deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
