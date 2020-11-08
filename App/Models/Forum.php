<?php 

namespace App\Models;
use MF\Model\Model;

class Forum extends Model {

    private $id;
    private $id_comunidade;
    private $topico;
    private $mensagem;
    private $data;
    private $id_autor;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function criarTopico(){
        $query = "insert into forum (id_comunidade,id_autor,topico,mensagem,data) values
        (:id_comunidade,:id_autor,:topico,:mensagem,:data)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->bindValue(':id_autor',$this->__get('id_autor'));
        $stmt->bindValue(':topico',$this->__get('topico'));
        $stmt->bindValue(':mensagem',$this->__get('mensagem'));
        $stmt->bindValue(':data',$this->__get('data'));

        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastTopics(){
        $query = "select topico,data from forum where id_comunidade = :id_comunidade
        order by id desc limit 5";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllTopics(){
        $query = "select f.topico,f.id_autor,f.data, u.nome from forum f join usuarios u on f.id_autor = u.id where id_comunidade = :id_comunidade";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}

    ?>