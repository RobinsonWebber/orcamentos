<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsProdutos
{
	public $id;
	public $descricao;
	public $tipo;
	public $unidade;
	public $valor;
	public $croqui;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $descricao="", $tipo="", $unidade="", $valor="", $croqui="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->descricao = $descricao;
		$this->tipo = $tipo;
		$this->unidade = $unidade;
		$this->valor = $valor;
		$this->croqui = $croqui;
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
	echo $this->croqui;
		$conn = new Conexao();
		$conn->open();
		$dados  = "'".$this->descricao."'";
		$dados .= ",'".$this->tipo."'";
		$dados .= ",'".$this->unidade."'";
		$dados .= ",".$this->valor;
		$dados .= ",'".$this->croqui."'";
		$this->sql_query = "INSERT INTO produtos(descricao, tipo, unidade, valor, croqui) VALUES (".$dados.")";
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Produto ".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE produtos SET descricao = '$this->descricao', tipo = '$this->tipo', unidade = '$this->unidade', valor = '$this->valor', croqui = '$this->croqui' ";
		$this->sql_query .= "WHERE idproduto = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar Produto".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from produtos ".$extra;
		//$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ");
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM produtos WHERE idproduto = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Produto ".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>