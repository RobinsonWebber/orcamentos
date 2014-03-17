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
$tipo = "";
$unidade = "";
$valor = "";
$foto = "";

//Caso seja aberto para edicão
//carrega de acordo com o id passado
if(isset($_GET['id']) && is_numeric($_GET['id'])){
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
$value = "Alterar";
$id = pg_escape_string($_GET["id"]);
$extra = " WHERE idproduto =".$id;
$objprodutos = new ClsProdutos();
$objprodutos->Pesquisar($extra);

	while($linha = @pg_fetch_array($objprodutos->getconsulta()))
	{
	$id = $linha["idproduto"];
	$descricao = $linha["descricao"];
	$tipo = $linha["tipo"];
	$unidade = $linha["unidade"];
	$valor = $linha["valor"];
	$foto = $linha["croqui"];
	}
}
// aqui vai um else
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Cadastro de produtos:</strong></h2> Nesta tela você pode cadastrar ou alterar um produto, conforme sua necessidade
</div>
            <form enctype='multipart/form-data' class="well pull-center" action="operacoes/add_produto.php" method="post">
			<input class="input-xxlarge" name="id" type="hidden" class="form-control" placeholder="Produto" value="<?php echo $id;?>">
            <label>Produto</label>
            <input class="input-xxlarge" name="descricao" type="text" class="form-control" placeholder="Produto" value="<?php echo $descricao;?>" required>
            <label>Tipo de esquadria</label>	
			<select class="input-xlarge" name="tipo" type="text" class="form-control" value="<?php echo $tipo?>">
				<option><?php echo $tipo?></option>
				<option>Portas internas</option>
				<option>Portas externas</option>
                <option>Janelas</option>
				<option>Basculantes</option>
				<option>Portões</option>
				<option>Paineis</option>
				<option>Decks</option>
            </select>
			
			<label>Unidade de venda</label>
			<select class="input-xlarge" name="unidade" type="text" class="form-control" value="<?php echo $unidade?>">
				<option><?php echo $unidade?></option>
				<option>Unidade</option>
				<option>M2</option>
			</select>
			<!-- <input class="input-xxlarge" name="tipo" type="text" class="form-control" placeholder="Tipo" value="<?php echo $tipo;?>" required>-->
            <label>Valor</label>
            <input class="input-xxlarge" id="valor" name="valor" type="text" class="form-control" value="<?php echo $valor;?>" required>
			<script type="text/javascript">$("#valor").maskMoney({decimal:".", thousands:""});</script>	
			<div class="fileupload fileupload-new" data-provides="fileupload">
			  <div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
			  <?php
			  if ($foto != ""){?>
			    <img src="imagens/produtos/<?php echo $foto;?>" alt="" style="width: 120px; height: 250px;">
			  <?php } ?>
			  </div>
			  <div>
				<span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input name="foto" type="file" /></span>
				<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
			  </div>
			</div>
						
			<br>
			<input class="btn-primary" type="submit" value="<?php echo $value ?>">
            </form>
</html>

