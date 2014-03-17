<?php 

include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsClientes
{
	public $id;
	public $nome;
	public $endereco;
	public $bairro;
	public $idcidade;
	public $cep;
	public $cpf_cnpj;
	public $rg_ie;
	public $email;
	
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $idcidade="", $nome="", $endereco="", $bairro="", $cep="", $cpf_cnpj="", $rg_ie="", $email="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->nome = $nome;
		$this->endereco = $endereco ;
		$this->bairro = $bairro;
		$this->idcidade = $idcidade;
		$this->cep = $cep;
		$this->cpf_cnpj = $cpf_cnpj;
		$this->rg_ie = $rg_ie;
		$this->email = $email;
	}
	
	//FUNÇAO CADASTRAR ACESSORIOS
	public function Cadastrar()
	{
		$conn = new Conexao();
		$conn->open();
		$dados  = $this->idcidade.",";
		$dados .= "'".$this->nome."',";
		$dados .= "'".$this->endereco."',";
		$dados .= "'".$this->bairro."',";
		$dados .= "'".$this->cep."',";
		$dados .= "'".$this->cpf_cnpj."',";
		$dados .= "'".$this->rg_ie."',";
		$dados .= "'".$this->email."'";
      	$this->sql_query  = "INSERT INTO clientes ";
		$this->sql_query .= "(idcidade, nome, endereco, bairro, cep, cpf_cnpj, rg_ie, email) ";
		$this->sql_query .= "VALUES (".$dados.")";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Cliente! ".pg_result_error());
		$conn->close();
			
	}
	//FUNÇÃO ALTERAR
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE clientes SET ";
		$this->sql_query .= "idcidade = '$this->idcidade',";
		$this->sql_query .= "nome = '$this->nome',";
		$this->sql_query .= "endereco = '$this->endereco',"; 
		$this->sql_query .= "bairro = '$this->bairro',";
		$this->sql_query .= "cep = '$this->cep',";
		$this->sql_query .= "cpf_cnpj = '$this->cpf_cnpj',";
        $this->sql_query .= "rg_ie = '$this->rg_ie',";
        $this->sql_query .= "email = '$this->email' ";
		$this->sql_query .= "WHERE idcliente = '$this->id'";
		//echo $this->sql_query;
		pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Acessório".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from clientes ".$extra;
		//$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ");
		$conn->close();
	}
			
	//FUNÇÃO EXCLUIR
	public function Excluir()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query = "DELETE FROM clientes WHERE idcliente = '$this->id'";
		pg_exec($this->sql_query) or die ("Não Foi Possível Excluir o cliente");
		$conn->close();
	}
	
	public function getconsulta()
	{
		return $this->resultado;		
	}
	
}
?>