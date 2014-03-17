<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
$id = $_POST["id"];
$descricao = $_POST["descricao"];
$porcentual = $_POST["porcentagem"];

if(empty($descricao)){
echo "Preencha o campo descrição";
}

else{
$objmadeira = new ClsMadeiras($id, $descricao, $porcentual);
	if (empty($id)){
         $objmadeira->Cadastrar();	
	}
	else{
		$objmadeira->Alterar();
	
	}
	header("location: ../index.php?page=madeira");
}

?>