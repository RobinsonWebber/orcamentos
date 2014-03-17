<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAcessorios.php");
$id = $_POST["id"];
$descricao = $_POST["descricao"];
$valor = $_POST["valor"];
$foto = "";

if(empty($descricao)){
echo "Preencha o campo descrição";
}
else if(empty($valor)){
echo "Preencha o campo descrição";
}
else{
$objacessorio = new ClsAcessorios($id, $descricao, $valor);
	if (empty($id)){
         $objacessorio->Cadastrar();	
	}
	else{
		$objacessorio->Alterar();
	
	}
	header("location: ../index.php?page=acessorios");
}

?>