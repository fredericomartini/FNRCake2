<?php

class CampformclubesController extends AppController {
    
    function beforeFilter() {
        $this->loadModel('Campformula');
        $this->Campformclube->recursive = 0;
    }
    
    public function index() {
        
        $this->Campformula->recursive = 0;
        $campformulas = $this->Campformula->find('list', array(
            'fields' => array('id', 'campeonato_id'),
            'conditions' => array('ano' => date('Y'))
        ));
        
        $this->Campformula->Campeonato->recursive = -1;
        $campeonatos = $this->Campformula->Campeonato->find('list', array(
            'order' => 'nome_reduzido ASC', 
            'fields' => array('id', 'nome_reduzido'),
            'conditions' => array('Campeonato.id' => $campformulas)
        ));
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'campeonato_id' => array(
                        'select' => $campeonatos
                    )
                ),
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        $this->set('clubes', $this->paginate());
    }
    
    public function buscaClubes($chave, $ano) {
        $this->layout = 'ajax';
        if (array_key_exists("campeonato_id", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['campeonato_id'];
        }
        $this->Campformclube->recursive = 0;
        $campformclubes = $this->Campformclube->find('all', array(
            'fields' => array('Clube.id', 'Clube.nome_reduzido'),
            'conditions' => array('campeonato_id' => $catID, 'ano' => $ano),
            'order' => array('Clube.nome_reduzido' => 'asc')
        ));
        echo "<option value=\"\"></option>";
        foreach($campformclubes as $key => $subcat){ 
            echo "<option value=\"{$subcat['Clube']['id']}\">{$subcat['Clube']['nome_reduzido']}</option>";
        }
    }
    
    public function add() {
        
        $this->Campformula->recursive = 0;
        $campformulas = $this->Campformula->find('list', array(
            'fields' => array('id', 'campeonato_id'),
            'conditions' => array('ano' => date('Y'))
        ));
        
        $this->Campformula->Campeonato->recursive = -1;
        $campeonatos = $this->Campformula->Campeonato->find('list', array(
            'order' => 'nome_reduzido ASC', 
            'fields' => array('id', 'nome_reduzido'),
            'conditions' => array('Campeonato.id' => $campformulas)
        ));
        $this->set('campeonatos', $campeonatos);
        
        if ($this->request->is('post')) {
            $this->Campformclube->create();
            if ($this->Campformclube->save($this->request->data)) {
                $this->Session->setFlash('Clube salva com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
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
        $clubes = $this->Campformclube->findById($id);
        if (!$clubes) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        $this->set('clubes', $clubes);
    }
    
    function delete($id) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        if ($this->Campformclube->delete($id)) {
            $this->Session->setFlash('Clube retirado do campeonato com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>