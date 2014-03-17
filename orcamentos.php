<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$extra = "inner join clientes on orcamentos.idcliente = clientes.idcliente";
$abertos = 0;
$arquivados = "";
if(isset($_POST['arquivado']) == true){
	echo $_POST['arquivado'];
	$arquivados = " AND estado <> 'Arquivado'";
}
if(isset($_POST['txtPesquisa'])){
$extra .= " AND clientes.nome ilike '".$_POST['txtPesquisa']."%'";
}
if ((!empty($_POST['datainicial'])) and (!empty($_POST['datafinal']))){
$extra .= " AND orcamentos.emissao BETWEEN '".$_POST["datainicial"]."' AND '".$_POST["datafinal"]."'".$arquivados;
}
$extra .= " ORDER BY orcamentos.idorcamento DESC";
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/config.php");
?>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert"></button>
	<h2><strong>Orçamentos:</strong></h2> Nesta tela você tem acesso aos orcamentos cadastrados, podendo excluir e alterar conforme sua necessidade. Você pode também, pesquisar utilizando um dos parâmetros de pesquisa ou até mesmo todos ao mesmo tempo para refinar melhor sua pesquisa.
</div>
<div id="aviso"></div>
<div id="pesquisa">
<form class="well form-search" action="index.php?page=orcamentos" method="post">
  <input type="text" class="input-xlarge search-query" name="txtPesquisa" placeholder="Nome do cliente">
  <strong>Data inicial: </strong><input type="date" class="input-medium" name="datainicial">
  <strong>Data final: </strong><input type="date" class="input-medium" name="datafinal">
  <label class="checkbox">
      <input type="checkbox" name="arquivado" value="arquivado"> Mostrar arquivados
  </label>
  <button type="submit" class="btn btn-primary"><i class='icon-large  icon-search icon-white'></i>Pesquisar</button>
</div>
</form>
</div>
<p class="pull-right">
  <a href="index.php?page=addorcamento"><button class="btn btn-success"><i class='icon-large  icon-plus icon-white'></i> Cadastrar orcamentos</button></a>
</p>


<table class="table table-striped table-bordered">
            <thead>
              <tr>
			    <th>Número</th>
                <th>Data</th>
                <th>Cliente</th>
				<th>Valor</th>
                <th>Estatus</th>
				<th></th>
				<th></th>
				
			 </tr>
            </thead>
            <tbody>
               <?php
			    $orcamentos = new ClsOrcamentos();
				$orcamentos->Pesquisar($extra);
				$abertos = 0;			    
                while($linha = @pg_fetch_array($orcamentos->getconsulta()))
				{
					$valor = number_format($linha["valor"], 2, ',', '.');
				    $id = $linha["idorcamento"];
				    echo "<tr>";
					echo "<td><a href='gerar_pdf.php?id=$id' target='blank'><i class='icon-large  icon-print'></i></a> <a href='index.php?page=enviar&id=$id'><i class='icon-large  icon-envelope'></i></a><a href='index.php?page=addorcamento&id=".$id."'>".$id."</a></td>";
				    $d = explode("-",$linha["emissao"]);
			        $data = $d[2]."/".$d[1]."/".$d[0];
				    			    
				    echo "<td>".$data."</td>";
					echo "<td>".$linha["nome"]."</td>";
				    echo "<td>R$ ".$valor."</td>";
					echo "<td>";
					if ($linha["estado"] == "Aberto"){
						echo "<span class='badge badge-warning'>".$linha["estado"]."</span>";
					}
					else if ($linha["estado"] == "Aprovado"){
						echo "<span class='badge badge-success'>".$linha["estado"]."</span>";
					}
					else{
						echo $linha["estado"];
					}
					echo "</td>";
					echo "<td><i class='icon-large  icon-search'></i><a href='index.php?page=viewitens&id=$id' target-new>Ver produtos</td>";
					//echo "<td><i class='icon-large  icon-remove-sign'></i>Excluir</td>";
					?><td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_orcamentos.php?id=<?php echo $id; ?>' onClick="return confirm('Deseja excluir este orçamento?')">Excluir</a></td><?php
					echo "</tr>";
				}
				?> 
            </tbody>
</table>

<?php 
function geraTimestamp($data) {
	$partes = explode('-', $data);
	return mktime(0, 0, 0, $partes[0], $partes[1], $partes[2]);
}


if ($abertos > 0) {?>
<script type="text/javascript"> 
$("#aviso").fadeIn(2000);
$("#aviso").fadeOut(8000); 
$("#aviso").html("<div class='alert alert-error'><strong>ATENÇÃO:</strong> foi invidado uma notificação por email para o supervisor, há orcamentoas abertos com prazo maior que o tolerado</div>");
</script>
<?php } ?>