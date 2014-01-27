<?php

App::uses('File', 'Utility');

class ClubesController extends AppController {
    
    function beforeFilter() {
        $this->loadModel('Paise');
        $this->loadModel('Estado');
        $this->Clube->recursive = 0;
    }
    
    public $paginate = array(
        'fields' => array('Clube.id', 'Clube.nome_reduzido'),
        'order' => array('Clube.nome_reduzido' => 'asc')
    );

    public function index() {
        $this->Clube->recursive = -1;
        $this->Paginator->settings = array(
            'limit' => 20,
            'fields' => array('Clube.id', 'Clube.nome_reduzido'),
        'order' => array('Clube.nome_reduzido' => 'asc')
        );
        $this->set('clubes', $this->Paginator->paginate('Clube'));
    }
    
    public function buscaClubesParticipantes($chave) {
        $this->layout = 'ajax';
        if (array_key_exists("campeonato_id", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['campeonato_id'];
        }
        $this->loadModel('Campeonato');
        $this->Campeonato->recursive = 0;
        $campeonato = $this->Campeonato->find('all', array(
            'fields' => array('id', 'Nivei.tipo', 'Campeonato.paise_id', 'Campeonato.estado_id'),
            'conditions' => array('Campeonato.id' => $catID)
        ));
        if ($campeonato[0]['Nivei']['tipo'] == 'I') {
            $this->Clube->recursive = -1;
            $clubes = $this->Clube->find('all', array(
                'fields' => array('Clube.id', 'Clube.nome_reduzido'),
                'order' => array('Clube.nome_reduzido' => 'asc')
            ));
            echo "<option value=\"\"></option>";
            foreach($clubes as $key => $subcat){ 
                echo "<option value=\"{$subcat['Clube']['id']}\">{$subcat['Clube']['nome_reduzido']}</option>";
            }
        } elseif ($campeonato[0]['Nivei']['tipo'] == 'N') {
            $this->Clube->recursive = 0;
            $clubes = $this->Clube->find('all', array(
                'order' => 'Clube.nome_reduzido ASC', 
                'fields' => array('Clube.id', 'Clube.nome_reduzido', 'Cidade.estado_id')
            ));
            echo "<option value=\"\"></option>";
            $this->Estado->recursive = -1;
            foreach($clubes as $key => $subcat){
                $pais = $this->Estado->findById($subcat['Cidade']['estado_id']);
                if ($pais['Estado']['paise_id'] == $campeonato[0]['Campeonato']['paise_id']) {
                    echo "<option value=\"{$subcat['Clube']['id']}\">{$subcat['Clube']['nome_reduzido']}</option>";
                }
            }
        } elseif ($campeonato[0]['Nivei']['tipo'] == 'E') {
            $this->Clube->recursive = 0;
            $clubes = $this->Clube->find('all', array(
                'fields' => array('Clube.id', 'Clube.nome_reduzido'),
                'order' => array('Clube.nome_reduzido' => 'asc'),
                'conditions' => array('Cidade.estado_id' => $campeonato[0]['Campeonato']['estado_id'])
            ));
            echo "<option value=\"\"></option>";
            foreach($clubes as $key => $subcat){ 
                echo "<option value=\"{$subcat['Clube']['id']}\">{$subcat['Clube']['nome_reduzido']}</option>";
            }
        }
    }
    
    public function buscaClubesJogos($chave, $ano, $campeonatoID) {
        $this->layout = 'ajax';
        $this->loadModel('Grupoclube');
        $this->Grupoclube->recursive = 0;
        $jogosentregrupos = $this->Grupoclube->find('all', array(
            'fields' => array('id', 'Fase.jogosentregrupos'),
            'limit' => 1,
            'conditions' => array('campeonato_id' => $campeonatoID, 
                                  'ano' => $ano,
                                  'grupo_id' => $this->request->data[$chave]['grupo_id'],
                            )
        ));
        if ($jogosentregrupos[0]['Fase']['jogosentregrupos'] == 1) {
            $this->loadModel('Campformclube');
            $this->Campformclube->recursive = 0;
            $clubes = $this->Campformclube->find('all', array(
                'fields' => array('Clube.id', 'Clube.nome_reduzido'),
                'conditions' => array('campeonato_id' => $campeonatoID, 'ano' => $ano),
                'order' => array('Clube.nome_reduzido' => 'asc')
            ));
            echo "<option value=\"\"></option>";
            foreach($clubes as $key => $subcat){ 
                echo "<option value=\"{$subcat['Clube']['id']}\">{$subcat['Clube']['nome_reduzido']}</option>";
            }
        } elseif ($jogosentregrupos[0]['Fase']['jogosentregrupos'] == 2) {
            $clubes = $this->Grupoclube->find('all', array(
                'fields' => array('Clube.id', 'Clube.nome_reduzido'),
                'conditions' => array('campeonato_id' => $campeonatoID, 
                                      'ano' => $ano,
                                      'grupo_id' => $this->request->data[$chave]['grupo_id'],
                                ),
                'order' => 'Clube.nome_reduzido ASC', 
            ));
            echo "<option value=\"\"></option>";
            foreach($clubes as $key => $subcat){ 
                echo "<option value=\"{$subcat['Clube']['id']}\">{$subcat['Clube']['nome_reduzido']}</option>";
            }
        } else {
            echo "<option value=\"\"></option>";
        }
        
    }
    
    public function buscaEstadio($chave) {
        $this->layout = 'ajax';
        if (array_key_exists("clube_id_01", $this->request->data[$chave])) {
            $catID = $this->request->data[$chave]['clube_id_01'];
        }
        $this->Clube->recursive = -1;
        $estadio = $this->Clube->find('list', array(
            'fields' => array('id', 'estadio'),
            'conditions' => array('id' => $catID)
        ));
        foreach($estadio as $key => $subcat){ 
            echo $subcat;
        }
    }
    
    /**
    * FUNCTION CRIADA POR FRED EM 22-05-2013
    * LISTA OS CLUBES DA CIDADE PASSADA COMO PARAMETRO
    */
    public function buscaClubes($chave){
        $this->layout = 'ajax';
       	$catID = $this->request->data[$chave]['cidade_id'];
        $clubes = $this->Clube->find('list' , array('fields' => array('Clube.id', 'Clube.nome_completo'),'conditions' => array('Clube.cidade_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($clubes as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        
        $clube = $this->Clube->findById($id);
        if (!$clube) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        $this->set('clube', $clube);
        
        $this->Estado->recursive = 0;
        $estado = $this->Estado->findById($clube['Cidade']['estado_id']);
        if (!$estado) {
            throw new NotFoundException(__('Estado inválido.'));
        }
        $this->set('estado', $estado);
        
    }
    
    public function add() {
        
        $this->Paise->recursive = -1;
        $paises = $this->Paise->find('list', array('order' => 'nome ASC', 'fields' => array('Paise.id', 'Paise.nome')));
        $this->set(compact('paises'));
        
        if ($this->request->is('post')) {
            
            $this->Clube->create();
            
            if ($this->Clube->save($this->request->data)) {
                
                $id = $this->Clube->getLastInsertID();
                $this->Clube->id = $id;
                
                if ($this->request->data['Clube']['simbolo']['error'] == 0) {
                    $nome_arquivo = "simb_" . $id . "." . substr($this->request->data['Clube']['simbolo']['type'],6,3);
                    $arquivo = new File($this->request->data['Clube']['simbolo']['tmp_name'],false);
                    $imagem = $arquivo->read();
                    $arquivo->close();
                    $arquivo = new File(WWW_ROOT.'img/clubes/simbolos/' . $nome_arquivo, false ,0777);
                    if($arquivo->create()) {
                        $arquivo->write($imagem);
                        $arquivo->close();
                    }
                    $this->request->data['Clube']['img_simbolo'] = $nome_arquivo;
                }
                
                if ($this->request->data['Clube']['simbolo_pq']['error'] == 0) {
                    $nome_arquivo = "simb_" . $id . "." . substr($this->request->data['Clube']['simbolo_pq']['type'],6,3);
                    $arquivo = new File($this->request->data['Clube']['simbolo_pq']['tmp_name'],false);
                    $imagem = $arquivo->read();
                    $arquivo->close();
                    $arquivo = new File(WWW_ROOT.'img/clubes/simbolos_pq/' . $nome_arquivo, false ,0777);
                    if($arquivo->create()) {
                        $arquivo->write($imagem);
                        $arquivo->close();
                    }
                    $this->request->data['Clube']['img_simbolo_pq'] = $nome_arquivo;
                }
                
                if ($this->request->data['Clube']['superior']['error'] == 0) {
                    $nome_arquivo = "sup_" . $id . "." . substr($this->request->data['Clube']['superior']['type'],6,3);
                    $arquivo = new File($this->request->data['Clube']['superior']['tmp_name'],false);
                    $imagem = $arquivo->read();
                    $arquivo->close();
                    $arquivo = new File(WWW_ROOT.'img/clubes/superiores/' . $nome_arquivo, false ,0777);
                    if($arquivo->create()) {
                        $arquivo->write($imagem);
                        $arquivo->close();
                    }
                    $this->request->data['Clube']['img_superior'] = $nome_arquivo;
                }
                
                $this->Clube->save($this->request->data);
                $this->Session->setFlash('Clube salvo com sucesso!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
                
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
    }
    
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        
        $clube = $this->Clube->findById($id);
        if (!$clube) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Clube->id = $id;
            
            if ($this->request->data['Clube']['simbolo']['error'] == 0) {
                // Apaga a imagem antiga
                if (!empty($clube['Clube']['img_simbolo'])) {
                    $img_antiga = new File(WWW_ROOT.'img/clubes/simbolos/' . $clube['Clube']['img_simbolo'], true, 0755);
                    $img_antiga->delete();
                }
                // Insere a imagem nova
                $nome_arquivo = "simb_" . $id . "." . substr($this->request->data['Clube']['simbolo']['type'],6,3);
                $arquivo = new File($this->request->data['Clube']['simbolo']['tmp_name'],false);
                $imagem = $arquivo->read();
                $arquivo->close();
                $arquivo = new File(WWW_ROOT.'img/clubes/simbolos/' . $nome_arquivo, false ,0777);
                if($arquivo->create()) {
                    $arquivo->write($imagem);
                    $arquivo->close();
                }
                $this->request->data['Clube']['img_simbolo'] = $nome_arquivo;
            } else {
                $this->Clube->validator()->remove('simbolo');
            }
            
            if ($this->request->data['Clube']['simbolo_pq']['error'] == 0) {
                // Apaga a imagem antiga
                if (!empty($clube['Clube']['img_simbolo_pq'])) {
                    $img_antiga = new File(WWW_ROOT.'img/clubes/simbolos_pq/' . $clube['Clube']['img_simbolo_pq'], true, 0755);
                    $img_antiga->delete();
                }
                // Insere a imagem nova
                $nome_arquivo = "simb_" . $id . "." . substr($this->request->data['Clube']['simbolo_pq']['type'],6,3);
                $arquivo = new File($this->request->data['Clube']['simbolo_pq']['tmp_name'],false);
                $imagem = $arquivo->read();
                $arquivo->close();
                $arquivo = new File(WWW_ROOT.'img/clubes/simbolos_pq/' . $nome_arquivo, false ,0777);
                if($arquivo->create()) {
                    $arquivo->write($imagem);
                    $arquivo->close();
                }
                $this->request->data['Clube']['img_simbolo_pq'] = $nome_arquivo;
            } else {
                $this->Clube->validator()->remove('simbolo_pq');
            }
            
            if ($this->request->data['Clube']['superior']['error'] == 0) {
                // Apaga a imagem antiga
                if (!empty($clube['Clube']['img_superior'])) {
                    $img_antiga = new File(WWW_ROOT.'img/clubes/superiores/' . $clube['Clube']['img_superior'], true, 0755);
                    $img_antiga->delete();
                }
                // Insere a imagem nova
                $nome_arquivo = "sup_" . $id . "." . substr($this->request->data['Clube']['superior']['type'],6,3);
                $arquivo = new File($this->request->data['Clube']['superior']['tmp_name'],false);
                $imagem = $arquivo->read();
                $arquivo->close();
                $arquivo = new File(WWW_ROOT.'img/clubes/superiores/' . $nome_arquivo, false ,0777);
                if($arquivo->create()) {
                    $arquivo->write($imagem);
                    $arquivo->close();
                }
                $this->request->data['Clube']['img_superior'] = $nome_arquivo;
            } else {
                $this->Clube->validator()->remove('superior');
            }
            
            if ($this->Clube->save($this->request->data)) {
                $this->Session->setFlash('Clube alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $clube;
        }
    }
    
    function delete($id) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        
        $clube = $this->Clube->findById($id);
        if (!$clube) {
            throw new NotFoundException(__('Clube inválido.'));
        }
        
        if ($this->Clube->delete($id)) {
            if (!empty($clube['Clube']['img_simbolo'])) {
                $arquivo = new File(WWW_ROOT.'img/clubes/simbolos/' . $clube['Clube']['img_simbolo'], true, 0755);
                $arquivo->delete();
            }
            if (!empty($clube['Clube']['img_superior'])) {
                $arquivo = new File(WWW_ROOT.'img/clubes/superiores/' . $clube['Clube']['img_superior'], true, 0755);
                $arquivo->delete();
            }            
            $this->Session->setFlash('Clube com o id: ' . $id . ' foi deletado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
}
?>
