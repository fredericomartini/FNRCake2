<?php

class RodadasController extends AppController {
    
    function beforeFilter() {
        $this->Rodada->recursive = 1;
    }
    
    public function index() {
        
        // busca fórmulas cadastradas
        $this->Rodada->Grupo->Fase->Formula->recursive = -1;
        $formulas = $this->Rodada->Grupo->Fase->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('formulas'));
        
        // Fases
        $filtroFases = array('' => '-- Fase --');
        
        // Grupos
        $filtroGrupos = array('' => '-- Grupo --');
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter2' => array(
                    'fase_id' => array(
                        'select' => $filtroFases
                    )
                ),
                'filter3' => array(
                    'grupo_id' => array(
                        'select' => $filtroGrupos
                    )
                ),
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        // Ordenação
        $this->Filter->setPaginate('order' , array('Grupo.ordem' => 'asc', 'Rodada.ordem' => 'asc'));
        
        $this->set('rodadas', $this->paginate());
    }
    
    public function buscaRodadas($chave) {
        $this->layout = 'ajax';
        if (array_key_exists("grupo_id", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['grupo_id'];
        }
        $grupos = $this->Rodada->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('grupo_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($grupos as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Fase inválida.'));
        }

        $rodada = $this->Rodada->findById($id);
        if (!$rodada) {
            throw new NotFoundException(__('Fase inválida.'));
        }
        $this->set('rodada', $rodada);
        
        $this->Rodada->Grupo->Fase->recursive = 0;
        $fase = $this->Rodada->Grupo->Fase->findById($rodada['Grupo']['fase_id']);
        $this->set('fase', $fase);
    }
    
    public function add() {
        
        // busca grupos cadastrados
        $this->Rodada->Grupo->Fase->Formula->recursive = -1;
        $formulas = $this->Rodada->Grupo->Fase->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('formulas'));
        
        if ($this->request->is('post')) {
            $this->Rodada->create();
            if ($this->Rodada->save($this->request->data)) {
                $this->Session->setFlash('Rodada salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Rodada inválida.'));
        }
        
        $rodada = $this->Rodada->findById($id);
        if (!$rodada) {
            throw new NotFoundException(__('Rodada inválida.'));
        }
        
        // busca fórmulas cadastradas
        $this->Rodada->Grupo->recursive = -1;
        $grupos = $this->Rodada->Grupo->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('grupos'));

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Rodada->id = $id;
            if ($this->Rodada->save($this->request->data)) {
                $this->Session->setFlash('Rodada alterada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $rodada;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Rodada->delete($id)) {
            $this->Session->setFlash('Rodada com o id: ' . $id . ' foi deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
