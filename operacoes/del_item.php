<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$id = mysql_escape_string($_GET['id']);
$idorcamento = mysql_escape_string($_GET['idorc']);
$objitem = new ClsitensOrcamentos($id);
$objitem->Excluir();

//atualiza preço orcamento
	$extra = "where idorcamento = ".$idorcamento;
	$objitem = new ClsitensOrcamentos();
	$objitem->Pesquisar($extra);
	$valororcamento = 0;
	while($linha = @pg_fetch_array($objitem->getconsulta()))
	{
		$valororcamento += $linha["valoritem"];
	}
	$objorcamento = new ClsOrcamentos($idorcamento,"","","",$valororcamento);
	$objorcamento->Alterar();
		
header("location: ../index.php?page=viewitens&id=$idorcamento");
?>