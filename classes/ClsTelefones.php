<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsTelefones
{
	public $id;
	public $idcliente;
	public $tipo;
	public $operadora;
	public $numero;
	
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $idcliente="", $tipo="", $operadora="", $numero="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->idcliente = $idcliente;
		$this->tipo = $tipo;
		$this->operadora = $operadora;
		$this->numero = $numero;
	
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = $this->idcliente;
		$dados .= ",'".$this->tipo."'";
		$dados .= ",'".$this->operadora."'";
		$dados .= ",'".$this->numero."'";
		$this->sql_query = "INSERT INTO telefones(idcliente, tipo, operadora, numero) VALUES (".$dados.")";
		//echo $this->sql_query;
		//pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar telefone ".pg_result_error());
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar telefone ".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE telefones SET idcliente = '$this->idcliente', tipo = '$this->tipo', operadora = '$this->operadora', numero = '$this->numero'";
		$this->sql_query .= "WHERE idtelefone = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar Telefone".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from telefones ".$extra;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ");
		//$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".pg_result_error());
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM telefones WHERE idtelefone = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Telefone ".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>