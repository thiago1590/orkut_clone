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
		$forum = Container::getModel('Forum');
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
		$forum->__set('id_comunidade',$_GET['id']);
		
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->view->seguindo = $comunidade->comunidade_seguindo_sn();
		$this->view->lastTopics = $forum->getLastTopics();
		$this->view->allTopics = $forum->getAllTopics();
		$this->view->membros = array_chunk($comunidade->getLast9membros(), 3);
		$this->view->total_membros = $comunidade->getAllMembros()[0]['total'];
		$this->render('comunidade_page','layout2');
	}

	public function createComunidade(){
		$comunidade = Container::getModel('Comunidade');
		$this->view->id = $comunidade->getLastId();
		$this->view->id = $this->view->id[0]['id'] + 1;
		$this->render('create_comunidade','layout2');
    }
	
	public function criarCom(){
		$comunidade = Container::getModel('Comunidade');
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id',$_SESSION['id']);
		$dono = $usuario->getInfoUsuario()['nome'];

		 if(isset($_FILES['imagem'])){
		 	$arquivo = $_FILES['imagem'];
		 	$extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
		 	$arquivo_nome = md5(uniqid($arquivo['name'])).".".$extensao;
		 	$diretorio = "uploads/";

			 move_uploaded_file($arquivo['tmp_name'],$diretorio.$arquivo_nome);
		 }

		$comunidade->__set('nome',$_POST['nome']);
		$comunidade->__set('categoria',$_POST['categoria']);
		$comunidade->__set('dono',$dono);
		$comunidade->__set('imagem',$arquivo_nome);
		$comunidade->__set('descricao',$_POST['descricao']);
		$comunidade->createComunidade();
		 }

	

    public function novo_topico(){
		$comunidade = Container::getModel('Comunidade');
		$comunidade->__set('id_comunidade',$_GET['id']);
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->view->seguindo = $comunidade->comunidade_seguindo_sn();
		$this->render('novo_topico','layout2');
	}

	public function forum(){
		$comunidade = Container::getModel('Comunidade');
		$comunidade->__set('id_comunidade',$_GET['id']);
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->view->seguindo = $comunidade->comunidade_seguindo_sn();
		$forum = Container::getModel('Forum');
		$forum->__set('id_comunidade',$_GET['id']);
		$this->view->allTopics = $forum->getAllTopics();
		$this->render('forum','layout2');
	}

	public function topico(){
		$this->render('topico','layout2');
	}

	public function criarTopico(){
		session_start();
		$forum = Container::getModel('Forum');
		$id = $_POST['id'];
		$forum->__set('id_comunidade',$id);
		$forum->__set('id_autor',$_SESSION['id']);
		$forum->__set('topico',$_POST['topico']);
		$forum->__set('mensagem',$_POST['mensagem']); 
		date_default_timezone_set('America/Sao_Paulo');
		$mes = date("m");
		$data = $this->setDate($mes);
		$forum->__set('data',$data); 
		$forum->criarTopico();
		header("Location: /comunidade_page?id=$id");
	}

	
	public function setDate($mes){
		$dia = date("d");

			switch ($mes) {
				case 1:
					$data = $dia . ' Jan';
					break;
				case 2:
					$data = $dia . ' Fev';
					break;
				case 3:
					$data = $dia . ' Março';
					break;
				case 4:
					$data = $dia . ' Abril';
					break;
				case 5:
					$data = $dia . ' Maio';
					break;
				case 6:
					$data = $dia . ' Jun';
					break;
				case 7:
					$data = $dia . ' Jul';
					break;	
				case 8:
					$data = $dia . ' Agosto';
					break;
				case 9:
					$data = $dia . ' Set';
					break;
				case 10:
					$data = $dia . ' Out';
					break;
				case 11:
					$data = $dia . ' Nov';
					break;
				case 12:
					$data = $dia . ' Dez';
					break;
			}
			return $data;
		

	}

	
}