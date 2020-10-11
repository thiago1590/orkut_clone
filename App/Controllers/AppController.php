<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {


	public function timeline() {

		$this->validaAutenticacao();

		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$this->view->info_usuario = $usuario->getInfoUsuario();
		$usuario->valida_sorte();
		$this->view->sorte = $usuario->get_sorte();
		$this->render('timeline','layout2');
		
	}

	public function perfil(){
		$this->render('perfil','layout2');
	}
	public function recados(){
		$this->render('recados','layout2');
	}
	public function amigos(){
		$this->render('amigos','layout2');
	}
	public function encontrar_amigos(){
		$this->render('encontrar_amigos','layout2');
	}
	
	
	


	public function validaAutenticacao() {

		session_start();

		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=erro');
		} 

	}
	

    
}

?>