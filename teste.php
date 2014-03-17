<?php
require_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/mail/class.smtp.php");


	$Email = new SendMail;
	$Email->Servidor = "localhost"; 
	$Email->Autenticado = false;   
	$Email->Usuario = "atendimento@webberimoveis.com.br";  //Digite o Usuário de e-mail você@seudominio
	$Email->Senha = "r4v3ng4";    //Digite a Senha do email você@seudominio
	$Email->EmailDe = "atendimento@webberimoveis.com.br";  //Digite o e-mail do remetente
	$Email->EmailPara = "robinsonwebber@hotmail.com";  //Digite o Destino
	$Email->Assunto = "Orcamento"; 
	$Email->Anexos = "mpdf.pdf";	  
	// Gerando corpo da mensagem  
	$Email->Corpo = "Segue em anexo orcamento conforme solicitado. Qualquer dúvida estamos a disposição";
	if($Email->Enviar()){
		echo "email enviado com sucesso!";
	}
	else 
	{
		echo "fudeu!!";
	}
?>