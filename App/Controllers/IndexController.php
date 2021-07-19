<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {


	public function index() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->view->cadastro = isset($_GET['cadastro']) ? $_GET['cadastro'] : '';
		$this->render('index','layout1');
	}


	public function registrar() {

		$usuario = Container::getModel('Usuario');
		
		$data = $_POST['dia'] . ' de ' . $_POST['mes'] . ' de ' . $_POST['ano'];

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));
		$usuario->__set('sobrenome', $_POST['sobrenome']);
		$usuario->__set('dia', $_POST['dia']);
		$usuario->__set('mes', $_POST['mes']);
		$usuario->__set('ano', $_POST['ano']);
		$usuario->__set('data', $data);

		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->view->cadastro = isset($_GET['cadastro']) ? $_GET['cadastro'] : '';

		$this->view->nome = $_POST['nome'];

		if($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {
		
				$usuario->salvar();
				header('Location: /?cadastro=true');

		} else {

			$this->view->usuario = array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha'],
			);

			$this->view->erroCadastro = true;

			header('Location: /?cadastro=false');
		}

	}

}


?>