<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsClientes.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$id = mysql_escape_string($_GET['id']);
//Verifica se cliente tem orcamento
$encontrou = false;
$extra = "WHERE idcliente = $id";
$orcamentos = new ClsOrcamentos();
$orcamentos->Pesquisar($extra);
while($linha = @pg_fetch_array($orcamentos->getconsulta()))
	$encontrou = true;

if ($encontrou){
	 header("location: ../index.php?page=clientes&erro=1");	
}
else{
	$clientes = new ClsClientes($id);	
	$clientes->Excluir();
	header("location: ../index.php?page=clientes");
}

?>