<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsItensMadeiras
{
	public $iditem;
	public $idmadeira;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($iditem="", $idmadeira="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->iditem = $iditem;
		$this->idmadeira = $idmadeira;
	}
	
	//FUNÇAO CADASTRAR 
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = $this->iditem;
		$dados .= ",".$this->idmadeira;
		$this->sql_query = "INSERT INTO orcamentositens_madeiras VALUES (".$dados.")";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE orcamentositens_madeiras SET iditens = '$this->iditem', idmadeira = '$this->idmadeira' ";
		$this->sql_query .= "WHERE iditem = '$this->idtens'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = " select *from orcamentositens_madeiras ".$extra;
		//echo $this->sql_query;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$conn->close();
	}
	
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM orcamentositens_madeiras WHERE iditens = '$this->iditem'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>