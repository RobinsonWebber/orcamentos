<html>
<body>
<table class="table table-striped table-bordered">
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
	$iditem = pg_escape_string($_GET['iditem']);
	//busca id orcamento para poder voltar
	$extra = "where iditens =".$iditem;
	$objitem = new ClsItensOrcamentos();
	$objitem->Pesquisar($extra);
	while($linha = @pg_fetch_array($objitem->getconsulta()))
	{
		$idorcamento = $linha["idorcamento"];
	}		
	$extra = "inner join acessorios on acessorios.idacessorio = orcamentositens_acessorios.idacessorio";
	$extra .= " and orcamentositens_acessorios.iditens = ".$iditem;
	$objacessorios = new ClsItensAcessorios();
	$objacessorios->Pesquisar($extra);
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">
	</button>
	<h2><strong>Adicionar acessorios </strong></h2>  Nesta tela você pode alterar, excluir e adicionar acessórios aos itens do orcamento, conforme sua necessidade
</div>
<p class="pull-right">
  <a href="index.php?page=viewitens&id=<?php echo $idorcamento ?>"><button class="btn btn-info"><i class='icon-large  icon-circle-arrow-left icon-white'></i> Voltar</button></a>
  <a href="index.php?page=addacessorio_item&iditem=<?php echo $iditem ?>"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Adicionar acessorios</button></a>
</p>

            <thead>
              <tr>
                <th>Acessorio</th>
                <th>Valor</th>
                <th>Quantidade</th>
                <th>Total</th>
				<th></th>
				<th></th>
			 </tr>
            </thead>
            <tbody>
			<?php		
				
				while($linha = @pg_fetch_array($objacessorios->getconsulta()))
				{
					$iditem = $linha["iditens"];
					$idacessorio = $linha["idacessorio"];
				    echo "<tr>";
				    echo "<td>".$linha["descricao"]."</td>";
					echo "<td>R$ ".number_format($linha["valor"],2,',','.')."</td>";
					echo "<td>".$linha["quantidade"]."</td>";
					echo "<td>R$ ".number_format($linha["valor"] *$linha["quantidade"],2,',','.')."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i><a href='index.php?page=addacessorio_item&iditem=$iditem&idac=$idacessorio'>Editar</a></td>";
					echo "<td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_item_acessorio.php?iditem=$iditem&idac=$idacessorio'>Excluir</a></td>";
					echo "</tr>";
				}				
			?> 
</tbody>
</table>
</body>
</html>