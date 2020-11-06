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

		$usuario = Container::getModel('Usuario');
		$usuario->__set('id', $_SESSION['id']);
		$this->view->info_usuario = $usuario->getInfoUsuario();

		$this->view->comunidade = $comunidade->getAllComunidades();
		$this->render('comunidades','layout2');
    }
   
	
    
	public function comunidade_page(){
		session_start();
		$comunidade = Container::getModel('Comunidade');
		$action = isset($_GET['action']) ? $_GET['action'] : "";

		if($action=='save'){
			$this->criarCom();
			$id = $comunidade->getLastId();
			
			$comunidade->__set('id_comunidade',$id[0]['id']);
		} else{
			$comunidade->__set('id_comunidade',  $_GET['id']);
		}

		$comunidade->__set('id_usuario',$_SESSION['id']);
		$comunidade->__set('id_comunidade',$_GET['id']);
		
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->view->seguindo = $comunidade->comunidade_seguindo_sn();
		$this->render('comunidade_page','layout2');
	}

	public function createComunidade(){
		$comunidade = Container::getModel('Comunidade');
		$this->render('create_comunidade','layout2');
    }
	
	public function criarCom(){
		$comunidade = Container::getModel('Comunidade');
		 if(isset($_FILES['imagem'])){
		 	$arquivo = $_FILES['imagem'];
		 	$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
		 	$arquivo_nome = md5(uniqid($arquivo['name'])).".".$extensao;
		 	$diretorio = "uploads/";

			 move_uploaded_file($arquivo['tmp_name'],$diretorio.$arquivo_nome);
		 }

		$comunidade->__set('nome',$_POST['nome']);
		$comunidade->__set('categoria',$_POST['categoria']);
		$comunidade->__set('imagem',$arquivo_nome);
		$comunidade->__set('descricao',$_POST['descricao']);
		$comunidade->createComunidade();
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