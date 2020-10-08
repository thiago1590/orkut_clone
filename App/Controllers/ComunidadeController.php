<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class ComunidadeController extends Action {


    public function comunidades(){
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