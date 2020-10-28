<?php 

namespace App\Models;
use MF\Model\Model;

class Amigos extends Model {
    private $id;
    private $id_usuario;
    private $id_usuario_seguindo;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

 
    public function getLast9Friends(){
      $query = "select u.nome 
      from usuarios u join amigos a on u.id = a.id_usuario_seguindo
       where u.id in
       (select id_usuario_seguindo from amigos where id_usuario = :id) 
       order by 
       u.id desc limit 9";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllFriends(){
      $query = "select u.nome 
      from usuarios u join amigos a on u.id = a.id_usuario_seguindo
       where u.id in
       (select id_usuario_seguindo from amigos where id_usuario = :id) 
       order by 
       u.id desc ";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  

    
}
?>


