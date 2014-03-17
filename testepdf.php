<?php
$idorcamento = $_GET["id"];
$html = file_get_contents('orcamentos_impressao.php?id='.$idorcamento);
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/MPDF/mpdf.php");
$mpdf = new mPDF();
$mpdf->WriteHTML($html);
$mpdf->Output('teste.pdf', 'I');
exit;
?>