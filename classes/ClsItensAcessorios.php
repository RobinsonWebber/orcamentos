<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsItensAcessorios
{
	public $iditem;
	public $idacessorio;
	public $quantidade;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($iditem="", $idacessorio="", $quantidade="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->iditem = $iditem;
		$this->idacessorio = $idacessorio;
		$this->quantidade = $quantidade;
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = $this->iditem;
		$dados .= ",".$this->idacessorio;
		$dados .= ",".$this->quantidade;
		$this->sql_query = "INSERT INTO orcamentositens_acessorios VALUES (".$dados.")";
		//echo $this->sql_query;
		//pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar telefone ".pg_result_error());
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar item ".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE orcamentositens_acessorios SET idacessorio = '$this->idacessorio'";
		$this->sql_query  .= ", quantidade = '$this->quantidade'";
		$this->sql_query .= " WHERE iditens = '$this->iditem'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar item".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from orcamentositens_acessorios ".$extra;
		//echo $this->sql_query;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ");
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM orcamentositens_acessorios WHERE iditens = '$this->iditem' ";
		$this->sql_query .= "AND idacessorio = '$this->idacessorio'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Telefone ".pg_result_error());
		$conn->close();
	}	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>