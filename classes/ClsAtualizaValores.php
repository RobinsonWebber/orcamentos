<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensMadeiras.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsItensAcessorios.php");
require($_SERVER['DOCUMENT_ROOT']."/orcamentos/config.php");

class ClsAtualizaValores
{
	
	//FUNÇAO CADASTRAR
	public static function AtualizaItens($iditem)
	{
		//pega madeira
	    $extra = " inner join orcamentositens_madeiras on orcamentositens_madeiras.idmadeira = madeiras.idmadeira ";
	    $extra .= " inner join orcamentositens on orcamentositens_madeiras.iditens= orcamentositens.iditens ";
	    $extra .= "and orcamentositens.iditens = $iditem";
		$objmadeira = new ClsMadeiras();
		$objmadeira->Pesquisar($extra);	
		while($linha = @pg_fetch_array($objmadeira->getconsulta())){
			    $porcentual = $linha["porcent_preco"];
				//echo $linha["madeira"]." - ";
		}
	    //Pega valor original do item
		$extra = "inner join produtos on produtos.idproduto = orcamentositens.idproduto";
		$extra .= " and orcamentositens.iditens = ".$iditem;
		$objitem = new ClsItensOrcamentos();
		$objitem->Pesquisar($extra);
		while($linha = @pg_fetch_array($objitem->getconsulta())){
			if($linha["unidade"] == "M2"){
			 	if($metro){
					if($linha["altura"] * $linha["largura"] < 1){
						$valoritem = $linha["valor"] * $linha["qtd"] * $porcentual;
						//echo $linha["valor"]." * ".$linha["qtd"]." * ".$porcentual." = ".$valoritem;
					}
					else{	
						$valoritem = $linha["valor"] * $linha["qtd"] * $linha["altura"] * $linha["largura"] * $porcentual;
						//echo $linha["valor"]." * ".$linha["qtd"]." * ".$linha["altura"]." * ".$linha["largura"]." * ".$porcentual." = ".$valoritem;
					}
				}
				else{
					$valoritem = $linha["valor"] * $linha["qtd"] * $linha["altura"] * $linha["largura"] * $porcentual;	
					//echo $linha["valor"]." * ".$linha["qtd"]." * ".$linha["altura"]." * ".$linha["largura"]." * ".$porcentual." = ".$valoritem;
				}
			}
			else{
				$valoritem = $linha["valor"] * $linha["qtd"] * $porcentual;
				//echo $linha["valor"]." * ".$linha["qtd"]." * ".$porcentual." = ".$valoritem;
			}
			$idorcamento = $linha["idorcamento"];
		 }
		//echo $valoritem." valor original do item - ";
		 
		//atualiza preço do item verificando os acessorios
		$extra = "inner join acessorios on acessorios.idacessorio = orcamentositens_acessorios.idacessorio";
		$extra .= " and orcamentositens_acessorios.iditens = ".$iditem;
		$objitensacessorios = new ClsItensAcessorios();
		$objitensacessorios->Pesquisar($extra);
		while($linha = @pg_fetch_array($objitensacessorios->getconsulta()))
			$valoritem += $linha["quantidade"] * $linha["valor"];
		//echo $valoritem. "atualizado os acessorios - ";
		$objitem = new ClsItensOrcamentos($iditem,0,0,"","","",$valoritem,"");
		$objitem->AlterarValor();
		
		//atualiza preço orcamento
		$extra = "where idorcamento = ".$idorcamento;
		$objitem = new ClsitensOrcamentos();
		$objitem->Pesquisar($extra);
		$valororcamento = 0;
		while($linha = @pg_fetch_array($objitem->getconsulta())){
				$valororcamento += $linha["valoritem"];
				//echo $valororcamento." - ";
		}
		$objorcamento = new ClsOrcamentos($idorcamento,"","","",$valororcamento);
		$objorcamento->Alterar();
		//echo $valororcamento;
		}
		
	}

?>