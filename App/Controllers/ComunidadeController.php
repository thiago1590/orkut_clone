<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class ComunidadeController extends Action {


    public function comunidades(){
		session_start();

		$comunidade = Container::getModel('Comunidade');

		$comunidade->__set('id_usuario', $_SESSION['id']);

		$this->view->comunidade = $comunidade->getAllComunidades();
		$this->render('comunidades','layout2');
    }
    
	public function saveImage(){
		$comunidade = Container::getModel('Comunidade');
		if(isset($_FILES['arquivo'])){
			$arquivo = $_FILES['arquivo'];
			$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
			$arquivo_nome = md5(uniqid($arquivo['name'])).".".$extensao;
			$diretorio = "upload/";

			move_uploaded_file($arquivo['tmp_name'],$diretorio.$arquivo_nome);
		}
		$comunidade->__set('imagem',$arquivo_nome);
		$comunidade->saveImage();
	}
	
    
	public function comunidade_page(){
		if($_GET['action']=='save'){
			$this->criarCom();
		}
		$comunidade = Container::getModel('Comunidade');
		$comunidade->__set('id_comunidade',  $_GET['id']);
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->render('comunidade_page','layout2');
	}

	public function createComunidade(){
		$comunidade = Container::getModel('Comunidade');
		$this->render('create_comunidade','layout2');
    }
	
	public function criarCom(){
		$comunidade = Container::getModel('Comunidade');
		if(isset($_FILES['arquivo'])){
			$arquivo = $_FILES['arquivo'];
			$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
			$arquivo_nome = md5(uniqid($arquivo['name'])).".".$extensao;
			$diretorio = "upload/";

			move_uploaded_file($arquivo['tmp_name'],$diretorio.$arquivo_nome);

			$comunidade->__set('nome',$arquivo_nome);
		$comunidade->__set('categoria',$arquivo_nome);
		$comunidade->__set('imagem',$arquivo_nome);
		$comunidade->__set('descricao',$arquivo_nome);
		$comunidade->createComunidade();
	}
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