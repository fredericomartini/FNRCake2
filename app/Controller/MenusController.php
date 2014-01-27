<?php
class MenusController extends AppController {
    
    public $paginate = array(
        'fields' => array('id', 'nome'),
        'limit' => 20,
        'order' => array('Menu.menu' => 'asc', 'Menu.ordem' => 'asc' ),
    );

    public function index() {
        
        // Opções do filtro
        $opcoesFiltro = array(1 => 'Permissões', 2 => 'Gerais', 3 => 'Disputas', 4 => 'Campeonatos', 5 => 'Placar');
        $this->set('opcoesFiltro', $opcoesFiltro);
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'Menu.menu' => array(
                        'select' => $opcoesFiltro
                    )
                )
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        $this->Menu->recursive = -1;
        $this->set('menus', $this->paginate());
        
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Menu inválido.'));
        }

        $menu = $this->Menu->findById($id);
        if (!$menu) {
            throw new NotFoundException(__('Menu inválido.'));
        }
        $this->set('menu', $menu);
    }
    
    public function add() {
        
        $opcoes = array(1 => 'SIM', 2 => 'NAO');
        $this->set('opcoes', $opcoes);
        
        if ($this->request->is('post')) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash('Menu salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Menu inválido.'));
        }
        
        $opcoes = array(1 => 'SIM', 2 => 'NAO');
        $this->set('opcoes', $opcoes);

        $menu = $this->Menu->findById($id);
        if (!$menu) {
            throw new NotFoundException(__('Menu inválido.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Menu->id = $id;
            if (!array_key_exists("menu", $this->request->data["Menu"])) {
                $this->request->data["Menu"]["menu"] = "";
            }
            if (!array_key_exists("ordem", $this->request->data["Menu"])) {
                $this->request->data["Menu"]["ordem"] = "";
            }
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash('Menu alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $menu;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Menu->delete($id)) {
            $this->Session->setFlash('Menu com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}
?>
