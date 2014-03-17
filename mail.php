<?php
ob_start();  //inicia o buffer
?>
 
<b>Um Html Qualquer</b>
<h1>Título</h1>
<p>Funciona pra caralho!!! </p>
 
<?php
$html = ob_get_clean();
// pega o conteudo do buffer, insere na variavel e limpa a memória
 
$html = utf8_encode($html);
// converte o conteudo para uft-8
 
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/MPDF/mpdf.php");
// inclui a classe
 
$mpdf = new mPDF();
// cria o objeto
 
$html = ob_get_contents();
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html)); 

$content = $mpdf->Output('', 'S');

$content = chunk_split(base64_encode($content));
$mailto = 'robinsonwebber@hotmail.com'; //Mailto here
$from_name = 'ACME Corps Ltd'; //Name of sender mail
$from_mail = 'webberimoveis@webberimoveis.com.br'; //Mailfrom here
$subject = 'subjecthere'; 
$message = 'mailmessage';
$filename = "yourfilename-".date("d-m-Y_H-i",time()); //Your Filename whit local date and time

//Headers of PDF and e-mail
$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 

$header = "--$boundary\r\n"; 
$header .= "Content-Transfer-Encoding: 8bits\r\n"; 
$header .= "Content-Type: text/html; charset=ISO-8859-1\r\n\r\n"; //plain 
$header .= "$message\r\n";
$header .= "--$boundary\r\n";
$header .= "Content-Type: application/pdf; name=\"".$filename."\"\r\n";
$header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n";
$header .= "Content-Transfer-Encoding: base64\r\n\r\n";
$header .= "$content\r\n"; 
$header .= "--$boundary--\r\n";

$header2 = "MIME-Version: 1.0\r\n";
$header2 .= "From: ".$from_name." \r\n"; 
$header2 .= "Return-Path: $from_mail\r\n";
$header2 .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";
$header2 .= "$boundary\r\n";

mail($mailto,$subject,$header,$header2, "-r".$from_mail);

//$mpdf->Output($filename ,'I');
//exit;

?>