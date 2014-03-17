<html>
<head>
<script type='text/javascript'>

function confirma(id){
if (confirm("Deseja excluir esse registro")){
window.location="classes/historico_del.php?id=" + id"
}
}
</script>
</head>
<body>
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");

if(isset($_POST['txtPesquisa'])){
$extra = " where descricao ilike '".$_POST['txtPesquisa']."%'";
}
else{
$extra = "";
}

if ($_GET['erro'] == 1){
?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">X</button>
    <strong>Ops!:</strong>
	Esta madeira não pode ser excluida! Existem itens de orçamentos para este tipo de madeira!
</div>
<?php
}
?>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert"></button>
	<h2><strong>Madeiras:</strong></h2> Nesta tela você tem acesso aos produtos cadastrados, podendo pesquisar, excluir e alterar conforme sua necessidade
</div>

<div id="pesquisa">
<form class="well form-search" action="index.php?page=madeira" method="post">
  <input type="text" class="input-xlarge search-query" name="txtPesquisa">
  <button type="submit" class="btn btn-primary"><i class='icon-large  icon-search icon-white'></i> Pesquisar</button>
</form>
</div>

<p class="pull-right">
  <a href="index.php?page=addmadeira"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Cadastrar madeira</button></a>
</p>

<table class="table table-hover">
            <thead>
              <tr>
			    <th>Código<th>
                <th>descriçao</th>
                <th>Porcentual acrécimo</th>
                <th></th>
				<th></th>
			</tr>
            </thead>
            <tbody>
               <?php
				$madeira = new ClsMadeiras();
				$madeira->Pesquisar($extra);
                echo "<tr class='sucess'>";
				while($linha = @pg_fetch_array($madeira->getconsulta()))
				{
				    $id = $linha["idmadeira"];
				    echo "<td>".$linha["idmadeira"]."</td>";
					echo "<td>".$linha["madeira"]."</td>";
					echo "<td>".$linha["porcent_preco"]."</td>";
					echo "<td><i class='icon-large  icon-pencil'><a href='index.php?page=addmadeira&id=$id'></i>Editar</td>";?>
					<td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_madeira.php?id=<?php echo $id; ?>' onClick="return confirm('Deseja excluir este registro?')">Excluir</a></td><?php
					echo "</tr>";
					echo "<tr>";					
				}
				?> 
        </tbody>
</table>
</body>
</html>