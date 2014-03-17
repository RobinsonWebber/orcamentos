<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsOrcamentos
{
	public $id;
	public $idcliente;
	public $emissao;
	public $estado;
	public $valor;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $idcliente="", $emissao="", $estado="", $valor="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->idcliente = $idcliente;
		$this->emissao = $emissao;
		$this->estado = $estado;
		$this->valor = $valor;
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = $this->idcliente;
		$dados .= ",'".$this->emissao."'";
		$dados .= ",'".$this->estado."'";
		$dados  .= ",'".$this->valor."'";
		$this->sql_query = "INSERT INTO orcamentos(idcliente, emissao, estado, valor) VALUES (".$dados.")";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Orcamento ".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{	
		$conn = new Conexao();
		$conn->open();
		if ($this->idcliente == "" && $this->emissao == ""){
		 $this->sql_query  = "UPDATE orcamentos SET valor = '$this->valor'";
		}
		else{
		$this->sql_query  = "UPDATE orcamentos SET idcliente = '$this->idcliente', emissao = '$this->emissao', estado = '$this->estado', valor = '$this->valor'";
		}
		$this->sql_query .= " WHERE idorcamento = '$this->id'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar Orçamento".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from orcamentos ".$extra;
		//echo $this->sql_query;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".pg_result_error());
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM orcamentos WHERE idorcamento = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Orcamento ".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>