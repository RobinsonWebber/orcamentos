<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAtualizaValores.php");
$iditem = mysql_escape_string($_GET['iditem']);
$idacessorio = mysql_escape_string($_GET['idac']);
$objitem = new ClsitensAcessorios($iditem, $idacessorio, "");
$objitem->Excluir();

$objatualiza = new ClsAtualizaValores();
$objatualiza->Atualizaitens($iditem);
header("location: ../index.php?page=viewacessorios&iditem=$iditem");


?>