<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$id = $_POST["id"];
$idcliente = $_POST["cliente"];
$emissao = $_POST["data"];
$estado = $_POST["estado"];
$valor = $_POST["valor"];

if ($valor == ""){
$valor = 0;
}
echo "numero cliente".$idcliente;
/*
$datainv = $emissao; 
$d = explode("/",$datainv);
$datainv =$d [2]."-".$d[1]."-".$d[0];
*/
								 
$objorcamento = new ClsOrcamentos($id,$idcliente, $emissao, $estado, $valor);
	if (empty($id)){
        
		$objorcamento->Cadastrar();	
	}
	else{
		$objorcamento->Alterar();
	
	}
	header("location: ../index.php?page=orcamentos");

?>
