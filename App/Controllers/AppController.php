<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {


	public function timeline() {

		$this->validaAutenticacao();

		$usuario = Container::getModel('Usuario');
		$amigos = Container::getModel('Amigos');
		$comunidade = Container::getModel('Comunidade');

		$usuario->__set('id', $_SESSION['id']);
		$amigos->__set('id_usuario', $_SESSION['id']);
		$comunidade->__set('id_usuario', $_SESSION['id']);

		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->view->info_usuarios = $usuario->getInfoUsuarios();
		$this->view->comunidades = $comunidade->getLastComunidades();
		$this->view->sorte = $usuario->get_sorte();
		$this->view->friends = array_chunk($amigos->getLast9Friends(), 3);
		$this->view->comunidade = array_chunk($comunidade->getLastComunidades(), 3);

		$usuario->valida_sorte();
		$this->render('timeline','layout2');
		
	}

	public function perfil(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$amigos = Container::getModel('Amigos');
		$comunidade = Container::getModel('Comunidade');

		$amigos->__set('id_usuario', $_SESSION['id']);
		$usuario->__set('id', $_SESSION['id']);
		$comunidade->__set('id_usuario', $_SESSION['id']);

		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->view->comunidades = $comunidade->getLastComunidades();
		$this->view->friends = array_chunk($amigos->getLast9Friends(), 3);
		$this->view->comunidade = array_chunk($comunidade->getLastComunidades(), 3);
		

		$this->render('perfil','layout2');
	}

	public function setRecado(){
		session_start();
		$recado = Container::getModel('Recados');
		$recado->__set('id', $_SESSION['id']);
		$recado->__set('recado', $_POST['recado']);
		$this->view->recados = $recado -> getRecados();
		$recado->setRecado();
		header("Location: /recados");
	}

	public function recados(){
		session_start();
		$recado = Container::getModel('Recados');
		$recado->__set('id', $_SESSION['id']);
		$this->view->recados = $recado -> getRecados();
		$this->render('recados','layout2');
	}
	public function amigos(){
		session_start();
		$amigos = Container::getModel('Amigos');

		$amigos->__set('id_usuario', $_SESSION['id']);

		$this->view->friends = $amigos->getAllFriends();
		$this->render('amigos','layout2');
	}
	public function encontrar_amigos(){
		$this->render('encontrar_amigos','layout2');
	}
	public function frase(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$usuario->__set('frase', $_POST['frase']);
		$usuario->set_frase();
		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->render('perfil','layout2');
	}
	
	
	
	


	public function validaAutenticacao() {

		session_start();

		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=erro');
		} 

	}
	

    
}

?>