<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsUsuarios.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");
$conn = new Conexao();
$conn->open();

$objusuario = new ClsUsuarios();

if (empty($_POST['nome'])) {
    echo "Digite o Usuário!";
} 
// Verifica se a mensagem foi digitada
elseif (empty($_POST['senha'])) {
    echo "Digite a senha";
}
else
{
$usuario = pg_escape_string($_POST['nome']);
$senha = pg_escape_string($_POST['senha']);
$extra = "WHERE nome = '".$usuario."' AND senha = '".$senha."'";
$achou = 0;
$objusuario->Pesquisar($extra);
while($linha = @pg_fetch_array($objusuario->getconsulta()))
{
    $usuario = $linha["nome"]; 
	$achou = true;
}
if ($achou){			
	session_start();
	$_SESSION['usuario'] = $usuario;
	echo "Redirecionando...";
	echo "<script>document.location.href='../index.php'</script>";
}
else{
	echo "Dados não conferem!";
	}
}
