<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
															
$id = mysql_escape_string($_GET['id']);
//Verifica se cliente tem orcamento
$encontrou = false;
$extra = "WHERE idproduto = $id";
$itens = new ClsItensOrcamentos();
$itens->Pesquisar($extra);
while($linha = @pg_fetch_array($itens->getconsulta()))
	$encontrou = true;
if ($encontrou){
	header("location: ../index.php?page=produtos&erro=1");	
}
else{
	$produtos = new Clsprodutos($id);	
	$produtos->Excluir();
	header("location: ../index.php?page=produtos");
}

?>