<?php
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");
$id = mysql_escape_string($_POST['id']);
$idcliente = mysql_escape_string($_POST['idcliente']);
$tipo = $_POST["tipo"];
$operadora = $_POST["operadora"];
$numero = $_POST["numero"];

// $objfone = new ClsTelefones();
// $extra = "WHERE idtelefone=".$id;
// $objfone->Pesquisar($extra);

// while($linha = @pg_fetch_array($objfone->getconsulta()))
// {
	// $idtelefone = $linha['idtelefone'];
	// $tipo = $linha["tipo"];
	// $operadora = $linha["operadora"];
	// $numero = $linha["numero"];
// }
			
$objtelefone = new ClsTelefones($id, $idcliente, $tipo, $operadora, $numero);
$objtelefone->Alterar();

header("location: ../index.php?page=addcliente&id=$idcliente");

?>
