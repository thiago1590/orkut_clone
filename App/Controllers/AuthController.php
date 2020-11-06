<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {


	public function autenticar() {
		
		$usuarioAuth = Container::getModel('Usuario');
		$usuarioAuth->__set('email', $_POST['email_auth']);
		$usuarioAuth->__set('senha', ($_POST['senha_auth']));
		
		$usuarioAuth->autenticar();

		if($usuarioAuth->__get('id') != '') {
			
			session_start();

			$_SESSION['id'] = $usuarioAuth->__get('id');
			$_SESSION['nome'] = $usuarioAuth->__get('nome');

			header('Location: /timeline');

		} else {
			header('Location: /?login=erro');
		}

	}

	public function sair() {
		session_start();
		session_destroy();
		header('Location: /');
	}

	
}