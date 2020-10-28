<?php 

namespace App\Models;
use MF\Model\Model;

class Comunidade extends Model {
    private $id;
    private $id_usuario;
    private $id_comunidade;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function getLastComunidades(){
      $query = "select u.nome 
      from usuarios u join comunidade c on u.id = c.id_usuario
       where u.id in
       (select id_comunidade from comunidade where id_usuario = :id) 
       order by 
       u.id desc limit 9";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllComunidades(){
      $query = "select u.nome 
      from usuarios u join comunidade c on u.id = c.id_usuario
       where u.id in
       (select id_comunidade from comunidade where id_usuario = :id) 
       order by 
       u.id desc";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

  

    
}
?>


