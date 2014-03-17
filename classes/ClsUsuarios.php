<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsUsuarios
{
	public $id;
	public $nome;
	public $senha;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $nome="", $senha="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->nome = $nome;
		$this->senha = $senha;
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = "'".$this->nome."'";
		$dados .= ",'".$this->senha."'";
		$this->sql_query = "INSERT INTO usuarios(nome, senha) VALUES (".$dados.")";
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Usuário ".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE usuarios SET nome = '$this->nome', senha = '$this->senha'";
		$this->sql_query .= "WHERE idusuarios = '$this->id'";
		echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar Usuario".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from usuarios ".$extra;
		//echo $this->sql_query;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM usuarios WHERE idusuarios = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir usuário ".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>