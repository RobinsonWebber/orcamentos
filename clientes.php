<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsClientes.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");
if(isset($_POST['txtPesquisa'])){
$extra = " where nome ilike '".$_POST['txtPesquisa']."%' order by nome";
}
else{
$extra = "order by idcliente desc";
}
if ($_GET['erro'] == 1){
?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">X</button>
    <strong>Ops!:</strong>
	Este cliente não pode ser excluido! Existem orçamentos para este cliente!
</div>
<?php
}
?>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert"></button>
    <h2><strong>Clientes: </strong></h2>Nesta tela você tem acesso aos dados dos clientes, podendo pesquisar, excluir e alterar conforme sua necessidade
</div>

<div id="pesquisa">
  
<form class="well form-search" action="index.php?page=clientes" method="post">
  <input type="text" class="input-xlarge search-query" name="txtPesquisa"  placeholder="Busca cliente pelo nome">
  <button type="submit" class="btn btn-primary"><i class='icon-large  icon-search icon-white'></i> Pesquisar</button>
 </form>
</div>

<p class="pull-right">
  <a href="index.php?page=addcliente"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Cadastrar clientes</button></a>
</p>

<table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Documento</th>
				<th>Telefone</th>
				<th>Email</th>
				<th></th>
				<th></th>
				
			 </tr>
            </thead>
            <tbody>
               <?php
				$cliente = new ClsClientes(0);
				$cliente->Pesquisar($extra);
				$fone = new ClsTelefones();
               	while($linha = @pg_fetch_array($cliente->getconsulta()))
				{
				    echo "<tr>";
				    echo "<td>".$linha["nome"]."</td>";
					echo "<td>".$linha["endereco"]."</td>";
					echo "<td>".$linha["cpf_cnpj"]."</td>";
					$id = $linha["idcliente"];
				    $extra = "WHERE idcliente=".$linha["idcliente"];
					//Busca telefone por cliente - Mostra um telefone por cliente
					$fone->Pesquisar($extra);
					echo "<td>";
						while($linha2 = @pg_fetch_array($fone->getconsulta()))
						{		
						  	echo $linha2["numero"];						
							break;
						}	
                    echo "<td>".$linha["email"]."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i><a href='index.php?page=addcliente&id=$id'>Editar</a></td>";
					//echo "<td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_cliente.php?id=$id' onClick='return confirm('Deseja excluir este registro?')'>Excluir</td>";
					?><td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_cliente.php?id=<?php echo $id; ?>' onClick="return confirm('Deseja excluir este registro?')">Excluir</a></td><?php
					echo "</tr>";
				}
			?> 
            </tbody>
</table>