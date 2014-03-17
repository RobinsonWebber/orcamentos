<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAtualizaValores.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/config.php");

if(empty($_POST["qtd"])){
echo "digite a quantidade";
return;
}

if (isset($_POST["idac"])){
$iditem = $_POST["idac"];
}
else{
$idac = "";
}
$encontrou = false;
$iditem = pg_escape_string($_POST["iditem"]);
$idacessorio = pg_escape_string($_POST["acessorio"]);
$quantidade = pg_escape_string($_POST["qtd"]);

$extra = "WHERE iditens =".$iditem." AND idacessorio =".$idacessorio;
$objitensacessorios = new ClsItensAcessorios();
$objitensacessorios->Pesquisar($extra);
while($linha = @pg_fetch_array($objitensacessorios->getconsulta()))
	$encontrou = true;

$itensacessorios = new ClsItensAcessorios($iditem, $idacessorio, $quantidade);

if ($idac == ""){
	if ($encontrou){
   	echo "<script>alert('Acessório já foi incluido neste item!');</script>";
	}
	else{
    $itensacessorios->Cadastrar();	
	}  
}		
else{
	$itensorcamentos->Alterar();
}
$objatualiza = new ClsAtualizaValores();
$objatualiza->Atualizaitens($iditem);

	header("location: ../index.php?page=viewacessorios&iditem=$iditem");
	
?>
