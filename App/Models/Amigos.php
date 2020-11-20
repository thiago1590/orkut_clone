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
      $query = "select nome,image, id
      from usuarios
       where id in
       (select id_usuario_seguindo from amigos where id_usuario = :id) 
       order by 
       id desc limit 9";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getLast3Friends(){
      $query = "select nome,image, id
      from usuarios
       where id in
       (select id_usuario_seguindo from amigos where id_usuario = :id) 
       order by 
       id desc limit 3";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllFriends(){
      $query = "select nome,image,id
      from usuarios
       where id in
       (select id_usuario_seguindo from amigos where id_usuario = :id) 
       order by id desc";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIdFriends(){
      $query = "select id
      from usuarios
       where id in
       (select id_usuario_seguindo from amigos where id_usuario = :id) 
       order by id desc";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function seguir($id_usuario_seguindo){
      $query = "insert into amigos (id_usuario,id_usuario_seguindo) values
      (:id_usuario, :id_usuario_seguindo)";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
      $stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);

      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }
    
    public function deixar_de_seguir($id_usuario_seguindo){
      $query = "delete from amigos where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
      $stmt = $this->db->prepare($query);

      $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
      $stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);

      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function usuario_seguindo_sn($id_usuario_seguindo){
      $query = "select count(*) as num from amigos where id_usuario= :id_usuario and id_usuario_seguindo = :id_usuario_seguindo";
      $stmt = $this->db->prepare($query);
        
        $stmt->bindValue(':id_usuario',$this->__get('id'));
        $stmt->bindValue(':id_usuario_seguindo',$id_usuario_seguindo);
  
      $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);;
    }

    
}
?>


