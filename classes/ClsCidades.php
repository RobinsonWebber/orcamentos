<?php 

include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsCidades
{
	public $id;
	public $idestado;
	public $nome;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $idcidade="", $nome="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->idcidade = $idcidade;
		$this->nome = $nome;
	}
	
	//FUNÇAO CADASTRAR
	// public function Cadastrar()
	// {
		// $conn = new Conexao();
		// $conn->open();
		// $dados  = "'".$this->descricao."'";
		// $dados .= ",'".$this->tipo."'";
		// $dados .= ",".$this->valor;
		// $dados .= ",'".$this->croqui."'";
		// $this->sql_query = "INSERT INTO produtos(descricao, tipo, valor, croqui) VALUES (".$dados.")";
		// echo $this->sql_query;
		// pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Produto ".pg_result_error());
		// $conn->close();
	// }
	
	// //FUNÇÃO ALTERAR
	// public function Alterar()
	// {
		// $conn = new Conexao();
		// $conn->open();
		// $this->sql_query  = "UPDATE produtos SET descricao = '$this->descricao', tipo = '$this->tipo', valor = '$this->valor', croqui = '$this->croqui'";
		// $this->sql_query .= "WHERE idproduto = '$this->id'";
		// echo $this->sql_query;
		// pg_exec($this->sql_query) or die ("Não Foi Possível Alterar Produto".pg_result_error());
		// $conn->close();
	// }
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from cidades ".$extra;
		//echo $this->sql_query;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	// public function Excluir()
	// {
		// $conn = new Conexao();
		// $conn->open();
		// $this->sql_query = "DELETE FROM produtos WHERE idproduto = '$this->id'";
		// pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Produto ".pg_result_error());
		// $conn->close();
	// }	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>