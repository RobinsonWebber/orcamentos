<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/db.php");
$conn = new Conexao();
$conn->open();
$conn->statusCon();
?>