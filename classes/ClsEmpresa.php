<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");

class ClsEmpresa
{
	public $id;
	public $nome;
	public $endereco;
	public $bairro;
	public $idcidade;
	public $cep;
	public $cnpj;
	public $ie;
	public $telefone;
	public $email;
	public $logo;
		
	private $sql_query;
	var $resultado;
		
	//CONSTRUTOR DA CLASSE
	function __construct($id="", $idcidade="", $nome="", $endereco="", $bairro="", $cep="", $cnpj="", $ie="", $telefone="", $email="", $logo="")
	{	
		$this->sql_query="";
		$this->resultado="";
		$this->sql_oper="";	
		$this->id = $id;
		$this->telefone = $telefone;
		$this->nome = $nome;
		$this->endereco = $endereco ;
		$this->bairro = $bairro;
		$this->idcidade = $idcidade;
		$this->cep = $cep;
		$this->cnpj = $cnpj;
		$this->ie = $ie;
		$this->email = $email;
		$this->logo = $logo;
		
	}
	
	//FUNÇAO CADASTRAR EMPRESA
	// public function Cadastrar()
	// {
		// $conn = new Conexao();
		// $conn->open();
		// $dados  = $this->idcidade.",";
		// $dados .= "'".$this->nome."',";
		// $dados .= "'".$this->endereco."',";
		// $dados .= "'".$this->bairro."',";
		// $dados .= "'".$this->cep."',";
		// $dados .= "'".$this->rg_cnpj."',";
		// $dados .= "'".$this->cpf_ie."',";
		// $dados .= "'".$this->email."'";
      	// $this->sql_query  = "INSERT INTO clientes ";
		// $this->sql_query .= "(idcidade, nome, endereco, bairro, cep, rg_cnpj, cpf_ie, email) ";
		// $this->sql_query .= "VALUES (".$dados.")";
		// echo $this->sql_query;
		// pg_exec($this->sql_query) or die ("Não Foi Possível Cadastrar Acessório".pg_result_error());
		// $conn->close();
			
	// }
	
	//FUNÇÃO ALTERAR DADOS DA EMPRESA
	public function Alterar()
	{
		$conn = new Conexao();
		$conn->open();
		$this->sql_query  = "UPDATE empresa SET ";
		if ($this->idcidade != ""){
			$this->sql_query .= "idcidade = '$this->idcidade',";
		}
		$this->sql_query .= "nome = '$this->nome',";
		$this->sql_query .= "endereco = '$this->endereco',"; 
		$this->sql_query .= "bairro = '$this->bairro',";
		$this->sql_query .= "cep = '$this->cep',";
		$this->sql_query .= "cnpj = '$this->cnpj',";
        $this->sql_query .= "ie = '$this->ie',";
		$this->sql_query .= "telefones = '$this->telefone',";
        $this->sql_query .= "email = '$this->email'";
		if ($this->logo != ""){
		$this->sql_query .= ",logo = '$this->logo' ";
		}
		$this->sql_query .= "WHERE idempresa = '$this->id' ";
		
		pg_exec($this->sql_query) or die ("Não Foi Possível Alterar dados da empresa ".pg_result_error());
		$conn->close();
	}
	
	//FUNCAO PESQUISAR
	public function Pesquisar($extra="")
	{
	    $conn = new Conexao();
		$conn->open();
		$this->sql_query = "select *from empresa ".$extra;
		$this->resultado = pg_exec($this->sql_query) or die("Problemas na Consulta: ".mysql_error());
		$conn->close();
	}
	
	public function getconsulta()
	{
	    return $this->resultado;		
	}
		
	//FUNÇÃO EXCLUIR
	// public function Excluir()
	// {
		// $conn = new Conexao();
		// $conn->open();
		// $this->sql_query = "DELETE FROM clientes WHERE idcliente = '$this->id'";
		// pg_exec($this->sql_query) or die ("Não Foi Possível Excluir Acessório".pg_result_error());
		// $conn->close();
	// }	
		
}
?>