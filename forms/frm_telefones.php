<html>
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");

$id = pg_escape_string($_GET['id']);

if(is_numeric($id)){
$objfone = new ClsTelefones();
$extra = "WHERE idtelefone=".$id;
$objfone->Pesquisar($extra);

  	while($linha=@pg_fetch_array($objfone->getconsulta())){
		$id = $linha["idtelefone"];
	    $idcliente = $linha["idcliente"];
		$tipo = $linha["tipo"];
		$operadora = $linha["operadora"];
		$numero = $linha["numero"];
	}  
	echo $id;
}
else
{
echo "<div class='alert'><strong>Opsss! </strong>O código digitado não é valido! Por favor tente novamente</div>";
die;
}
if(empty($numero)){
echo "<div class='alert'><strong>Opsss! </strong>O código digitado não foi encontrado! Por favor tente novamente</div>";
die;
}

?>
<head>
<style>
.pull-center {
    display: table;
    margin-left: auto;
    margin-right: auto;
}
</style>		
</head>		
<body>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Telefones:</strong></h2> Nesta tela você pode alterar os telefones conforme sua necessidade
</div>
    <form id="form" class="well pull-center" action="operacoes/alter_telefones.php" method="post">
	<input class="input-medium" name="id" type="hidden" class="form-control" value="<?php echo $id; ?>">
    <input class="input-medium" name="idcliente" type="hidden" class="form-control" value="<?php echo $idcliente; ?>">
	<label>Tipo</label>
    <input class="input-medium" name="tipo" type="text" class="form-control" placeholder="tipo" value="<?php echo $tipo;?>">
    <label>Operadora</label>
    <input class="input-medium" name="operadora" type="text" class="form-control" placeholder="operadora" value="<?php echo $operadora; ?>">
    <label>Numero</label>
    <input class="input-medium" name="numero" type="text" class="form-control" placeholder="Bairro" value="<?php echo $numero; ?>" required>
	<br>
	<input class="btn-primary" type="submit" value="Alterar">
	</form>
</body>

</html>		

		