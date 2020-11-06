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
		$this->view->friends_number = count($amigos->getAllFriends());
		$this->view->comunidades_number = count($comunidade->getAllComunidades());
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
		$this->view->info_usuarios = $usuario->getInfoUsuarios();
		$this->view->comunidades = $comunidade->getLastComunidades();
		$this->view->friends = array_chunk($amigos->getLast9Friends(), 3);
		$this->view->friends_number = count($amigos->getAllFriends());
		$this->view->comunidades_number = count($comunidade->getAllComunidades());
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

		
		$pagina = isset($_GET['p']) ? $_GET['p'] : "";
		$this->view->proxima = $_GET['p'] + 1;
		$this->view->anterior = $_GET['p'] - 1;
		if($_GET['p'] == 0){
			$this->view->anterior = null;
		}
		if($_GET['p'] ==  count(array_chunk($usuario->pesquisar(), 10))){
			$this->view->próxima = null;
		}
		if($_GET['exp'] == 1 ){
			$this->view->infos = array_chunk($usuario->pesquisar(), 10);
		}
		if($_GET['exp'] == 2 ){

			$this->view->infos = array_chunk($comunidade->pesquisar(), 10);
		}
		$this->render('pesquisar','layout2');
    }

	public function acao(){
		session_start();
		$amigos = Container::getModel('Amigos');
		$recado = Container::getModel('Recados');
		$comunidade = Container::getModel('Comunidade');
		$usuario = Container::getModel('Usuario');
		$amigos->__set('id_usuario', $_SESSION['id']);

		$acao = isset($_GET['acao']) ? $_GET['acao'] : "";
		$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : "";
		echo $acao;

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
		if($acao == "participar"){
			$id_comunidade = $_GET['id'];
			$comunidade->__set('id_usuario',$_SESSION['id']);
			$comunidade->__set('id_comunidade',$id_comunidade);
			$comunidade->participar();
			header("Location: /comunidade_page?id=$id_comunidade");
		} 
		if($acao == "deixar_de_participar"){
			$id_comunidade = $_GET['id'];
			$comunidade->__set('id_usuario',$_SESSION['id']);
			$comunidade->__set('id_comunidade',$id_comunidade);
			$comunidade->deixar_de_participar();
			header("Location: /comunidade_page?id=$id_comunidade");
		} 
		if($acao == "save"){
			$usuario->__set('id', $_SESSION['id']);
			$data = $_POST['dia'] . ' de ' . $_POST['mes'] . ' de ' . $_POST['ano'];
			$usuario->__set('nome', $_POST['nome']);
			$usuario->__set('sobrenome', $_POST['sobrenome']);
			$usuario->__set('data', $data);
			$usuario->editar_perfil();
			echo $usuario->__get('id');
			echo $usuario->__get('nome');
			echo $usuario->__get('sobrenome');
			echo $usuario->__get('data');
			header("Location: /editar_perfil");
		} 
	}


}

?>