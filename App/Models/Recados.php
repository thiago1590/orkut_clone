<?php 

namespace App\Models;
use MF\Model\Model;

class Recados extends Model {
    private $id;
    private $id_receptor;
    private $id_menssageiro;
    private $recado;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function setRecado(){
        $query = "insert into recados (id_receptor,id_menssageiro,recado) values
        (:id_receptor,:id_menssageiro,:recado)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_receptor', 1);
        $stmt->bindValue(':id_menssageiro',$this->__get('id'));
        $stmt->bindValue(':recado',$this->__get('recado'));
		$stmt->execute();

		return $this;
    }
    
    public function getRecados(){
        $query = "select u.nome, r.recado from 
        usuarios u join recados r on u.id = r.id_menssageiro 
        where u.id in (select id_menssageiro from recados where id_receptor = 1) 
        order by r.id desc";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    

    

    
}
?>