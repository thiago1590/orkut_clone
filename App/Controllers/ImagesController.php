<?php  
namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class ImagesController extends Action {

    public function addImage(){
		session_start();
		$usuario = Container::getModel('Usuario');

		$arquivo_nome = $this->decode($_POST['base64'],'thiago',$_SESSION['id'],"");

		$usuario->__set('id', $_SESSION['id']);
		$usuario->__set('imagem',$arquivo_nome);
		$usuario->setImagem();
		
		header("Location: /timeline");
    }

     
	public function addComunidadeImage(){
		session_start();
		$comunidade = Container::getModel('Comunidade');

		$arquivo_nome = $this->decode($_POST['base64'],'thiago',$_POST['id'],"_comunidade");

		$comunidade->__set('id', $_POST['id']);
		$comunidade->__set('imagem',$arquivo_nome);
		echo $comunidade->__get('id');
		echo "aaa";
		echo $comunidade->__get('imagem');
		$comunidade->setImagem();
		echo $_POST['id'];
		$image = $comunidade->__get('imagem');
		header("Location: /createComunidade2?image=$image");
	}

    
    public function decode ($code, $username,$name,$path) {
		list($type, $code) = explode(';', $code);
		list(, $code) = explode(',', $code);
		$code = base64_decode($code);
		file_put_contents('uploads/filename.jpg', $code);
		$arquivo_nome = $name .".jpg";
		file_put_contents('uploads'. $path . "/"  .$arquivo_nome, $code);
		return $arquivo_nome;
		}

}

    ?>