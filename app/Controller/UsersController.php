<?php

class UsersController extends AppController {
    
//    public function initDB() {
//        $group = $this->User->Group;
//        //Allow admins to everything
//        $group->id = 3;
//        $this->Acl->allow($group, 'controllers');
//
//        //we add an exit to avoid an ugly "missing views" error message
//        echo "all done";
//        exit;
//    }
    
    
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->User->read(null, $this->Auth->user('id'));
                $this->User->saveField('ultimoacesso', date('Y-m-d H:i:s'));
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('Usuário ou senha inválido. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
        if ($this->Session->read('Auth.User')) {
            $this->Session->setFlash('Você está logado!');
            $this->redirect('/', null, false);
        }
    }

    public function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    public $paginate = array(
        'fields' => array('id', 'nome'),
        'limit' => 20,
        'order' => array('User.nome' => 'asc'),
    );

    public function index() {
        
        // busca grupos cadastrados
        $groups = $this->User->Group->find('list', array('order' => 'name ASC', 'fields' => array('Group.id', 'Group.name')));
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'User.group_id' => array(
                        'select' => $groups
                    )
                )
            )
        );

        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        $this->User->recursive = -1;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuário inválido'));
        }
        $this->set('user', $this->User->read(null, $id));
        
        $groups = $this->User->Group->find('list', array('order' => 'name ASC', 'fields' => array('Group.id', 'Group.name')));
        $this->set(compact('groups'));
    }

    public function add() {
        
        // busca grupos cadastrados
        $groups = $this->User->Group->find('list', array('order' => 'name ASC', 'fields' => array('Group.id', 'Group.name')));
        $this->set(compact('groups'));
        
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Usuário criado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuário inválido.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash('Usuário alterado com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível editar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
        
        // busca grupos cadastrados
        $groups = $this->User->Group->find('list', array('order' => 'name ASC', 'fields' => array('Group.id', 'Group.name')));
        $this->set(compact('groups'));
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Usuário inválido.'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash('Usuário excluído com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
}

?>
