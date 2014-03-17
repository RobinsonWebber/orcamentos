-<html>
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
<?php
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensMadeiras.php");
$iditem = "";
$idorcamento = "";
$produto = "";
$altura = "";
$largura = "";
$quantidade = "";
$descricao_compl = "";
$value = "Cadastrar";
$complemento = "";

if(!empty($_GET['iditem']) && is_numeric($_GET['iditem'])){
$value = "Alterar";
$iditem = pg_escape_string($_GET['iditem']);
$extra = "inner join produtos on produtos.idproduto = orcamentositens.idproduto";
$extra .= " and orcamentositens.iditens = ".$iditem;
$objitem = new ClsItensOrcamentos();
$objitem->Pesquisar($extra);
while($linha = @pg_fetch_array($objitem->getconsulta()))
{
   $idorcamento = $linha["idorcamento"];
   $iditem = $linha["iditens"];
   $produto = $linha["descricao"];
   $altura = $linha["altura"];
   $largura = $linha["largura"];
   $quantidade = $linha["qtd"];
   $complemento = $linha["desc_compl"];
}

//busca madeira
if (!empty($iditem)){
$extra = " inner join madeiras on madeiras.idmadeira = ";
$extra .= " orcamentositens_madeiras.idmadeira and iditens =".$iditem;
$objmadeira = new ClsItensMadeiras();
$objmadeira->Pesquisar($extra);
while($linha = @pg_fetch_array($objmadeira->getconsulta())){
	$madeira = $linha["madeira"];
	$idmadeira = $linha["idmadeira"];
}
}
}
if(!empty($_GET['id']) && is_numeric($_GET['id'])){
 $value = "Cadastrar";
 $idorcamento = pg_escape_string($_GET["id"]);
}
					
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Itens orçamentos:</strong></h2> Nesta tela você pode cadastrar ou alterar itens de um orçamento, conforme sua necessidade
</div>
<a href="index.php?page=viewitens&id=<?php echo $idorcamento ?>"><button class="btn btn-info"><i class='icon-large  icon-circle-arrow-left icon-white'></i> Voltar</button></a>
       <form id="form" class="well pull-center" action="operacoes/add_alter_item.php" method="post">
	    <div id="aviso"></div>
		<label><h2>Orçamento número 000<?php echo $idorcamento; ?></h2></label>
		<label><h6>item:<?php echo $iditem; ?></h6></label>
		<input class="input-xxlarge" name="idorcamento" type="hidden" class="form-control" value="<?php echo $idorcamento;?>">
		<input class="input-xxlarge" name="iditem" type="hidden" class="form-control" value="<?php echo $iditem;?>">
		<label>Selecione o produto</label>
			<select class="input-xlarge" name="produto" type="text" class="form-control" value = "<?php echo $produto ?>">
			<?php
			$objproduto = new ClsProdutos();
			$objproduto->Pesquisar();
			while($linha = @pg_fetch_array($objproduto->getconsulta())){
			  $descricao = $linha["descricao"];
			  $idproduto = $linha["idproduto"];
			  if($descricao == $produto){
			  echo "<option value=$idproduto selected>$descricao</option>";
			  }
			  else{
			  echo "<option value=$idproduto>$descricao</option>";
			  }
			}
			?>
		</select>
		
		<label>Selecione a madeira</label>
			<select class="input-xlarge" name="madeira" type="text" class="form-control" value = "<?php echo $madeira;?>">
			<?php
			$objmadeira = new ClsMadeiras();
			$objmadeira->Pesquisar();
			echo "<option value=$idmadeira>$madeira</option>";
			while($linha = @pg_fetch_array($objmadeira->getconsulta())){
			  $descricao = $linha["madeira"];
			  $idmadeira = $linha["idmadeira"];
			  if ($descricao == $madeira){
				echo "<option value=$idmadeira selected>$descricao</option>";
			  }
			  else{
				echo "<option value=$idmadeira>$descricao</option>";
			}
			  
			}
			?>
		</select>
		<label>Altura</label>
			<input class="input-medium" id = "altura" name="altura" type="text" class="form-control" value="<?php echo $altura;?>">
			<script type="text/javascript">$("#altura").maskMoney({decimal:".", thousands:""});</script>	
		<label>Largura</label>
			<input class="input-medium" id ="largura" name="largura" type="text" class="form-control" value="<?php echo $largura;?>">		
			<script type="text/javascript">$("#largura").maskMoney({decimal:".", thousands:""});</script>	
		<label>Quantidade</label>
			<input class="input-medium" name="qtd" type="number" min ="0" class="form-control" value="<?php echo $quantidade;?>" required>	
		<label>Descrição complementar</label>
            <textarea class="input-xlarge" name="complemento" id="textarea" rows="4" ><?php echo $complemento;?></textarea>
        <br>
		<input class="btn-primary" type="submit" value="<?php echo $value;?>">
       </form>
	  </body>
</html>

