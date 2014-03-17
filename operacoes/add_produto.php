<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsProdutos.php");
$id = $_POST["id"];
$descricao = $_POST["descricao"];
$tipo = $_POST["tipo"];
$unidade = $_POST["unidade"];
$valor = $_POST["valor"];

if(!empty($id)){
$extra = " WHERE idproduto =".$id;
	$objprodutos = new ClsProdutos();
	$objprodutos->Pesquisar($extra);
		while($linha = @pg_fetch_array($objprodutos->getconsulta()))
			$foto = $linha["croqui"];
}
if (!empty($_FILES['foto']['name']))
{
	//$tamanho = 1000;
	//$tipo_permitido = array('jpg', 'jpeg', 'jpe', 'jfif',  'gif', 'png', 'tif', 'tiff', 'dib', 'bmp');//tipos de imagens OU arquivo permitidos. se quiser mais tipos de imagens ou outros arquivos basta colocar a exetensão no array
    $tipo_arquivo = strtolower(array_pop(explode('.', $_FILES['foto']['name'])));//covertemos a string para minusculo depois pegamos a ultima posição do array que sera gerado pela função explode que vai pegar o nome da imagem antes do . e depois do . .posição [0] e [1]
    $caminho_imagem = "../imagens/produtos/".$nome_final =  md5(time()).".".$tipo_arquivo;//aqui definimos qual sera a PASTA que a imagem sera salva depois criamos um nome com a função de encodificação md5 que codificara a função time que pega os segundos desde a era unix 1970
    //$pixels_imagen = getimagesize($_FILES['arquivo']['tmp_name']);//através da função getimagesize da biblioteca gd pegamos a resolução da imagem
    $tamanho_imagem  = $_FILES['foto']['size'];//pegamos o tamanho da imagem em bytes
	   
	if(move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_imagem)){    //movemos a imagem para a pasta e se tudo der certo executa a query e inseri no banco o nome da imagem e o campo descrição 
		 unlink("../imagens/produtos/$foto");//Deleta imagem anterior
		 $objproduto = new ClsProdutos($id, $descricao, $tipo, $unidade, $valor, $nome_final);
		 if (empty($id)){
         $objproduto->Cadastrar();	
		 }
		 else{
		 $objproduto->Alterar();	
	}
}
}
else{
$objproduto = new ClsProdutos($id,$descricao, $tipo, $unidade, $valor, $foto);
	if (empty($id)){
         $objproduto->Cadastrar();	
	}
	else{
		$objproduto->Alterar();
	
	}
}

header("location: ../index.php?page=produtos");

?>