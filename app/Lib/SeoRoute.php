<?php

//App::uses('Seo', 'Model');

class SeoRoute extends CakeRoute
{
	
	//O controller principal que recebe a url no caso de não existir um controller associado
	//Sem o Controller.php, ou seja para PagesController.php, apenas o Pages
	
	public $Controller_Default='Noticias';
	
	//A action principal que recebe a url no caso de não existir um action associado
	public $Action_Default='view';
	
	//Pego os controllers existentes
	
	function getControllers(){
		$controllers = App::objects('Controller');
		return $controllers;
	}
	
	//pega as actions do controller principal
	function getActions(){
		App::import('Controller', $this->Controller_Default);
		$className = $this->Controller_Default . 'Controller';
		$actions = get_class_methods($className);
		foreach($actions as $k => $v) {
			if ($v == $this->Action_Default||$v{0}=='_' ) {
				unset($actions[$k]);
			}
			if($v=='setRequest') break;
		}
		$parentActions = get_class_methods('AppController');
        $actions = array_diff($actions, $parentActions);
		return $actions;
	}
	
	//Verifico se os controllers existem
	
	function checkControllers($controller,$controllers){
		$controller = ucfirst($controller) . 'Controller';
		$check = false;
		if(in_array($controller,$controllers)) $check=true;
		return $check;
	}
	
	//retorno o array com a url digitada transformada em um array;
	
	function urlArray($url){
		if ($url==null)$url='/home';
		$parts=explode('/',$url);
		unset($parts[0]);
		return $parts;
	}
	
	//retorno o array com os parametros para o routes
	function urlReturn($parts){
		$controller=$parts[1];
		$action=(isset($parts[2]))?$parts[2]:false;
		
		if($this->checkControllers($controller,$this->getControllers())){
			$url['controller'] = $controller;
			$url['action']=($action)?$action:'index';
			unset($controller);
			unset($action);
		}else{
			$url['controller'] = $this->Controller_Default;
			if($action){
				if(in_array($action,$this->getActions())){
					$url['action']=$action;
				}else{
					$url['action']=$this->Action_Default;
				}
			}else{
				$url['action']=$this->Action_Default;
			}
		}
		unset($parts[1]);
		unset($parts[2]);
		if(isset($controller)){
			$url['pass'][0]='/'.$controller;
			if($action) $url['pass'][0].='/'.$action;
			foreach($parts as $key=>$value){
				$url['pass'][0].='/'.$value;
			}
			$url['pass'][0] = substr($url['pass'][0],1,strlen($url['pass'][0]));
		}else{
			foreach($parts as $key=>$value){
				$url['pass'][$key]=$value;
			}	
		}
		
		return $url;
	}
	
	public function parse($url){
		$parts=$this->urlArray($url);
		$routes=$this->urlReturn($parts);
		return $routes;
	}
}