<?php

include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsClientes.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsCidades.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsValidacao.php");
$idcliente = $_POST["idcliente"];
$nome = $_POST["nome"];
$endereco = $_POST["endereco"];
$bairro = $_POST["bairro"];
$cep = $_POST["cep"];
$cpf_cnpj = $_POST["cpf_cnpj"];
$rg_ie = $_POST["rg_ie"];
$email = $_POST["email"];
$tipo = $_POST["tipo"];
$operadora = $_POST["operadora"];
$numero = $_POST["telefone"];
$qtd_fones = count($numero);
$validacao = new ClsValidacao();
$cpf = $validacao->validaCPF($cpf_cnpj);
$cnpj = $validacao->validaCNPJ($cpf_cnpj);
$cpf_cnpj_atual = $cpf_cnpj;
if (($cnpj || $cpf) == false)
	{
	echo "CNPJ ou CPF inválido, digite novamente";
	return;
	}
$cliente = new ClsClientes();
$extra = "WHERE idcliente=$idcliente";
$cliente->Pesquisar();
//Caso seja alteração busca documento no banco
if (!empty($idcliente)){
$extra = "WHERE idcliente=$idcliente";
$cliente->Pesquisar($extra);
    	while($linha = @pg_fetch_array($cliente->getconsulta())){
			$cpf_cnpj_atual = $linha['cpf_cnpj'];
		}
	}

while($linha = @pg_fetch_array($cliente->getconsulta())){
	if (($cpf_cnpj == $linha['cpf_cnpj']) & ($cpf_cnpj != $cpf_cnpj_atual)){
		 echo "Documento já cadastrado para o cliente";
	   return;
	}
}
//busca id da cidade se foi postada no formulario
if(!empty($_POST["cidade"]) || !empty($_POST["campocidade"])){
    if(!empty($_POST["cidade"])){	
		$extra = "WHERE cidade ilike '".$_POST["cidade"]."'";
	}
	else{
		$extra = "WHERE cidade ilike '".$_POST["campocidade"]."'";
	}	
		$objcidade = new ClsCidades();
		$objcidade->Pesquisar($extra);
			while($linha = @pg_fetch_array($objcidade->getconsulta())){
				$idcidade = $linha['idcidade'];
			}
	$cliente = new ClsClientes($idcliente, $idcidade, $nome, $endereco, $bairro, $cep, $cpf_cnpj, $rg_ie, $email);
}
else {
    echo "Selecione a cidade do cliente";
    return;
}

//fim busca id cidade

	if (empty($idcliente)){
		$cliente->Cadastrar();
	}
	else{
		$cliente->Alterar();
					
	}

if(!empty($_POST["telefone"])){
    $cliente = new ClsClientes(0);
    $cliente->Pesquisar();
	
    if (empty($idcliente)){	
		while($linha = @pg_fetch_array($cliente->getconsulta()))
			$idcliente = $linha['idcliente']; //pega o último cliente cadastrado e grava id;
	}  
	for ($i=0; $i<$qtd_fones; $i++) {
		if ($numero[$i] != ""){
		    $objtelefone = new ClsTelefones("", $idcliente, $tipo[$i], $operadora[$i], $numero[$i]);
			$objtelefone->Cadastrar();
		}
	}	
}
//header("location: ../index.php?page=clientes");
?>
