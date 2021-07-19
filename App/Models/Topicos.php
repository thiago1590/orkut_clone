<?php 

namespace App\Models;
use MF\Model\Model;

class Topicos extends Model {

    private $id;
    private $id_comunidade;
    private $topico;
    private $id_autor;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function criarTopico(){
        date_default_timezone_set('America/Sao_Paulo');
        $query = "insert into topicos (id_comunidade,id_autor,topico,data) values
        (:id_comunidade,:id_autor,:topico,CURRENT_TIMESTAMP())";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->bindValue(':id_autor',$this->__get('id_autor'));
        $stmt->bindValue(':topico',$this->__get('topico'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastTopics(){
        $query = "select id,topico from topicos where id_comunidade = :id_comunidade
        order by id desc limit 5";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getTopics(){
        $query = "select f.id,f.topico,f.id_autor,u.nome from topicos f join usuarios u on f.id_autor = u.id where id_comunidade = :id_comunidade";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getTopicsInfo(){
        $query = "select id,topico,id_autor from topicos where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id',$this->__get('id'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllTopics(){
        $query = "select t.id,t.topico,c.nome as nome_comunidade,c.imagem, c.id as comunidade_id
        from topicos t
        join comunidades c on t.id_comunidade = c.id 
        order by t.data desc
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastId(){
        $query = "SELECT MAX(id) FROM topicos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

  

}

    ?>