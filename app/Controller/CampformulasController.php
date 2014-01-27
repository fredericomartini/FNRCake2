<?php

class CampformulasController extends AppController {
    
    function beforeFilter() {
        $this->Campformula->recursive = 0;
    }
    
    

    public function index() {
        
        $this->Paginator->settings = array(
            'limit' => 20,
            'conditions' => array('ano' => date('Y')),
            'order' => array('ano' => 'desc'), 
        );
        $this->set('campeonatos', $this->Paginator->paginate('Campformula'));
        
    }
    
    public function buscaFormula($chave, $ano) {
        $this->layout = 'ajax';
        if (array_key_exists("campeonato_id", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['campeonato_id'];
        }
        $this->Campformula->recursive = 0;
        $campformulas = $this->Campformula->find('all', array(
            'fields' => array('Formula.id', 'Formula.nome'),
            'conditions' => array('campeonato_id' => $catID, 'ano' => $ano)
        ));
        echo "<option value=\"\"></option>";
        foreach($campformulas as $key => $subcat){ 
            echo "<option value=\"{$subcat['Formula']['id']}\">{$subcat['Formula']['nome']}</option>";
        }
    }
    
    public function add() {
        
        // busca campeonatos cadastrados
        $this->Campformula->Campeonato->recursive = -1;
        $campeonatos = $this->Campformula->Campeonato->find('list', array('order' => 'nome_reduzido ASC', 'fields' => array('id', 'nome_reduzido')));
        $this->set(compact('campeonatos'));
        
        // busca fórmulas cadastradas
        $this->Campformula->Formula->recursive = -1;
        $formulas = $this->Campformula->Formula->find('list', array('order' => 'nome ASC', 'fields' => array('id', 'nome')));
        $this->set(compact('formulas'));
        
        if ($this->request->is('post')) {
            $this->Campformula->create();
            if ($this->Campformula->save($this->request->data)) {
                $this->Session->setFlash('Fórmula de disputa do campeonato salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
        
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        
        $formula = $this->Campformula->findById($id);
        if (!$formula) {
            throw new NotFoundException(__('Fase inválida.'));
        }
        $this->set('formula', $formula);
    }
    
    function delete($id) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        if ($this->Campformula->delete($id)) {
            $this->Session->setFlash('Fórmula de disputa do campeonato com o id: ' . $id . ' foi deletada com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
