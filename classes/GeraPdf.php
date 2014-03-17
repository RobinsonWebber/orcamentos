<?php
$html = ob_get_clean();
// pega o conteudo do buffer, insere na variavel e limpa a memória
 
$html = utf8_encode($html);
// converte o conteudo para uft-8
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/MPDF/mpdf.php");
// inclui a classe
 
$mpdf = new mPDF();
// cria o objeto
 
$mpdf->allow_charset_conversion=true;
// permite a conversao (opcional)
$mpdf->charset_in='UTF-8';
// converte todo o PDF para utf-8
 
$mpdf->WriteHTML($html);
// escreve definitivamente o conteudo no PDF
// define um nome para o arquivo PDF
$arquivo = date("ymdhis").'orcamento.pdf';
 
// gera o relatório
$mpdf->Output($arquivo,'D');
 

 
exit();
// finaliza o codigo
 
?>