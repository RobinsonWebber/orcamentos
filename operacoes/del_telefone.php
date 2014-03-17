<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");

$id = mysql_escape_string($_GET['id']);
$objfone = new ClsTelefones();
$extra = "WHERE idtelefone=".$id;
$objfone->Pesquisar($extra);
	while($linha = @pg_fetch_array($objfone->getconsulta()))
		$idcliente = $linha["idcliente"];
	    
	$objfone = new ClsTelefones($id);  
	if ($objfone->Excluir()){
		echo "Telefone excluido com sucesso!" ;		
	}
	header("location: ../index.php?page=addcliente&id=$idcliente");
?>