<?php  
namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class ImagesController extends Action {

    public function addImage(){
		session_start();
		$usuario = Container::getModel('Usuario');

		$arquivo_nome = $this->decode($_POST['base64'],'thiago');

		$usuario->__set('id', $_SESSION['id']);
		$usuario->__set('imagem',$arquivo_nome);
		$usuario->setImagem();
		
		header("Location: /timeline");
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
    
    public function decode ($code, $username) {
		list($type, $code) = explode(';', $code);
		list(, $code) = explode(',', $code);
		$code = base64_decode($code);
		file_put_contents('uploads/filename.jpg', $code);
		$arquivo_nome = $_SESSION['id'].".jpg";
		file_put_contents('uploads/'.$arquivo_nome, $code);
		return $arquivo_nome;
		}

}

    ?>