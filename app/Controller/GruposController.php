<?php

class GruposController extends AppController {
    
    function beforeFilter() {
        $this->Grupo->recursive = 0;
    }
    
    public function index() {
        
        // busca fórmulas cadastradas
        $this->Grupo->Fase->Formula->recursive = -1;
        $formulas = $this->Grupo->Fase->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        
        // Fases
        $filtroFases = array('' => '-- Fase --');
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'formula_id' => array(
                        'select' => $formulas
                    )
                ),
                'filter2' => array(
                    'fase_id' => array(
                        'select' => $filtroFases
                    )
                ),
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        // Teste ordenação
        $this->Filter->setPaginate('order' , array('Fase.ordem' => 'asc', 'Grupo.ordem' => 'asc'));
        
        $this->set('grupos', $this->paginate());
    }
    
    public function buscaGrupos($chave) {
        $this->layout = 'ajax';
        if (array_key_exists("fase_id", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['fase_id'];
        }
        $grupos = $this->Grupo->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('fase_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($grupos as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Fase inválida.'));
        }

        $grupo = $this->Grupo->findById($id);
        if (!$grupo) {
            throw new NotFoundException(__('Fase inválida.'));
        }
        $this->set('grupo', $grupo);
        
        $this->Grupo->Fase->Formula->recursive = -1;
        $formula = $this->Grupo->Fase->Formula->findById($grupo['Fase']['formula_id']);
        $this->set('formula', $formula);
    }
    
    public function add() {
        
        // Opções se gera classificação
        $opcoes = array(1 => 'SIM', 2 => 'NAO');
        $this->set('opcoes', $opcoes);
        
        // busca formulas cadastradas
        $this->Grupo->Fase->Formula->recursive = -1;
        $formulas = $this->Grupo->Fase->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('formulas'));
        
        if ($this->request->is('post')) {
            $this->Grupo->create();
            if ($this->Grupo->save($this->request->data)) {
                $this->Session->setFlash('Grupo salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Grupo inválido.'));
        }
        
        $grupo = $this->Grupo->findById($id);
        if (!$grupo) {
            throw new NotFoundException(__('Grupo inválido.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Grupo->id = $id;
            if ($this->Grupo->save($this->request->data)) {
                $this->Session->setFlash('Grupo alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $grupo;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Grupo->delete($id)) {
            $this->Session->setFlash('Grupo com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
    // Funções Ajax para os combos
    
    public function buscaFasesFiltro($chave, $campo) {
        $this->layout = 'ajax';
        if (array_key_exists($campo, $this->request->data[$chave])) {
            $catID = $this->request->data[$chave][$campo];
        }
        $fases = $this->Grupo->Fase->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('formula_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($fases as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
}

?>
