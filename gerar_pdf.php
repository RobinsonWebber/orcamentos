<?php
if (is_numeric($_GET['id'])){
$id = $_GET['id'];
}
else {
echo "<script>alert('orcamentos não encontrado!');</script>";
return;
} 
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/MPDF/mpdf.php");
$url = "http://www.webberimoveis.com.br/orcamentos/orcamentos_impressao.php?id=".$id;
$html =  file_get_contents($url);
$mpdf = new mPDF();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML($html); 
$arquivo = "orcamento_".$id.".pdf";
$mpdf->Output($arquivo,'I');
