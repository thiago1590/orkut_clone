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


    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function getLastComunidades(){
      $query = "select u.nome 
      from usuarios u join comunidades_seguidas c on u.id = c.id_usuario
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
      $query = "select c.nome,c.id
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
      $query = "insert into comunidades (nome,categoria,descrição,data,imagem) values
      (:nome,:categoria,:descricao,:data,:imagem)";

      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':nome',$this->__get('nome'));
      $stmt->bindValue(':categoria',$this->__get('categoria'));
      $stmt->bindValue(':descricao',$this->__get('descricao'));
      $stmt->bindValue(':data',$current_date);
      $stmt->bindValue(':imagem', $this->__get('imagem'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastId(){
      $query = "select id from comunidades order by id desc limit 1";
      $stmt = $this->db->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getComunidadesInfo(){
      $query = "select id,nome,categoria,descrição,imagem from comunidades where id = :id_comunidade";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
      $stmt->execute();
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function pesquisar(){
      $query = "select nome,id from comunidades where nome like CONCAT('%',:pesquisa, '%') ";
      $stmt = $this->db->prepare($query);
      $stmt->bindValue(':pesquisa', $this->__get('pesquisa'));
      $stmt->execute();
  
      return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    
}
?>


