<?php
if (is_numeric($_GET["id"]))
{
$id = $_GET["id"];
}
else {
echo "<script>alert('orcamentos não encontrado!');</script>";
return;
} 
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
$extra = "inner join clientes on orcamentos.idcliente = clientes.idcliente and idorcamento=".$id;
$orcamentos = new ClsOrcamentos();
$orcamentos->Pesquisar($extra);
while($linha = @pg_fetch_array($orcamentos->getconsulta())){
	$nome_cliente = $linha["nome"];
	$email_cliente = $linha["email"];
}	


include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/MPDF/mpdf.php");
$url = "http://www.webberimoveis.com.br/orcamentos/orcamentos_impressao.php?id=".$id;
$html =  file_get_contents($url);
$mpdf = new mPDF();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML($html); 
$arquivo = "orcamento_".$id.".pdf";
$mpdf->Output($arquivo,'F');
$nome =  explode(" ", $nome_cliente);
$nome_contato = $nome[0];
$email_contato = $email_empresa;

$assunto_contato = "Orcamento"	;
$conteudo_completo .= "<p>Prezado Sr(a) ".$nome_contato."</p>Segue em anexo or&ccedil;amento conforme solicitado</p>"; 
$conteudo_completo .= "<p>Qualquer d&uacute;vida estamos a disposi&ccedil;&atilde;o</p>";
$conteudo_completo .= "<br><br><p>Atenciosamente.</p>";
$conteudo_completo .= "<p>".$nome_empresa."</p>";
// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer

include_once("classes/mail/novo/class.phpmailer.php");
$mail = new PHPMailer();
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
$mail->Charset = 'UTF-8';
$mail->Host = "mail.webberimoveis.com.br"; // Endereço do servidor SMTP
$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
$mail->Username = "atendimento@webberimoveis.com.br"; // Usuário do servidor SMTP
$mail->Password = "r4v3ng4"; // Senha do servidor SMTP
// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->From = "atendimento@webberimoveis.com.br"; // E-mail remetente
$mail->FromName = $nome_empresa; // Nome remetente
// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=                 

$mail->AddAddress($email_cliente , $nome_empresa);

//$mail->AddCC($email_cliente , $nome_cliente); // Copia

//$mail->AddBCC($email_cliente , $nome_cliente); // Cópia Oculta

//Define os dados técnicos da Mensagem

// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)

// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

$mail->Subject  = "$assunto_contato"; // Assunto da mensagem

$mail->Body = "$conteudo_completo";

$mail->AltBody = "$conteudo_completo";

// Define os anexos (opcional)
$mail->AddAttachment($arquivo, $arquivo);  // Insere um anexo

// Envia o e-mail
$enviado = $mail->Send();
					
if ($enviado){
 unlink($arquivo);
 echo "<div class='alert alert-success'>Email enviado com sucesso! <a href='index.php?page=orcamentos'><button class='btn btn-info'><i class='icon-large  icon-circle-arrow-left icon-white'></i> Voltar</button></a></div>";
}
else{
 unlink($arquivo);
  echo "<div class='alert alert-error'>Problemas ao enviar o email! <a href='index.php?page=orcamentos'><button class='btn btn-info'><i class='icon-large  icon-circle-arrow-left icon-white'></i> Voltar</button></a></div>";
 
}

// Após o envio limpa os destinatários e os anexos

$mail->ClearAllRecipients();

$mail->ClearAttachments();                  

?>


