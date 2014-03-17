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
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAcessorios.php");

$iditem = "";
$idacessorio = "";
$quantidade = "";
$descricao = "";
$value = "Cadastrar";
if(!empty($_GET['iditem']) && is_numeric($_GET['iditem'])){
$iditem = pg_escape_string($_GET['iditem']);	
}

if(!empty($_GET['idac']) && is_numeric($_GET['idac'])){
$value = "Alterar";
$iditem = pg_escape_string($_GET['iditem']);
$idacessorio = pg_escape_string($_GET['idac']);
$extra = "inner join acessorios on acessorios.idacessorio = orcamentositens_acessorios.idacessorio";
$extra .= " and orcamentositens_acessorios.iditens = ".$iditem;
$extra .= " and orcamentositens_acessorios.idacessorio = ".$idacessorio;
$objacessorios = new ClsItensAcessorios();
$objacessorios->Pesquisar($extra);
	while($linha = @pg_fetch_array($objacessorios->getconsulta()))
	{
	   $iditem = $linha["iditens"];
	   $idacessorio = $linha["idacessorio"];
	   $acessorio = $linha["descricao"];
	   $quantidade = $linha["quantidade"];
	}

}
					
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Cadastrar acessórios:</strong></h2> Nesta tela você pode cadastrar ou alterar acessorios de um produto, conforme sua necessidade
</div>

       <form id="form" class="well pull-center" action="operacoes/add_alter_itens_acessorios.php" method="post">
	    <div id="aviso"></div>
		<label><h2>Produto: <?php echo $descricao; ?></h2></label>
		<input class="input-xxlarge" name="iditem" type="hidden" class="form-control" value="<?php echo $iditem;?>">
		<input class="input-xxlarge" name="idacessorio" type="hidden" class="form-control" value="<?php echo $idacessorio;?>">
		<label>Selecione o acessório</label>
		<select class="input-xlarge" name="acessorio" type="text" class="form-control" value = "<?php $acessorio ?>">
			<?php
			$acessorio = new ClsAcessorios();
			$acessorio->Pesquisar();
            while($linha = @pg_fetch_array($acessorio->getconsulta()))
			{
			  $descricao = $linha["descricao"];
			  $idproduto = $linha["idacessorio"];
			  //echo "<option value=$idproduto>$descricao</option>";
			  if($acessorio == $descricao){
			  echo "<option value=$idproduto selected>$descricao</option>";
			  }
			  else{
			  echo "<option value=$idproduto>$descricao</option>";
			  }
			}
			?>
		</select>
		
		<label>Quantidade</label>
			<input class="input-medium" name="qtd" type="number" min ="0" class="form-control" value="<?php echo $quantidade;?>" required>	
		<br>
		<input class="btn-primary" type="submit" value="<?php echo $value;?>">
       </form>
	  </body>
</html>

