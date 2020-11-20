<?php 

namespace App\Models;
use MF\Model\Model;

class Respostas extends Model {

    private $id;
    private $id_topico;
    private $mensagem;
    private $id_autor;
    private $data;
    private $id_comunidade;
    private $data2;

    public function __get($atributo) {
		return $this->$atributo;
	}

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
    }

    public function setResposta(){
        date_default_timezone_set('America/Sao_Paulo');
        $query = "insert into respostas (id_topico,mensagem,id_autor,data,data2) values
        (:id_topico,:mensagem,:id_autor,:data,:data2)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_topico',$this->__get('id_topico'));
        $stmt->bindValue(':mensagem',$this->__get('mensagem'));
        $stmt->bindValue(':id_autor',$this->__get('id_autor'));
        $stmt->bindValue(':data',$this->__get('data'));
        $stmt->bindValue(':data2',$this->__get('data2'));
        
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getRespostas(){
        $query = "select u.nome,u.image,r.mensagem,r.data 
        from respostas r join usuarios u on (r.id_autor = u.id)
        where id_topico = :id_topico ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_topico',$this->__get('id_topico'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC); 
    }

    public function getAllRespostas(){
        $query = "select u.nome,u.image,r.mensagem,r.data 
        from respostas r join usuarios u on (r.id_autor = u.id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getIdTopics(){
        $query = "select id from topicos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLast3Respostas(){
        $allTopics = $this->getIdTopics();
        $idList = array();
        foreach($allTopics as $key=>$topicos){
            array_push($idList,$allTopics[$key]['id']);
        }
        $resultado = array();
        foreach($allTopics as $key=>$topicos){
            $query = ("select r.mensagem, r.data, u.nome,u.image
            from respostas r join usuarios u on r.id_autor = u.id
             where r.id_topico = :id_topico  order by r.data2 desc limit 3");
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_topico',$idList[$key]);
            $stmt->execute();
            $resultado[] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
           }
           $resultado = array_reverse($resultado);

        return $resultado;
    }

    public function getIdTopicsComunidade(){
        $query = "select id from topicos where id_comunidade = :id_comunidade order by data";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_comunidade',$this->__get('id_comunidade'));
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastRespostaData(){
        $allTopics = $this->getIdTopicsComunidade();
        $idList = array();
        foreach($allTopics as $key=>$topicos){
            array_push($idList,$allTopics[$key]['id']);
        }
        $resultado = array();
        foreach($allTopics as $key=>$topicos){
            $query = ("select data from respostas 
             where id_topico = :id_topico  order by data2 limit 1");
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id_topico',$idList[$key]);
            $stmt->execute();
            $resultado[] = $stmt->fetch(\PDO::FETCH_ASSOC);
           }
        return $resultado;
    }

}

    ?>