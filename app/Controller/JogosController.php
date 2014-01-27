<?php

class JogosController extends AppController {
    

    /*
     * Situação do jogo:
     * 0 = Não Iniciado
     * 1 = 1o Tempo
     * 2 = Intervalo
     * 3 = 2o Tempo
     * 4 = Encerrado
     * 5 = Jogo Adiado
     */
    
    function beforeFilter() {
        $this->loadModel('Grupoclube');
        $this->Jogo->recursive = 0;
    }
    
    public function index() {
        
        $this->Grupoclube->recursive = 0;
        $campformulas = $this->Grupoclube->find('list', array(
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
        
        // Rodadas
        $filtroRodadas = array('' => '-- Rodada --');
        
        // Add filter
        $this->Filter->addFilters(
            array(
                'filter1' => array(
                    'campeonato_id' => array(
                        'select' => $campeonatos
                    ),
//                    'Jogo.datahora' => array(
//                        'value' => '2014-02-26 00:00:00'
//                    )
                ),
                'filter2' => array(
                    'Fase.id' => array(
                        'select' => $filtroFases
                    )
                ),
                'filter3' => array(
                    'Grupo.id' => array(
                        'select' => $filtroGrupos
                    )
                ),
                'filter4' => array(
                    'Rodada.id' => array(
                        'select' => $filtroRodadas
                    )
                ),
            )
        );

        $this->Filter->setPaginate('order', 'datahora ASC'); // optional
        $this->Filter->setPaginate('limit', 30);              // optional
        
        // Define conditions
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        
        $this->set('jogos', $this->paginate());
        
    }
    
    public function add() {
        
        $opcoes = array(1 => 'SIM', 2 => 'NAO');
        $this->set('opcoes', $opcoes);
        
        $this->Grupoclube->recursive = 0;
        $campformulas = $this->Grupoclube->find('list', array(
            'fields' => array('id', 'campeonato_id'),
            'conditions' => array('ano' => date('Y'))
        ));
        
        $this->Grupoclube->Campeonato->recursive = -1;
        $campeonatos = $this->Grupoclube->Campeonato->find('list', array(
            'order' => 'nome_reduzido ASC', 
            'fields' => array('id', 'nome_reduzido'),
            'conditions' => array('Campeonato.id' => $campformulas)
        ));
        $this->set('campeonatos', $campeonatos);
        
        if ($this->request->is('post')) {
            $this->Jogo->create();
            $this->request->data['Jogo']['datahora'] = substr($this->request->data['datajogo'],6,4) . "-" . substr($this->request->data['datajogo'],3,2) . "-" . substr($this->request->data['datajogo'],0,2) . " " . $this->request->data['horas'] . ":" . $this->request->data['minutos'] . ":00";
            if ($this->Jogo->save($this->request->data)) {
                $this->Session->setFlash('Jogo salvo com sucesso no grupo!', 'default', array('class' => 'mensagem_sucesso'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }
        
    }
    
    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Jogo inválido.'));
        }

        $jogo = $this->Jogo->findById($id);
        if (!$jogo) {
            throw new NotFoundException(__('Jogo inválido.'));
        }
        $this->set('jogo', $jogo);
    }
    
    public function edit($id = null, $acao = null) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        
        $opcoes = array(1 => 'SIM', 2 => 'NAO');
        $this->set('opcoes', $opcoes);
        
        $jogo = $this->Jogo->findById($id);
        if (!$jogo) {
            throw new NotFoundException(__('Jogo inválido.'));
        }
        $this->set('jogo', $jogo);
        
        $this->Jogo->Rodada->recursive = -1;
        $rodadas = $this->Jogo->Rodada->find('list', array(
            'order' => 'ordem ASC', 
            'fields' => array('id', 'nome'),
            'conditions' => array('Rodada.grupo_id' => $jogo['Jogo']['grupo_id'])
        ));
        $this->set('rodadas', $rodadas);

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Jogo->id = $id;
            $this->request->data['Jogo']['datahora'] = substr($this->request->data['datajogo'],6,4) . "-" . substr($this->request->data['datajogo'],3,2) . "-" . substr($this->request->data['datajogo'],0,2) . " " . $this->request->data['horas'] . ":" . $this->request->data['minutos'] . ":00";
            if ($this->Jogo->save($this->request->data)) {
                $this->Session->setFlash('Jogo alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                if (!$acao) {
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->redirect(array('action' => $acao));
                }
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $jogo;
        }
 
    }
    
    public function resultado($id = null, $acao = null) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        
        $jogo = $this->Jogo->findById($id);
        if (!$jogo) {
            throw new NotFoundException(__('Jogo inválido.'));
        }
        $this->set('jogo', $jogo);

        if ($this->request->is('post') || $this->request->is('put')) {
            
            $this->Jogo->id = $id;
            $this->request->data['Jogo']['gols_01'] = $this->request->data['golsmandante'];
            $this->request->data['Jogo']['gols_02'] = $this->request->data['golsvisitante'];
            $this->request->data['Jogo']['situacaojogo'] = $this->request->data['situacao'];
            if (isset($this->request->data['penaltis'])) {
                $this->request->data['Jogo']['penaltis'] = "S";
                $this->request->data['Jogo']['gols_penaltis_01'] = $this->request->data['penaltismandante'];
                $this->request->data['Jogo']['gols_penaltis_02'] = $this->request->data['penaltisvisitante'];
            } else {
                $this->request->data['Jogo']['penaltis'] = "N";
                $this->request->data['Jogo']['gols_penaltis_01'] = "";
                $this->request->data['Jogo']['gols_penaltis_02'] = "";
            }
            if ($this->Jogo->save($this->request->data)) {
                $this->Session->setFlash('Jogo alterado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
                if (!$acao) {
                    $this->redirect(array('action' => 'index'));
                } else {
                    $this->redirect(array('action' => $acao));
                }
            } else {
                $this->Session->setFlash('Não foi possível salvar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $jogo;
        }
        
    }
    
    function delete($id) {
        if (!$id) {
            throw new NotFoundException(__('Código inválido.'));
        }
        if ($this->Jogo->delete($id)) {
            $this->Session->setFlash('Jogo apagado com sucesso.', 'default', array('class' => 'mensagem_sucesso'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('Não foi possível apagar o registro. Por favor, tente novamente..', 'default', array('class' => 'mensagem_erro'));
        $this->redirect(array('action' => 'index'));
    }
    
    public function buscaFasesFiltro($chave, $campo) {
        $this->layout = 'ajax';
        if (array_key_exists($campo, $this->request->data[$chave])) {
            $campeonato = $this->request->data[$chave][$campo];
        }
        
        $this->loadModel('Campformula');
        $formula = $this->Campformula->find('list' , array('fields' => array('id', 'formula_id'),'conditions' => array('campeonato_id' => '1', 'ano' => date('Y'))));
        foreach($formula as $key => $subcat){
            $teste = $subcat;
        }
        $this->loadModel('Campformula');
        $formula = $this->Campformula->find('list' , array('fields' => array('id', 'formula_id'),'conditions' => array('campeonato_id' => $campeonato, 'ano' => date('Y'))));
        foreach($formula as $key => $subcat){
            $formula_id = $subcat;
        }
        $fases = $this->Jogo->Fase->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('formula_id' => $formula_id)));
        echo "<option value=\"\"></option>";
        foreach($fases as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function buscaGruposFiltro($chave, $campo) {
        $this->layout = 'ajax';
        if (array_key_exists($campo, $this->request->data[$chave])) {
            $catID = $this->request->data[$chave][$campo];
        }
        $grupos = $this->Jogo->Grupo->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('fase_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($grupos as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function buscaRodadasFiltro($chave, $campo) {
        $this->layout = 'ajax';
        if (array_key_exists($campo, $this->request->data[$chave])) {
            $catID = $this->request->data[$chave][$campo];
        }
        $rodadas = $this->Jogo->Rodada->find('list' , array('order' => 'ordem ASC','fields' => array('id', 'nome'),'conditions' => array('grupo_id' => $catID)));
        echo "<option value=\"\"></option>";
        foreach($rodadas as $key => $subcat){ 
            echo "<option value=\"{$key}\">{$subcat}</option>";
        }
    }
    
    public function classificacao() {
        $this->Grupoclube->recursive = 0;
        $campeonatos = $this->Grupoclube->find('all', array(
            'conditions' => array('ano' => date('Y'),
                                  'campeonato_id' => 10,
                                  'Grupoclube.formula_id' => 1,
                                  'Grupoclube.fase_id' => 1,
                                  'Grupoclube.grupo_id' => 5,
            ),
            'order' => array('Grupoclube.pontos' => 'desc',
                             'Grupoclube.saldo' => 'desc',
                             'Grupoclube.vitorias' => 'desc',
                             'Grupoclube.gols_pro' => 'desc',
                )
        ));
        $this->set('campeonatos', $campeonatos);
    }
    
    public function placarDoDia() {
        $this->paginate = array(
            'conditions' => array('Jogo.datahora BETWEEN ? AND ?' => array(date('Y-m-d'). ' 00:00:00', date('Y-m-d', strtotime("+1 day")). ' 03:00:00')),
            'limit' => 60,
            'order' => array('Campeonato.nome_reduzido' => 'asc', 'Fase.nome' => 'asc', 'Grupo.ordem' => 'asc', 'Rodada.ordem' => 'asc', 'Jogo.datahora' => 'asc'), 
        );
        $jogos = $this->paginate('Jogo');
        $this->set(compact('jogos'));
    }
    
    public function placarAoVivo() {
        $this->Grupoclube->recursive = 0;
        $campeonatos = $this->Grupoclube->find('all', array(
            'conditions' => array('ano' => date('Y'),
                                  'campeonato_id' => 10,
                                  'Grupoclube.formula_id' => 1,
                                  'Grupoclube.fase_id' => 1,
                                  'Grupoclube.grupo_id' => 5,
            ),
            'order' => array('Grupoclube.pontos' => 'desc',
                             'Grupoclube.saldo' => 'desc',
                             'Grupoclube.vitorias' => 'desc',
                             'Grupoclube.gols_pro' => 'desc',
                )
        ));
        $this->set('campeonatos', $campeonatos);
    }
}

?>
