<?php

class GrupoclubesController extends AppController {
    
    function beforeFilter() {
        $this->loadModel('Campformula');
        $this->loadModel('Campformclube');
        $this->Grupoclube->recursive = 0;
    }
    
    public function index() {
        
        $this->Campformula->recursive = 0;
        $campformulas = $this->Campformula->find('list', array(
            'fields' => array('id', 'campeonato_id'),
            'conditions' => array('ano' => date('Y'))
        ));
        
        $this->Grupoclube->Campeonato->recursive = -1;
        $campeonatos = $this->Grupoclube->Campeonato->find('list', array(
            'order' => 'nome_reduzido ASC', 
            'fields' => array('id', 'nome_reduzido'),
            'conditions' => array('Campeonato.id' => $campformulas)
        ));
        
        // Fases
        $filtroFases = array('' => '-- Fase --');
        
        // Grupos
        $filtroGrupos = array('' => '-- Grupo --');
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Grupoclube.campeonato_id' => array(
                        'select' => $campeonatos
                    )
                ),
                'filter2' => array(
                    'Grupoclube.fase_id' => array(
                        'select' => $filtroFases
                    )
                ),
                'filter3' => array(
                    'Grupoclube.grupo_id' => array(
                        'select' => $filtroGrupos
                    )
                ),
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        // Ordenação
        $this->Filter->setPaginate('order' , array('Campeonato.nome_reduzido' => 'asc', 'Grupo.ordem' => 'asc', 'Clube.nome_reduzido' => 'asc'));
        
        $this->set('clubes', $this->paginate());
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
            $this->Grupoclube->create();
            if ($this->Grupoclube->save($this->request->data)) {
                $this->Session->setFlash('Clube salvo com sucesso no grupo!', 'default', array('class' => 'mensagem_sucesso'));
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
        $clubes = $this->Grupoclube->findById($id);
        if (!$clubes) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        $this->set('clubes', $clubes);
    }
    
    function delete($id) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        if ($this->Grupoclube->delete($id)) {
            $this->Session->setFlash('Clube retirado do grupo com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
