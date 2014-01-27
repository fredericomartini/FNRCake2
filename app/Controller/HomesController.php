<?php

class HomesController extends AppController {

    public $helpers = array('Html', 'Form', 'Js');
    
    public function index() {
        $this->set('title_for_layout', 'Home');
    }
    
}

?>
