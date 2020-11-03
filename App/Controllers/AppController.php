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
		$user_id = $submit_id =
		$usuario = Container::getModel('Usuario');
		$amigos = Container::getModel('Amigos');
		$comunidade = Container::getModel('Comunidade');

		$amigos->__set('id',  $_SESSION['id']);
		$amigos->__set('id_usuario',  $_GET['id']);
		$usuario->__set('id',  $_GET['id']);
		$comunidade->__set('id_usuario',  $_GET['id']);

		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->view->comunidades = $comunidade->getLastComunidades();
		$this->view->friends = array_chunk($amigos->getLast9Friends(), 3);
		$this->view->comunidade = array_chunk($comunidade->getLastComunidades(), 3);
		$this->view->seguindo = $amigos->usuario_seguindo_sn($amigos->__get('id_usuario'));


		$this->render('perfil','layout2');
	}

	public function setRecado(){
		session_start();
		$recado = Container::getModel('Recados');
		$id = $_GET['id'];
		$recado->__set('id_menssageiro', $_SESSION['id']);
		$recado->__set('id_receptor', $id);
		$recado->__set('recado', $_POST['recado']);
		$this->view->recados = $recado -> getRecados();
		$recado->setRecado();
		$recado->resetId();
		header("Location: /recados?id=$id");
	}

	public function recados(){
		session_start();
		$recado = Container::getModel('Recados');
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$recado->__set('id_menssageiro', $_SESSION['id']);
		$recado->__set('id_receptor', $_GET['id']);
		$this->view->recados = $recado -> getRecados();
		$this->view->info_usuario = $usuario->getInfoUsuario();

		$this->render('recados','layout2');
	}
	public function amigos(){
		session_start();
		$amigos = Container::getModel('Amigos');
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$amigos->__set('id_usuario', $_SESSION['id']);
		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->view->friends = $amigos->getAllFriends();
		$this->render('amigos','layout2');
	}
	public function encontrar_amigos(){
		$this->render('encontrar_amigos','layout2');
	}

	public function editar_perfil(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->render('editar_perfil','layout2');
	}

	public function frase(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$usuario->__set('frase', $_POST['frase']);
		$usuario->set_frase();
		$this->view->info_usuario = $usuario->getInfoUsuario();
		$id = $_SESSION['id'];
		header("Location: /perfil?id=$id");
	}

	public function validaAutenticacao() {

		session_start();

		if(!isset($_SESSION['id']) || $_SESSION['id'] == '' || !isset($_SESSION['nome']) || $_SESSION['nome'] == '') {
			header('Location: /?login=erro');
		}

	}

	public function pesquisar(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$comunidade = Container::getModel('Comunidade');

		$usuario->__set('id', $_SESSION['id']);
		$usuario->__set('pesquisa', $_GET['q']);
		$comunidade->__set('pesquisa', $_GET['q']);
		$this->view->info_usuario = $usuario->getInfoUsuario();
		$this->view->exp = $_GET['exp'];

		if($_GET['exp'] == 1 ){
			$this->view->infos = $usuario->pesquisar();
		}
		if($_GET['exp'] == 2 ){
			$this->view->infos = $comunidade->pesquisar();
		}
		
		$this->render('pesquisar','layout2');
    }

	public function acao(){
		session_start();
		$amigos = Container::getModel('Amigos');
		$recado = Container::getModel('Recados');
		$amigos->__set('id_usuario', $_SESSION['id']);

		$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
		$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : "";


		if($acao == "seguir"){
			$amigos->seguir($id_usuario_seguindo);
			header("Location: /perfil?id=$id_usuario_seguindo");
		} 
		if($acao == "deixar_de_seguir"){
			$amigos->deixar_de_seguir($id_usuario_seguindo);
			header("Location: /perfil?id=$id_usuario_seguindo");
		} 
		if($acao == "apagar"){
		$id_recado = $_GET['id_recado'];
		$this->view->recados = $recado -> getRecados();
		$id_recado = count($this->view->recados) - ($id_recado -1);
		echo $id_recado;
			$recado->__set('id',$id_recado);
			$recado->deleteRecado();
			$id = $_GET['id'];
			$recado->resetId();
			header("Location:/recados?id=$id");
		}
	}


}

?>