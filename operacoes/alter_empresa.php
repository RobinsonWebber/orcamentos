<?php
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsEmpresa.php");
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsCidades.php");

$nome = $_POST["empresa"];
$endereco = $_POST["endereco"];
$bairro = $_POST["bairro"];
$cep = $_POST["cep"];
$cnpj = $_POST["cnpj"];
$ie = $_POST["ie"];
$telefone = $_POST["telefone"];
$email = $_POST["email"];

//busca id da cidade se foi alterada no formulario
if(isset($_POST["cidade"])){
$extra = "WHERE cidade ilike '".$_POST["cidade"]."'";
$objcidade = new ClsCidades();
$objcidade->Pesquisar($extra);
	while($linha = @pg_fetch_array($objcidade->getconsulta()))
		$idcidade = $linha['idcidade'];
	}
else
{
$idcidade = "";
}
//fim busca id cidade
if (!empty($_FILES['foto']['name']))
{
    //Busca imagem gravada para dar unlink
	$objempresa = new ClsEmpresa();
	$objempresa->Pesquisar();
	while($linha = @pg_fetch_array($objempresa->getconsulta())){
		$logo = $linha['logo'];
	}
	//Fim busca logo 
	
    //$tamanho = 1000;
	//$tipo_permitido = array('jpg', 'jpeg', 'jpe', 'jfif',  'gif', 'png', 'tif', 'tiff', 'dib', 'bmp');//tipos de imagens OU arquivo permitidos. se quiser mais tipos de imagens ou outros arquivos basta colocar a exetensão no array
    $tipo_arquivo = strtolower(array_pop(explode('.', $_FILES['foto']['name'])));//covertemos a string para minusculo depois pegamos a ultima posição do array que sera gerado pela função explode que vai pegar o nome da imagem antes do . e depois do . .posição [0] e [1]
    $caminho_imagen = "../imagens/empresa/".$nome_final =  md5(time()).".".$tipo_arquivo;//aqui definimos qual sera a PASTA que a imagem sera salva depois criamos um nome com a função de encodificação md5 que codificara a função time que pega os segundos desde a era unix 1970
    //$pixels_imagen = getimagesize($_FILES['arquivo']['tmp_name']);//através da função getimagesize da biblioteca gd pegamos a resolução da imagem
    $tamanho_imagem  = $_FILES['foto']['size'];//pegamos o tamanho da imagem em bytes
	/*
	if($tamanho_imagem > $tamanho) {
	    $error[1] = "Isso não é uma imagem.";
	    echo "A imagem deve ter no máximo ".$tamanho." bytes";
	}
	*/
    //if (count($error) == 0) {
	if(move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_imagen)){    //movemos a imagem para a pasta e se tudo der certo executa a query e inseri no banco o nome da imagem e o campo descrição 
         unlink("../imagens/empresa/$logo");//Deleta imagem anterior
		 $empresa = new Clsempresa(1, $idcidade, $nome, $endereco, $bairro, $cep, $cnpj, $ie, $telefone, $email, $nome_final);
         $empresa->Alterar();	
    }
	
}
else{
$foto = "";
$empresa = new Clsempresa(1, $idcidade, $nome, $endereco, $bairro, $cep, $cnpj, $ie, $telefone, $email, $foto);
$empresa->Alterar();
}
header("location: ../index.php?page=empresa");

?>
