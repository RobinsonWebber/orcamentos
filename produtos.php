<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");

if(isset($_POST['txtPesquisa'])){
$extra = " where descricao ilike '".$_POST['txtPesquisa']."%' order by descricao";
}
else{
$extra = "order by descricao";
}
if ($_GET['erro'] == 1){
?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">X</button>
    <strong>Ops!:</strong>
	Este produto não pode ser excluido! Existem orçamentos com este produto!
</div>
<?php
}
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert"></button>
    <h2><strong>Produtos:</strong></h2> Nesta tela você tem acesso aos produtos cadastrados, podendo pesquisar, excluir e alterar conforme sua necessidade
</div>


<div id="pesquisa">
<form class="well form-search" action="index.php?page=produtos" method="post">
  <input type="text" class="input-xlarge search-query" name="txtPesquisa">
  <button type="submit" class="btn btn-primary"><i class='icon-large  icon-search icon-white'></i> Pesquisar</button>
</form>
</div>
<p class="pull-right">
  <a href="index.php?page=addproduto"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Cadastrar clientes</button></a>
</p>
<table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>descriçao</th>
                <th>Tipo</th>
                <th>Valor</th>
				<th></th>
				<th></th>
				
			 </tr>
            </thead>
            <tbody>
               <?php
				$produto = new ClsProdutos();
				$produto->Pesquisar($extra);
               	while($linha = @pg_fetch_array($produto->getconsulta()))
				{
				    $id = $linha["idproduto"];
				    echo "<tr class='sucess'>";
					echo "<td>".$linha["descricao"]."</td>";
					echo "<td>".$linha["tipo"]."</td>";
					echo "<td>".$linha["valor"]."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i><a href='index.php?page=addproduto&id=$id'>Editar</a></td>";
					echo "<td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_produto.php?id=$id'>Excluir</a></td>";
					echo "</tr>";
				}
				?> 
            </tbody>
</table>