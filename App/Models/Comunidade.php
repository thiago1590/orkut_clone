<?php 

namespace App\Models;
use MF\Model\Model;

class Comunidade extends Model {
    private $id;
    private $id_usuario;
    private $id_comunidade;
    private $nome;
    private $categoria;
    private $descrição;
    private $pesquisa;
    private $imagem;
    private $dono;


    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function getLastComunidades(){
      $query = "select nome,imagem,id from comunidades where id in 
      (select id_comunidade from comunidades_seguidas where id_usuario = :id_usuario) 
      order by id desc limit 9";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLast3Comunidades(){
      $query = "select nome,imagem,id from comunidades where id in 
      (select id_comunidade from comunidades_seguidas where id_usuario = :id_usuario) 
      order by id desc limit 3";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    

    public function getAllComunidades(){
      $query = "select c.nome,c.id,c.imagem
      from comunidades c join comunidades_seguidas cs on c.id = cs.id_comunidade
       where c.id in
       (select id_comunidade from comunidades_seguidas where id_usuario = :id) 
       ";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id',$this->__get('id_usuario'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createComunidade(){
      $current_date = date("Y-m-d");
      $query = "insert into comunidades (nome,categoria,descrição,data,dono) values
      (:nome,:categoria,:descricao,:data,:dono)";

      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':nome',$this->__get('nome'));
      $stmt->bindValue(':categoria',$this->__get('categoria'));
      $stmt->bindValue(':descricao',$this->__get('descricao'));
      $stmt->bindValue(':data',$current_date);
      $stmt->bindValue(':dono', $this->__get('dono'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setImagem(){
      $query = "update comunidades set imagem = :imagem where id = :id";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':imagem',$this->__get('imagem'));
      $stmt->bindValue(':id',$this->__get('id'));
      $stmt->execute();
      return $this;
    }

    public function getLastId(){
      $query = "select id from comunidades order by id desc limit 1";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getComunidadesInfo(){
      $query = "select id,nome,categoria,descrição,imagem,dono from comunidades where id = :id_comunidade";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLast9membros(){
      $query = "select nome,image,id from usuarios where id in (select id_usuario from comunidades_seguidas where id_comunidade = :id_comunidade) order by id desc limit 9";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllmembros(){
      $query = "select nome,image,id,count(*) as total from usuarios where id in (select id_usuario from comunidades_seguidas where id_comunidade = :id_comunidade) order by id";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
  

    public function pesquisar(){
      $query = "select nome,id,imagem from comunidades where nome like CONCAT('%',:pesquisa, '%') ";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':pesquisa', $this->__get('pesquisa'));
      $stmt->execute();
  
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function participar(){
      $query = "insert into comunidades_seguidas (id_usuario,id_comunidade) values (:id_usuario,:id_comunidade)";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
      $stmt->bindValue(':id_comunidade', $this->__get('id_comunidade'));
      $stmt->execute();
  
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deixar_de_participar(){
      $query = "delete from comunidades_seguidas where id_usuario = :id_usuario and id_comunidade = :id_comunidade";
      $stmt = $this->db->prepare($query);

      $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
      $stmt->bindValue(':id_comunidade', $this->__get('id_comunidade'));

      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function comunidade_seguindo_sn(){
      $query = "select count(*) as num from comunidades_seguidas where id_usuario= :id_usuario and id_comunidade = :id_comunidade";
      $stmt = $this->db->prepare($query);
        
        $stmt->bindValue(':id_usuario',$this->__get('id_usuario'));
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
  
      $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);;
    }


    
}
?>


