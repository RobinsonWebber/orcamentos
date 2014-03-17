<?php
if(!isset($_SESSION)){ 
   session_start();   
} 

if(empty( $_SESSION['usuario'])){	
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<title>SOEM - Sistema de Orçamentos para Esquadrias de Madeira</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SOEM">
    <meta name="author" content="Robinson Webber">
    <link rel="shortcut icon" href="imagens\icones\doc.png">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="bootstrap/css/datepicker.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap-fileupload.css" rel="stylesheet">
	<link href="bootstrap/js/google-code-prettify/prettify.css" rel="stylesheet">
	<script src="bootstrap/js/jquery.js"></script>
	<script src="bootstrap/js/bootstrap-transition.js"></script>
	<script src="bootstrap/js/bootstrap-fileupload.js"></script>
    <script src="bootstrap/js/bootstrap-alert.js"></script>
    <script src="bootstrap/js/bootstrap-modal.js"></script>
	<script src="bootstrap/js/cpf.js"></script>
    <script src="bootstrap/js/bootstrap-dropdown.js"></script>
	<script src="bootstrap/js/jquery.maskedinput.js"></script>
	<script src="bootstrap/js/bootstrap-scrollspy.js"></script>
    <script src="bootstrap/js/bootstrap-tab.js"></script>
    <script src="bootstrap/js/bootstrap-tooltip.js"></script>
    <script src="bootstrap/js/bootstrap-popover.js"></script>
    <script src="bootstrap/js/bootstrap-button.js"></script>
    <script src="bootstrap/bootstrap-collapse.js"></script>
    <script src="bootstrap/bootstrap-typeahead.js"></script>
	<script src="bootstrap/bootstrap-datepicker.js"></script>
	<script src="bootstrap/js/jquery.maskMoney.js"></script>
	<!-- Bootstrap -->
	
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
        
</head>
  
<body>

<?php
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsOrcamentos.php");
if(isset($_GET['page'])){
$page = $_GET['page'];
}
else{
$page = "orcamentos";
}
$cont=0;
$extra = "where estado = 'Aberto'";
$objorcamentos = new ClsOrcamentos();
$objorcamentos->Pesquisar($extra);
while($linha = @pg_fetch_array($objorcamentos->getconsulta())){
	$cont++;
}
?>
<div>
<br>
<div class="panel panel-primary">
  <h1>SOEM - Sistema de Orçamentos para Esquadrias de Madeira<h1>
</div>
<br>
<!--
=================================================================================
MENU DE NAVEGAÇÃO
================================================================================= 
-->

<ul class="nav nav-tabs">
  <li><a href="index.php?page=empresa"><i class='icon-large  icon-briefcase'></i>Empresa</a></li>
  
  <!-- MENU CLIENTES -->
  <li class="dropdown" id="menu-cliente">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-cliente">
      <i class='icon-large  icon-book'></i>Clientes
    <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li><a href="index.php?page=clientes">Listar</a></li>
      <li><a href="index.php?page=addcliente">Adicionar</a></li>
    </ul>
  </li>
   <!-- MENU ORÇAMENTOS -->
  <li class="dropdown" id="menu-orc">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-orc">
      <i class='icon-large  icon-list-alt'></i>Orçamentos <span class="badge badge-warning"><?php echo $cont;?></span>
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li><a href="index.php?page=orcamentos">Listar orçamentos</a></li>
      <li><a href="index.php?page=addorcamento">Cadastrar orçamentos</a></li>
    </ul>
   </li>
  <!--  MENU PRODUTOS -->
   <li class="dropdown " id="menu-produto">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-produto">
      <i class='icon-large  icon-gift'></i>Produtos
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li><a href="index.php?page=produtos">Listar</a></li>
      <li><a href="index.php?page=addproduto">Adicionar</a></li>
    </ul>
   </li>
   <!--  MENU ACESSORIOS -->
   <li class="dropdown" id="menu-acessorio">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu-acessorio">
      Acessórios
      <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li><a href="index.php?page=acessorios">Listar</a></li>
      <li><a href="index.php?page=addacessorio">Cadastrar</a></li>
    </ul>
   </li>
   
   <li><a href="index.php?page=madeira">Madeiras</a></li>
   <li><a href="index.php?page=usuarios"><i class='icon-large  icon-user'></i>Usuários</a></li>
   <span class="label label-info">Você esta logado como <?php echo $_SESSION['usuario'];?><a href="logout.php"><i class='icon-large  icon-off icon-white'></i></a></span>
</ul>

<!--
=================================================================================
FIM DO MENU DE NAVEGAÇÃO
================================================================================= 
-->

<!--
=================================================================================
INICIO DA DIV CONTEUDO
================================================================================= 
-->
<div id="conteudo">
  
<?php

			switch ($page) {
						
				case 'empresa':
				require_once('empresa.php');
				break;
					
				case 'clientes': 
				require_once('clientes.php');
				break;
					
				case 'produtos': 
				require_once('produtos.php');
				break;
					
				case 'acessorios': 
				require_once('acessorios.php');
				break;
					
				case 'madeira': 
				include('madeiras.php');
				break;
					
				case 'usuarios': 
				require_once('usuarios.php');
				break;
					
				case 'orcamentos': 
				require_once('orcamentos.php'); //adicionar historico
				break;
					
				case 'addcliente': 
				require_once('forms/frm_clientes.php'); //alterar historico
				break;        
					
				case 'addproduto': 
				require_once('forms/frm_produtos.php');
				break;
					
				case 'alt_usuario': 
				require_once('forms/form_usuario_alt.php');
				break;
					
				case 'alt_fone': 
				require_once('forms/frm_telefones.php');
				break;
					
				case 'addacessorio':
				require_once('forms/frm_acessorios.php');
				break;
				
				case 'addmadeira': 
				require_once('forms/frm_madeiras.php');
				break;
				
				case 'addorcamento': 
				require_once('forms/frm_orcamentos.php');
				break;
				
				case 'itens': 
				require_once('forms/frm_itens.php');
				break;
				
				case 'viewitens': 
				require_once('forms/frm_itens_view.php');
				break;
				
				case 'viewacessorios': 
				require_once('forms/frm_acessorios_view.php');
				break;
				
				case 'addacessorio_item': 
				require_once('forms/frm_itens_acessorios.php');
				break;
				
				case 'enviar': 
				require_once('enviar_email.php');
				break;
			}	
		
?>

<!--
=================================================================================
FIM DA DIV CONTEUDO
================================================================================= 
-->
	 </div>
</div> <!-- Fim da div principal -->
</body>
</html>
