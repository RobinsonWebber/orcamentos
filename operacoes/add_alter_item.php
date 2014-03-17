<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAtualizaValores.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/config.php");

if (isset($_POST["iditem"])){
	$iditem = $_POST["iditem"];
}
else{
$iditem = "";
}
$idorcamento = $_POST["idorcamento"];
$idproduto = $_POST["produto"];
$idmadeira = $_POST["madeira"];
$altura = $_POST["altura"];
$largura = $_POST["largura"];
$quantidade = $_POST["qtd"];
$complemento = $_POST["complemento"];
$extra = " where idmadeira = $idmadeira";
$madeira = new ClsMadeiras();
$madeira->Pesquisar($extra);
//echo "numero do orcamento :".$idorcamento;
//busca madeira
while($linha = @pg_fetch_array($madeira->getconsulta()))
		    $porcentual = $linha["porcent_preco"];
			
//busca preco
$extra = " WHERE idproduto =".$idproduto;
$objprodutos = new ClsProdutos();
$objprodutos->Pesquisar($extra);
while($linha = @pg_fetch_array($objprodutos->getconsulta()))
{
	$valor_unitario = $linha["valor"];
	$unidade = $linha["unidade"];
}
if ($unidade == "unidade"){
$valor = $valor_unitario * $quantidade * $porcentual;

}
else
{
	if (($largura * $altura < 1) && $metro)
	{
		$valor = $valor_unitario * $quantidade * $porcentual;
		
	}
	else
	{
		$valor = $largura * $altura * $valor_unitario * $quantidade * $porcentual;
		
	}
}
                                     
$itensorcamentos = new ClsItensOrcamentos($iditem, $idproduto, $idorcamento, $altura, $largura, $quantidade, $valor, $complemento);

if ($iditem == ""){  
	$itensorcamentos->Cadastrar();	
	//pesquisa ultimo item para gravar item madeira
	$extra = " order by iditens";
	$itensorcamentos->Pesquisar($extra);
	while($linha = @pg_fetch_array($itensorcamentos->getconsulta()))
		 $iditem = $linha["iditens"];
}
else{
	$itensorcamentos->Alterar();
	//excluir item madeira
	$objitemmadeira = new ClsItensMadeiras($iditem, "" );
	$objitemmadeira->Excluir();
}
	//insere na tabela item madeira
	$objitemmadeira = new ClsItensMadeiras($iditem, $idmadeira);
	$objitemmadeira->Cadastrar();
		
	$objatualiza = new ClsAtualizaValores();
	$objatualiza->Atualizaitens($iditem);
	
	header("location: ../index.php?page=viewitens&id=$idorcamento");
	
	
	
	
?>
