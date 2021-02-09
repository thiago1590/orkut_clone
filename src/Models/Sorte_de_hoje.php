<?php 

namespace App\Models;
use MF\Model\Model;

class Sorte_de_hoje extends Model {
    private $frase;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }
    
}
?>