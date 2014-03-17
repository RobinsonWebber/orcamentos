<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAcessorios.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
															
$id = pg_escape_string($_GET['id']);
//Verifica se cliente tem orcamento
$encontrou = false;
$extra = "WHERE idacessorio = $id";
$itens = new ClsItensAcessorios();
$itens->Pesquisar($extra);
while($linha = @pg_fetch_array($itens->getconsulta()))
	$encontrou = true;
if ($encontrou){
	header("location: ../index.php?page=acessorios&erro=1");	
}
else{
	$acessorios = new Clsprodutos($id);	
	$acessorios->Excluir();
	header("location: ../index.php?page=acessorios");
}

?>