<?php

class GroupsController extends AppController {
    
    public $paginate = array(
        'fields' => array('Group.id', 'Group.name'),
        'order' => array('Group.name' => 'asc'),
        'limit' => 20,
    );

    public function index() {
        $this->Group->recursive = -1;
        $this->set('groups', $this->paginate());
    }
    
    public function add() {
        
        $menus = $this->Group->Menu->find('list',array('fields'=>array('id','nome'),'order'=>array('Menu.menu' => 'asc','Menu.ordem' => 'asc')));
        $this->set(compact('menus'));
        
        if ($this->request->is('post')) {
            $this->Group->create();
            if ($this->Group->save($this->request->data)) {
                
                //Dando permissões
                $group = $this->Group;
                $group->id = $this->Group->id;
                $this->permissoes($group, $this->request->data['Menu']['Menu']);
                
                $this->Session->setFlash('Grupo salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Grupo inválido.'));
        }

        $group = $this->Group->findById($id);
        
        if (!$group) {
            throw new NotFoundException(__('Grupo inválido.'));
        }
        
        $this->set('group', $group);
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Grupo inválido.'));
        }
        
        $menus = $this->Group->Menu->find('list',array('fields'=>array('id','nome'),'order'=>array('Menu.menu' => 'asc','Menu.ordem' => 'asc')));
        $this->set(compact('menus'));

        $group = $this->Group->findById($id);
        if (!$group) {
            throw new NotFoundException(__('Grupo inválido.'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Group->id = $id;
            if ($this->Group->save($this->request->data)) {
                
                //Dando permissões
                $group = $this->Group;
                $group->id = $this->Group->id;
                $this->permissoes($group, $this->request->data['Menu']['Menu']);
                
                $this->Session->setFlash('Grupo alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
                
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $group;
        }
    }
    
    function permissoes($group, $escolhidos) {

        $menusTabela = $this->Group->Menu->find('all');
        
        $this->Acl->deny($group, 'controllers');
                
        // bloqueia o acesso a todos os menus
        foreach ($menusTabela as $menuGeral):
            $bloqueiaMenu = 'controllers/' . $menuGeral['Menu']['controller'];
            $this->Acl->deny($group, $bloqueiaMenu);
        endforeach;
        
        // libera o acesso as ações principais
        $this->Acl->allow($group, 'controllers/Homes');
        $this->Acl->allow($group, 'controllers/Users/logout');
        $this->Acl->allow($group, 'controllers/Users/login');
        
        // libera o acesso as ações selecionadas na list
        foreach ($escolhidos as $menu):
            $libera = $this->Group->Menu->findById($menu);
            $liberaMenu = 'controllers/' . $libera['Menu']['controller'];
            $this->Acl->allow($group, $liberaMenu);
        endforeach;
        
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Group->delete($id)) {
            $this->Session->setFlash('Grupo com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}

?>
