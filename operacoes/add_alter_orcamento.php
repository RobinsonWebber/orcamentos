<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$id = $_POST["idorcamento"];
$idcliente = $_POST["cliente"];
$emissao = $_POST["data"];
$estado = $_POST["estado"];
$valor = $_POST["valor"];
if ($valor == ""){
$valor = 0;
}
			 
$objorcamento = new ClsOrcamentos($id,$idcliente, $emissao, $estado, $valor);
	if (empty($id)){        
		$objorcamento->Cadastrar();	
		//pega ultimo orcamento
		$extra = "order by idorcamento";
		$orcamentos = new ClsOrcamentos();
		$orcamentos->Pesquisar($extra);
        while($linha = @pg_fetch_array($orcamentos->getconsulta()))
		    $id = $linha["idorcamento"];
	}
	else{
		$objorcamento->Alterar();
	}
	echo "<script>document.location.href='../index.php?page=viewitens&id=$id'</script>";
?>
