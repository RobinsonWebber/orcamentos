<html>
<head>
<meta charset="utf-8">	
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsEmpresa.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");
require("config.php");

$idorcamento = pg_escape_string($_GET["id"]);

ob_start();  //inicia o buffer

//Busca dados da empresa
$empresa = new ClsEmpresa();
$extra = "inner join cidades on empresa.idcidade = cidades.idcidade ";
$extra .= "inner join estados on cidades.idestado = estados.idestado";
$empresa->Pesquisar($extra);
while($linha = @pg_fetch_array($empresa->getconsulta()))
{
	$nome_empresa = $linha["nome"];
	$endereco_empresa = $linha["endereco"];
	$bairro_empresa = $linha["bairro"];
	$cidade_empresa = $linha["cidade"];
	$estado_empresa = $linha["sigla"];
	$cnpj_empresa = $linha["cnpj"];
	$ie_empresa = $linha["ie"];
	$telefone_empresa = $linha["telefones"];
	$email_empresa = $linha["email"];
	$logotipo = $linha["logo"];
}

//buscando dados do cliente
$extra = "inner join clientes on orcamentos.idcliente = clientes.idcliente ";
$extra .= "inner join cidades on clientes.idcidade = cidades.idcidade " ;
$extra .= "inner join estados on cidades.idestado = estados.idestado ";
$extra .= "and idorcamento =".$idorcamento;
$orcamentos = new ClsOrcamentos();
$orcamentos->Pesquisar($extra);
$fone = new ClsTelefones();
while($linha = @pg_fetch_array($orcamentos->getconsulta()))
{
	$d = explode("-",$linha["emissao"]);
	$emissao = $d[2]."/".$d[1]."/".$d[0];	
	$nome_cliente = $linha["nome"];
	$endereco_cliente = $linha["endereco"];
	$bairro_cliente = $linha["bairro"];
	$cidade_cliente = $linha["cidade"];
	$estado_cliente = $linha["sigla"];
	$email_cliente = $linha["email"];
	$valor = $linha["valor"];
	$id = $linha["idcliente"];
	$extra = "WHERE idcliente=".$linha["idcliente"];
	//Busca telefone por cliente - Mostra um telefone por cliente
	
	$fone->Pesquisar($extra);
		while($linha2 = @pg_fetch_array($fone->getconsulta()))
		{		
		$telefone_cliente =  $linha2["numero"];						
		break;
		}	
}
//Mostrando os dados da empresa e orcamento
?>
<table class='table table-hover'>
<tr>
<td><img src="imagens/empresa/<?php echo $logotipo;?>" alt="Logotipo" height="150" width="200"></td>
<td><h1><?php echo $nome_empresa;?></h1>
<p>
<?php echo "Endereco: ".$endereco_empresa." - ".$bairro_empresa." - ".$cidade_empresa."/".$estado_empresa; ?>
</p>
<p>
<?php echo "CNPJ: ".$cnpj_empresa." - Insc Est.: ".$ie_empresa; ?>
</p>
<p>
<?php echo "Contato: ".$email_empresa." - ".$telefone_empresa;?>
</p>
<p>
<b>Num. Orçamento <?php echo "000".$idorcamento." - Data de emissão: ".$emissao; ?></b>
</p>
</td>
</tr>
</table>
<!-- Mostrando os dados do cliente -->
<p><b>Dados do cliente</b></p>
Nome: <?php echo $nome_cliente;?><br>
Endereço: <?php echo $endereco_cliente." - ".$bairro_cliente." - ".$cidade_cliente."/".$estado_cliente;?><br>
Contato: <?php echo $email_cliente. " - ". $telefone_cliente; ?><br>
<br>
<p><b>Descricão dos itens</b></p>
<?php
//Descrevendo os itens do orcamento
$extra = "inner join produtos on produtos.idproduto = orcamentositens.idproduto ";
$extra .= "inner join orcamentositens_madeiras on orcamentositens_madeiras.iditens = orcamentositens.iditens ";
$extra .= "inner join madeiras on madeiras.idmadeira = orcamentositens_madeiras.idmadeira ";
$extra .= "and orcamentositens.idorcamento = ".$idorcamento;
$objitens = new ClsItensOrcamentos();
$objitens->Pesquisar($extra);
$cont_itens = 1;

echo "<table class='table table-hover'>";
echo "<tr>";
echo "<td><b>Item</b></td>";
if($exibe_imagem){
	echo "<td><b>Croqui</b></td>";
}
else{
	echo "<td></td>";
}
echo "<td><b>Descricao</b></td>";
echo "<td><b>Altura</b></td>";
echo "<td><b>Largura</b></td>";
echo "<td><b>Qtd</b></td>";
echo "<td><b>Valor item</b></td>";
echo "</tr>";

while($linha = @pg_fetch_array($objitens->getconsulta()))
{
	$iditem = $linha["iditens"];
	$altura = $linha["altura"];
	$largura = $linha["largura"];
	$descricao = $linha["descricao"];
	$madeira = $linha["madeira"];
	$quantidade = $linha["qtd"];
	$complemento = $linha["desc_compl"];
	$valoritem = number_format($linha["valoritem"], 2, ',', '.'); 
	$logo = $linha["croqui"];
	echo "<tr>";
	echo "<td>".$cont_itens."</td>";
	if($exibe_imagem){
		echo "<td><img src='imagens/produtos/$logo' alt='Logotipo' height='70' width='70'>";
	}
	else{
		echo "<td></td>";
	}	
	echo "<td>".$descricao.". ".$complemento." <b>madeira: ".$madeira."</td>";
	echo "<td>".$altura."</td>";
	echo "<td>".$largura."</td>";
	echo "<td>".$quantidade."</td>";
	echo "<td> R$ ".$valoritem."</td>";
	echo "</tr>";
	echo "<tr>";
	$cont_itens++;
	        $extra = "inner join acessorios on acessorios.idacessorio = orcamentositens_acessorios.idacessorio";
			$extra .= " and orcamentositens_acessorios.iditens = ".$iditem;
			$objacessorios = new ClsItensAcessorios();
			$objacessorios->Pesquisar($extra);
			while($linha = @pg_fetch_array($objacessorios->getconsulta()))
			{
				echo "<tr>";
				echo "<td></td>";
				echo "<td></td>";
				echo "<td>".$linha["descricao"]."</td>";
				//echo "<td>".$linha["valor"]."</td>";
				echo "<td>".$linha["quantidade"]."</td>";
				echo "<td>R$ ".number_format($linha["valor"] *$linha["quantidade"],2,',','.')."</td>";		
				echo "</tr>";
			}
	
}

?>
</table>
	<br>
	<br>
	<br>
	<h3 align="right">Total R$<?php echo number_format($valor,2,',','.'); ?></h3>

</table>
<br>
<br>
<br>

</body>
</html>
