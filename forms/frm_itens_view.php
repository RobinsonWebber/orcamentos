<html>
<body>
<table class="table table-striped table-bordered">
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
				$idorcamento = pg_escape_string($_GET['id']);
			    $extra = "inner join produtos on produtos.idproduto = orcamentositens.idproduto";
				$extra .= " and orcamentositens.idorcamento = ".$idorcamento;
				$objitens = new ClsItensOrcamentos();
				$objitens->Pesquisar($extra);
				//echo "<h2>Orçamento numero: $idorcamento</h2>";
$extra = "WHERE idorcamento = $idorcamento";
$orcamentos = new ClsOrcamentos();
$orcamentos->Pesquisar($extra);
while($linha = @pg_fetch_array($orcamentos->getconsulta()))
	$valor = number_format($linha["valor"], 2, '.', '');
				
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">
	</button>
	<i class='icon-large  icon-pencil'></i><a href='index.php?page=addorcamento&id=<?php echo $idorcamento; ?>'>Editar orcamento</a>
    <h2><strong>Orçamentos numero: 00<?php echo $idorcamento; ?>  -  Valor R$ <?php echo $valor; ?></strong></h2>  Nesta tela você pode alterar, excluir e adicionar acessórios aos itens do orcamento, conforme sua necessidade
</div>
<p class="pull-right">
  <a href="index.php?page=orcamentos"><button class="btn btn-info"><i class='icon-large  icon-circle-arrow-left icon-white'></i> Voltar</button></a>
  <a href="index.php?page=itens&id=<?php echo $idorcamento ?>"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Adicionar itens</button></a>
</p>

            <thead>
              <tr>
                <th>Produto</th>
                <th>Altura</th>
                <th>Largura</th>
				<th>Qtd</th>
				<th>Valor</th>
		    	<th></th>
				<th></th>
				<th></th>
			 </tr>
            </thead>
            <tbody>
			<?php		
				
				while($linha = @pg_fetch_array($objitens->getconsulta()))
				{
				    $iditem = $linha['iditens'];
					$valoritem = number_format($linha["valoritem"], 2, ',', '.');
				    echo "<tr>";
				    echo "<td>".$linha["descricao"]."</td>";
					echo "<td>".$linha["altura"]."</td>";
					echo "<td>".$linha["largura"]."</td>";
					echo "<td width='10'>".$linha["qtd"]."</td>";
					echo "<td>R$ ".$valoritem."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i><a href='index.php?page=itens&iditem=$iditem'>Editar</a></td>";
					echo "<td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_item.php?id=$iditem&idorc=$idorcamento'>Excluir</a></td>";
					echo "<td><i class='icon-large  icon-shopping-cart'></i><a href='index.php?page=viewacessorios&iditem=$iditem'>Acessórios</a></td>";
					echo "</tr>";
				}				
				?> 

</tbody>
</table>
</body>
</html>