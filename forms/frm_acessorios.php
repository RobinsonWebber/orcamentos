<html>
<head>
<script type="text/javascript">
		  google.load('jquery', '1.3');
</script>
<style>
.pull-center {
    display: table;
    margin-left: auto;
    margin-right: auto;
}
</style>

</head>		
<body>
<?php
//Por padrão o formulário abre para cadastrar
//com as variaveis vazias
$value = "Cadastrar";
$id = "";
$descricao = "";
$valor = "";
//Caso seja aberto para edicão
//carrega de acordo com o id passado
if(isset($_GET['id']) && is_numeric($_GET['id'])){
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAcessorios.php");
$value = "Alterar";
$id = pg_escape_string($_GET["id"]);
$extra = " WHERE idacessorio = ".$id;
$objacessorio = new ClsAcessorios();
$objacessorio->Pesquisar($extra);

	while($linha = @pg_fetch_array($objacessorio->getconsulta()))
	{
	$id = $linha["idacessorio"];
	$descricao = $linha["descricao"];
	$valor = $linha["valor"];

	}
}
// aqui vai um else
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Cadastrar acessorio:</strong></h2> Nesta tela você pode cadastrar ou alterar um acessorio conforme sua necessidade
</div>
            <form enctype='multipart/form-data' class="well pull-center" action="operacoes/add_alter_acessorio.php" method="post">
			<input class="input-xxlarge" name="id" type="hidden" class="form-control" placeholder="Produto" value="<?php echo $id;?>">
            <label>Acessorio</label>
            <input class="input-xxlarge" name="descricao" type="text" class="form-control" placeholder="Produto" value="<?php echo $descricao;?>" required>
            <label>Valor</label>
            <input class="input-xxlarge" id="valor" name="valor" type="text" class="form-control" value="<?php echo $valor;?>" required>
			<script type="text/javascript">$("#valor").maskMoney({decimal:".", thousands:""});</script>	
			<br>
			<input class="btn-primary" type="submit" value="<?php echo $value ?>">
            </form>
</html>

