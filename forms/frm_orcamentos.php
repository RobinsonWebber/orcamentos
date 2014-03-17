<html>
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
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsClientes.php");
//Por padrão o formulário abre para cadastrar
//com as variaveis vazias
$value = "Cadastrar";
$idorcamento = "";
$idcliente = "";
$nomecliente = "";
$emissao = "";
$estado = "";
$valor = "";
$value = "Cadastrar";

//Caso seja aberto para edicão
//carrega de acordo com o id passado
if(isset($_GET['id']) && is_numeric($_GET['id'])){
$value = "Alterar";
$idorcamento = pg_escape_string($_GET["id"]);
$extra = " inner join clientes on orcamentos.idcliente = clientes.idcliente and idorcamento =".$idorcamento;
$objorcamento = new ClsOrcamentos();
$objorcamento->Pesquisar($extra);

	while($linha = @pg_fetch_array($objorcamento->getconsulta()))
	{
	$idorcamento = $linha["idorcamento"];
	$idcliente = $linha["idcliente"];
	$emissao = $linha["emissao"];
	$estado = $linha["estado"];
	$valor = number_format($linha["valor"], 2, '.', '');
	$nomecliente = $linha["nome"];
	}
}

?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">
	</button>
    <h2><strong>Cadastro de Orçamentos:</strong></h2> Nesta tela você pode cadastrar ou alterar um orcamento, conforme sua necessidade
</div>
<?php
if (!empty($idorcamento)){?>
<p class="pull-center">
  <a href="index.php?page=itens&id=<?php echo $idorcamento ?>"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Adicionar produtos</button></a>
  <a href="index.php?page=viewitens&id=<?php echo $idorcamento ?>"> <button class="btn btn-info"><i class='icon-large  icon-plus icon-white'></i> Visualizar produtos</button></a>
  </p>

<?php } ?>
<br>
            <form class="well pull-center" action="operacoes/add_alter_orcamento.php" method="post">
			<input class="input-xxlarge" name="idorcamento" type="hidden" class="form-control"  value="<?php echo $idorcamento;?>">
			<input class="input-xxlarge" name="valor" type="hidden" class="form-control" value="<?php echo $valor;?>">
			<input class="input-xxlarge" name="idcliente" type="hidden" class="form-control" value="<?php echo $idcliente;?>">
            <div class="alert alert-info"><label><h2>Número: <?php echo " 000".$idorcamento; ?></h2></label></div>
			<label>Data</label>
			<input class="input-xlarge" name="data" type="date" class="form-control" value="<?php echo $emissao;?>">
			
			<label>Estatus</label>	
			<select class="input-xlarge" name="estado" type="text" class="form-control" value="<?php echo $estado?>">
				<option selected><?php echo $estado ?></option>
				<option>Aberto</option>
				<option>Em revisão</option>
                <option>Enviado</option>
				<option>Aprovado</option>
				<option>Arquivado</option>
            </select>
			
			<label>Selecione o cliente </label>
			<?php 
			$objcliente = new ClsClientes(0);
			$objcliente->Pesquisar();
			?>
			<select class="input-xlarge" name="cliente" type="text" class="form-control" value="<?php echo $idcliente;?>">
			   <option value="<?php echo $idcliente; ?>"><?php echo $nomecliente; ?></option>
			<?php
			   
			while($linha = @pg_fetch_array($objcliente->getconsulta())){?>
				<option value="<?php echo $linha["idcliente"]; ?>"><?php echo $linha["nome"]; ?></option>
			<?php		
			}
			?>
			</select>
          	
			<div class="alert alert-info"><label><h2>Total  R$ <?php echo $valor;?></label></h2></div>
			<br>			
			<input class="btn-primary" type="submit" value="<?php echo $value ?>">
			
			</form>
			
			<br>
			
		 



