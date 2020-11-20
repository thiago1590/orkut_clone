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
		$topicos = Container::getModel('Topicos');
		$respostas = Container::getModel('Respostas');
		$action = isset($_GET['action']) ? $_GET['action'] : "";

		$comunidade->__set('id_comunidade',  $_GET['id']);
		$comunidade->__set('id_usuario',$_SESSION['id']);
		$comunidade->__set('id_comunidade',$_GET['id']);
		$respostas->__set('id_comunidade',$_GET['id']);
		$topicos->__set('id_comunidade',$_GET['id']);
		
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->view->seguindo = $comunidade->comunidade_seguindo_sn();
		$this->view->lastTopics = $topicos->getLastTopics();
		$this->view->allTopics = $topicos->getTopics();
		$this->view->membros = $comunidade->getLast9membros();
		$this->view->total_membros = $comunidade->getAllMembros()[0]['total'];
		$this->view->lastRespostaData = $respostas->getLastRespostaData();
		$this->render('comunidade_page','layout2');
	}

	public function createComunidade(){
		$comunidade = Container::getModel('Comunidade');
		$this->view->id = $comunidade->getLastId();
		$this->view->id = $this->view->id[0]['id'] + 1;
		$this->render('create_comunidade','layout2');
	}
	public function createComunidade2(){
		if(!isset($_GET['image'])){
			$this->criarComunidade();
		}
		
		$comunidade = Container::getModel('Comunidade');

		$this->view->id = $comunidade->getLastId();
		$this->view->id = $this->view->id[0]['id'];
		$this->render('create_comunidade2','layout2');
    }
	
	public function criarComunidade(){
		if(!isset($_SESSION)){
			session_start();
		}
		$comunidade = Container::getModel('Comunidade');
		$usuario = Container::getModel('Usuario');
		$usuario->__set('id',$_SESSION['id']);
		$dono = $usuario->getInfoUsuario()['nome'];

		$comunidade->__set('nome',$_POST['nome']);
		$comunidade->__set('categoria',$_POST['categoria']);
		$comunidade->__set('dono',$dono);
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
		$topicos = Container::getModel('Topicos');
		$topicos->__set('id_comunidade',$_GET['id']);
		$this->view->allTopics = $topicos->getTopics();
		$this->render('forum','layout2'); 
	}

	public function topico(){
		session_start();
		$respostas = Container::getModel('Respostas');
		$comunidade = Container::getModel('Comunidade');
		$comunidade->__set('id_comunidade',$_GET['id']);
		$respostas->__set('id_topico',$_GET['id_topico']);
		$this->view->comunidades = $comunidade->getComunidadesInfo();
		$this->view->seguindo = $comunidade->comunidade_seguindo_sn();
		$this->view->respostas = $respostas->getRespostas();
		$this->render('topico','layout2');
	}

	public function criarTopico(){
		session_start();
		$topicos = Container::getModel('Topicos');
		$respostas = Container::getModel('Respostas');
		$id_comunidade = $_POST['id'];
		
		if($_GET['id_topico'] == null || $_GET['id_topico'] == ""){
		$topicos->__set('id_comunidade',$id_comunidade);
		$topicos->__set('id_autor',$_SESSION['id']);
		$topicos->__set('topico',$_POST['topico']);
		$topicos->criarTopico();
		$id_topico = $topicos->getLastId()[0]['MAX(id)'];
		} else{$id_topico = $_GET['id_topico'];}
		
		$respostas->__set('mensagem',$_POST['mensagem']); 
		$respostas->__set('id_autor',$_SESSION['id']);
		$respostas->__set('id_topico',$id_topico);

		date_default_timezone_set('America/Sao_Paulo');
		$mes = date("m");
		$data = $this->setDate($mes);
		
		$respostas->__set('data',$data);
		
		$respostas->setResposta();
		echo $id_topico;
		header("Location: /comunidade_page?id=$id_comunidade");
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