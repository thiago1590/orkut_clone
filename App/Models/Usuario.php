<?php 

namespace App\Models;
use MF\Model\Model;

class Usuario extends Model {
    private $id;
	private $nome;
	private $email;
	private $senha;
	private $sobrenome;
	private $dia;
	private $mes;
	private $ano;
	private $data;
	private $sorte_de_hoje;
	private $data_sorte;
	

    public function __get($atributo) {
		return $this->$atributo;
	} 

	public function __set($atributo, $valor) {
		$this->$atributo = $valor;
	}

    public function salvar() {

		$query = "insert into usuarios(nome,sobrenome, email, senha, data )
		values(:nome,:sobrenome, :email, :senha, :data)";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->bindValue(':data', $this->__get('data'));
		
		$stmt->execute();

		return $this;
    }
    
    public function validarCadastro() {
		$valido = true;

		if(strlen($this->__get('nome')) < 3) {
			$valido = false;
		}
		if(strlen($this->__get('sobrenome')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('email')) < 3) {
			$valido = false;
		}

		if(strlen($this->__get('senha')) < 3) {
			$valido = false;
		}
		if($this->__get('dia') == 'false') {
			$valido = false;
		}
		if($this->__get('mes') == 'false') {
			$valido = false;
		}
		if($this->__get('ano') == 'false') {
			$valido = false;
		}
		


		return $valido;
    }
    
    public function getUsuarioPorEmail() {
		$query = "select nome, email from usuarios where email = :email";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function autenticar() {

		$query = "select id, nome, email from usuarios where email = :email and senha = :senha";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();

		$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

		if($usuario['id'] != '' && $usuario['nome'] != '') {
			$this->__set('id', $usuario['id']);
			$this->__set('nome', $usuario['nome']);
		}

		return $this;
	}

	public function getInfoUsuario() {
		$query = "select nome,id from usuarios where id = :id_usuario";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id'));
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function get_frase(){
        $rand = rand(1,20);
        $query = "select * from frases_sorte where id = :rand";
        $stmt = $this->db->prepare($query);
		$stmt->bindValue(':rand', $rand);
		$stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function set_sorte(){
        $id = $this->getInfoUsuario();
        $sorte = $this->get_frase();
        $current_date = date("Y-m-d");
        $query = "update usuarios set data_sorte = :current_date, sorte_de_hoje = :sorte
        where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':current_date', $current_date);
        $stmt->bindValue(':sorte', $sorte['frase']);
        $stmt->bindValue(':id',$id['id']);
		$stmt->execute();
        return $this;
	}
	
	public function get_sorte(){
		$id = $this->getInfoUsuario();
		$query = "select sorte_de_hoje,data_sorte from usuarios where id =:id";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id',$id['id']);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function valida_sorte(){
		$get_sorte = $this->get_sorte();
		$current_date = date("Y-m-d");
		if(!isset($get_sorte['sorte_de_hoje']) || $get_sorte['sorte_de_hoje'] = '' || $get_sorte['data_sorte'] != $current_date){
			$this->set_sorte();
		}
	}
}





?>