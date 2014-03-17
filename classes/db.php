<?php
Class Conexao
{
protected $host = "localhost";
protected $user = "webberim";
protected $pswd = "(b%vJj9D";
protected $dbname = "webberim_orcamentos";
protected $con = null;

function __construct(){} //método construtor

#método que inicia conexao 
function open(){
$this->con = @pg_connect("host=$this->host user=$this->user
password=$this->pswd dbname=$this->dbname");
return $this->con;
}

#método que encerra a conexao
function close(){
@pg_close($this->con);
}

#método verifica status da conexao
function statusCon(){
if(!$this->con){
echo "<h3>O sistema não está conectado à  [$this->dbname] em [$this->host].</h3>";
exit;
}
else{
echo "<h3>O sistema está conectado à  [$this->dbname] em [$this->host].</h3>";
}
}
}