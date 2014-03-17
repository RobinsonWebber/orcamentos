<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensMadeiras.php");

$id = mysql_escape_string($_GET['id']);
$extra = "Where idmadeira =".$id;
$itensmadeira = new ClsItensMadeiras();
$itensmadeira->pesquisar($extra);
while($linha = @pg_fetch_array($itensmadeira->getconsulta()))
	$encontrou = true;
if ($encontrou){
	header("location: ../index.php?page=madeira&erro=1");	
}
else{
	$objmadeira = new ClsMadeiras($id);
	$objmadeira->Excluir();
	header("location: ../index.php?page=madeira");
}
?>