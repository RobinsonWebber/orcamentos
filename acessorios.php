<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsAcessorios.php");
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
	Este acessório não pode ser excluido! Existem itens de orçamentos para este acessório!
</div>
<?php
}
?>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert"></button>
    <h2><strong>Acessórios:</strong></h2> Nesta tela você tem acesso aos acessórios cadastrados, podendo pesquisar, excluir e alterar conforme sua necessidade
</div>

<div id="pesquisa">
<form class="well form-search" action="index.php?page=acessorios" method="post">
  <input type="text" class="input-xlarge search-query" name="txtPesquisa">
  <button type="submit" class="btn btn-primary"><i class='icon-large  icon-search icon-white'></i> Pesquisar</button>
</form>
</div>

<p class="pull-right">
  <a href="index.php?page=addacessorio"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Cadastrar clientes</button></a>
</p>
 
<table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>descriçao</th>
                <th>valor</th>
                <th></th>
				<th></th>
				
			 </tr>
            </thead>
            <tbody>
               <?php
				$acessorio = new ClsAcessorios();
				$acessorio->Pesquisar($extra);
                while($linha = @pg_fetch_array($acessorio->getconsulta()))
				{
					$id = $linha["idacessorio"];
				    echo "<tr class='sucess'>";
				   	echo "<td>".$linha["descricao"]."</td>";
					echo "<td>".$linha["valor"]."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i><a href='index.php?page=addacessorio&id=$id'>Editar</td>";
					?><td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_acessorio.php?id=<?php echo $id; ?>' onClick="return confirm('Deseja excluir este registro?')">Excluir</a></td><?php
					echo "</tr>";
				}
				?> 
            </tbody>
		
			
</table>