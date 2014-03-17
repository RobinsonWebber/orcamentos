<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$id = pg_escape_string($_GET['id']);
$orcamentos = new ClsOrcamentos($id);		       
$orcamentos->Excluir();
		
header("location: ../index.php?page=orcamentos");
?>