<?php

App::uses('Controller', 'Controller');


class AppController extends Controller {
    
    public $components = array(
        'RequestHandler',
        'Session',
        'Acl',
        'Paginator',
        'Auth' => array(
            'authorize' => array(
                'Actions' => array('actionPath' => 'controllers')
            )
        ),
        'FilterResults.Filter' => array(
            'auto' => array(
                'paginate' => false,
                'explode'  => true,  // recomendado
            ),
            'explode' => array(
                'character'   => ' ',
                'concatenate' => 'AND',
            )
        ),
    );
    
    public $helpers = array(
        'Html', 
        'Form', 
        'Js', 
        'Session',
        'FilterResults.Search',
    );

    public function beforeFilter() {
        $this->Auth->allow('display');
        $this->Auth->loginAction = array('controller' => 'users', 'action' => 'login');
        $this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login');
        $this->Auth->loginRedirect = array('controller' => 'homes', 'action' => 'index');
    }
    
    function beforeRender(){
        $dadosUser = $this->Session->read();
        if (!empty($dadosUser['Auth']['User'])) {
            $this->loadModel('Group');
            $this->Group->recursive = 1;
            $menuCarregado = $this->Group->findById($dadosUser['Auth']['User']['group_id']);
            $this->set('menuCarregado' , $menuCarregado['Menu']);
        }
    }
      
    public function appError($error) {
        $this->redirect(array('controller' => 'homes', 'action' => 'index'));
    }
    
}
