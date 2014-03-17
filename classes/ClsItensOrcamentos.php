<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsItensOrcamentos
{
	public $id;
	public $idproduto;
	public $idorcamento;
	public $altura;
	public $largura;
	public $qtd;
	public $valor;
	public $descricao;
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $idproduto="", $idorcamento="", $altura="", $largura="", $qtd="", $valor="", $descricao="")
	{					
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->idproduto = $idproduto;
		$this->idorcamento = $idorcamento;
		$this->altura = $altura;
		$this->largura = $largura;
		$this->qtd = $qtd;
		$this->valor = $valor;
		$this->descricao = $descricao;
	}
	
	//FUNÇAO CADASTRAR
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = $this->idproduto;
		$dados .= ",".$this->idorcamento;
		$dados .= ",".$this->altura;
		$dados .= ",".$this->largura;
		$dados .= ",".$this->qtd;
		$dados .= ",".$this->valor;
		$dados .= ",'".$this->descricao."'";
		$this->sql_query = "INSERT INTO orcamentositens(idproduto, idorcamento, altura, largura, qtd, valoritem, desc_compl) VALUES (".$dados.")";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar item ".pg_result_error());
		$conn->close();
	}
	
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE orcamentositens SET idproduto = '$this->idproduto'";
		$this->sql_query  .= ", idorcamento = '$this->idorcamento', altura = '$this->altura'";
		$this->sql_query .= ", largura = '$this->largura', qtd = '$this->qtd', valoritem = '$this->valor', desc_compl = '$this->descricao'";
		$this->sql_query .= " WHERE iditens = '$this->id'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar Telefone".pg_result_error());
		$conn->close();
	}
	public function AlterarValor()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE orcamentositens SET valoritem = '$this->valor'";
		$this->sql_query .= " WHERE iditens = '$this->id'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar item ".pg_result_error());
		$conn->close();
	}
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from orcamentositens ".$extra;
		//echo $this->sql_query;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ");
		$conn->close();
	}
		
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM orcamentositens WHERE iditens = '$this->id'";
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