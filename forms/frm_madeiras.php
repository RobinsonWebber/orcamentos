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
$porcentagem = "1.00";
//Caso seja aberto para edicão
//carrega de acordo com o id passado
if(isset($_GET['id']) && is_numeric($_GET['id'])){
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
$value = "Alterar";
$id = pg_escape_string($_GET["id"]);
$extra = " WHERE idmadeira = ".$id;
$objmadeira = new ClsMadeiras();
$objmadeira->Pesquisar($extra);
	while($linha = @pg_fetch_array($objmadeira->getconsulta()))
	{
	$id = $linha["idmadeira"];
	$descricao = $linha["madeira"];
	$porcentagem = $linha["porcent_preco"];
	}
}
// aqui vai um else
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Cadastro de Madeiras:</strong></h2> Nesta tela você pode cadastrar ou alterar as madeiras conforme sua necessidade
</div>
            <form class="well pull-center" action="operacoes/add_alter_madeira.php" method="post">
			<input class="input-xxlarge" name="id" type="hidden" class="form-control" value="<?php echo $id;?>">
            <label>Madeira</label>
            <input class="input-xxlarge" name="descricao" type="text" class="form-control" placeholder="descrição" value="<?php echo $descricao;?>" required>
            <label>Acrecimo/Desconto</label>
            <input class="input-xxlarge" id="valor" name="porcentagem" type="text" class="form-control" value="<?php echo $porcentagem;?>" required>
			<script type="text/javascript">$("#valor").maskMoney({decimal:".", thousands:""});</script>	
			<div class="alert">Este campo permite colocar uma valor que pode ser desconto ou acrécimo. Caso voce deseje que os 
produtos de uma determinada madeira sejam mais caros ou mais barato basta preencher com o respectivo valor.
Exemplo: digite 1.15 para acrecimo de 15% e 0.90 para desconto de 10%</div> 
			<br>
			<input class="btn-primary" type="submit" value="<?php echo $value ?>">
            </form>
</html>

