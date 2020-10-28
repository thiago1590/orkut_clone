<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class ComunidadeController extends Action {


    public function comunidades(){
		session_start();

		/*teste */
		$amigos = Container::getModel('Amigos');

		$amigos->__set('id_usuario', $_SESSION['id']);

		$this->view->friends = $amigos->getAllFriends();
		/*teste */

		$comunidade = Container::getModel('Comunidade');

		$comunidade->__set('id_usuario', $_SESSION['id']);

		$this->view->comunidade = $comunidade->getAllComunidades();
		$this->render('comunidades','layout2');
    }
    
	public function pesquisa_comunidade(){
		$this->render('pesquisa_comunidade','layout2');
    }
    
	public function comunidade_page(){
		$this->render('comunidade_page','layout2');
    }
    
    public function novo_topico(){
		$this->render('novo_topico','layout2');
	}

	public function forum(){
		$this->render('forum','layout2');
	}

	public function topico(){
		$this->render('topico','layout2');
	}

	
}