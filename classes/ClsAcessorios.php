<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsAcessorios
{
	public $id;
	public $descricao;
	public $valor;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $descricao="", $valor="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->descricao=$descricao;
		$this->valor = $valor;
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = "'".$this->descricao."'";
		$dados .= ",".$this->valor;
		$this->sql_query = "INSERT INTO acessorios (descricao, valor) VALUES (".$dados.")";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Acessório".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE acessorios SET descricao = '$this->descricao', valor = '$this->valor' ";
		$this->sql_query .= "WHERE idacessorio = '$this->id'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Evento".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from acessorios ".$extra;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM acessorios WHERE idacessorio = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Acessório".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>