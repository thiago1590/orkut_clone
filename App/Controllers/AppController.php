<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {


	public function timeline() {

        /*
		$this->validaAutenticacao();
			
		//recuperação dos tweets
		$tweet = Container::getModel('Tweet');

		$tweet->__set('id_usuario', $_SESSION['id']);

		$tweets = $tweet->getAll();

		$this->view->tweets = $tweets;


		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);

		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->view->total_tweets = $usuario->getTotalTweets();
		$this->view->total_seguindo = $usuario->getTotalSeguindo();
		$this->view->total_seguidores = $usuario->getTotalSeguidores();
        */

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
	public function comunidades(){
		$this->render('comunidades','layout2');
	}
	


	public function validaAutenticacao() {

		session_start();

		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=erro');
		}	

    }
    
}

?>