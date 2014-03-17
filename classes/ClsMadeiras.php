<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsMadeiras
{
	public $id;
	public $madeira;
	public $perc;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $madeira="", $perc="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->madeira = $madeira;
		$this->perc = $perc;
	}
	
	//FUNÇAO CADASTRAR 
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = "'".$this->madeira."'";
		$dados .= ",".$this->perc;
		$this->sql_query = "INSERT INTO madeiras (madeira, porcent_preco) VALUES (".$dados.")";
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE madeiras SET madeira = '$this->madeira', porcent_preco = '$this->perc' ";
		$this->sql_query .= "WHERE idmadeira = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from madeiras ".$extra;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM madeiras WHERE idmadeira = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>