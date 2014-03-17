<html>
<?php

include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsClientes.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsCidades.php");
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsTelefones.php");

//Por padrão o formulário abre para cadastrar
// com as variaveis vazias
$operacao = "operacoes/add_cliente.php";
$value = "Cadastrar";
$idcliente = "";
$nome = "";
$endereco = "";
$bairro = "";
$cep = "";
$cpf_cnpj = "";
$rg_ie = "";
$email = "";
$cidade = "";
$idcidade = "0";
//Caso seja passado o id por parametro
//carrega de acordo com o id passado
if(isset($_GET['id']) && is_numeric($_GET['id'])){
$operacao = "operacoes/alter_cliente.php";
$value = "Alterar";
$id = pg_escape_string($_GET['id']);
$extra = "inner join cidades on clientes.idcidade = cidades.idcidade where idcliente=".$id;
$objcliente = new ClsClientes(0);
$objcliente->Pesquisar($extra);
	while($linha = @pg_fetch_array($objcliente->getconsulta()))
	{
	$idcliente = $linha["idcliente"];
	$nome = $linha["nome"];
	$endereco = $linha["endereco"];
	$bairro = $linha["bairro"];
	$idcidade = $linha["idcidade"];
	$cep = $linha["cep"];
	$cpf_cnpj = $linha["cpf_cnpj"];
	$rg_ie = $linha["rg_ie"];
	$email = $linha["email"];
	}
$extra = "WHERE idcidade='".$idcidade."'";
$objcidade = new ClsCidades();
$objcidade->Pesquisar($extra);
	while($linha = @pg_fetch_array($objcidade->getconsulta())){
		$cidade = $linha['cidade'];
	}
}

//Formulario
?>

<head>
<script>
    jQuery(function(){
       jQuery("#telefone").mask("(99)9999-9999");
	 });
</script>


<script type="text/javascript"> 
function handleClick(tipo) {
   if (jQuery("#fisica").is(":checked")) {
	$("#cpf_cnpj").mask("999.999.999-99");
	}
	else{
	$("#cpf_cnpj").mask("99.999.999/9999-99");
	}
}; 
</script>

<script type="text/javascript">  
  jQuery(document).ready(function(){  
        jQuery('#form').submit(function(){  
            var dados = jQuery( this ).serialize();  
              jQuery.ajax({  
                type: "POST",  
                url: "operacoes/add_cliente.php",  
                data: dados,  
                success: function( data )  
                { 				  
				  if(data)
				  {
				  $("#aviso").fadeIn(2000);
                  $("#aviso").fadeOut(3000);
                  //  alert( data );  
				  $("#aviso").css("color","red")
				  
				  $("#aviso").html("<div class='alert alert-error'>" + data +"</div>");
			
				  }
				  else
				  {
				  $("#aviso").fadeIn(2000);
                  $("#aviso").fadeOut(3000);
				  $("#aviso").css("color","green");//cor verde atribuido com jquery
				  $("#aviso").html("<div class='alert alert-success'>Operação efetuada com sucesso!</div>" );
				  $(window.document.location).attr('href','index.php?page=clientes');
				  }
		        } 
						
            });  
              
            return false;  
        }); 
		
 	
    });  
</script>  

<script type="text/javascript">
$(function () {
	function removeCampo() {
		$(".removerCampo").unbind("click");
		$(".removerCampo").bind("click", function () {
			i=0;
			$(".telefones p.campoTelefone").each(function () {
				i++;
			});
			if (i>1) {
				$(this).parent().remove();
			}
		});
	}
	removeCampo();
	$(".adicionarCampo").click(function () {
		novoCampo = $(".telefones p.campoTelefone:first").clone();
		novoCampo.find("input").val("");
		novoCampo.insertAfter(".telefones p.campoTelefone:last");
		removeCampo();
	});
});
</script>
<script type="text/javascript" src="bootstrap/js/cidades-estados-v0.2.js"></script>
<script type="text/javascript">
window.onDomReady(function() {
  new dgCidadesEstados({
    estado: document.getElementById('estado'),
    cidade: document.getElementById('cidade')
  });
});
</script>
<!-- Script adicionar / remover campos de telefones -->
<script type="text/javascript">
$(function () {
  function removeCampo() {
	//$(".removerCampo").unbind("click");
	$(".removerCampo").bind("click", function () {
	   if($("tr.linhas").length > 1){
		$(this).parent().parent().remove();
	   }
	});
  }
 
  $(".adicionarCampo").click(function () {
	novoCampo = $("tr.linhas:first").clone();
	novoCampo.find("input").val("");
	novoCampo.insertAfter("tr.linhas:last");
	removeCampo();
  });
});
</script>

<!-- Script ocultar / mostrar telefones -->
<script type="text/javascript">
$(document).ready(function(){
 $('#telefones').hide();

 $('#mostrar').click(function(event){
 event.preventDefault();
 $("#telefones").show("slow");
 });

 $('#ocultar').click(function(event){
 event.preventDefault();
 $("#telefones").hide("slow");
 });
 });
</script>
<style>
.pull-center {
    display: table;
    margin-left: auto;
    margin-right: auto;
}
</style>

		
</head>		
<body>
<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong><?php echo $value." " ?>clientes:</strong></h2> Nesta tela você tem acesso aos dados do cliente, podendo alterar conforme sua necessidade
	
</div>

            <form id="form" class="well pull-center" action="" method="post">
            <input class="input-xxlarge" name="idcliente" type="hidden" class="form-control" value="<?php echo $idcliente; ?>">
			<label>* Nome</label>
            <input class="input-xxlarge" name="nome" type="text" class="form-control" placeholder="Cliente" value="<?php echo $nome; ?>" required>
            <label>*Endereço</label>
            <input class="input-xxlarge" name="endereco" type="text" class="form-control" placeholder="Endereço" value="<?php echo $endereco; ?>" required>
            <label>Bairro</label>
            <input class="input-xxlarge" name="bairro" type="text" class="form-control" placeholder="Bairro" value="<?php echo $bairro; ?>">
			<label>CEP</label>
            <input class="input-xxlarge" name="cep" type="text" class="form-control" placeholder="CEP" value="<?php echo $cep; ?>" data-mask="99.999-999">
			<label>Cidade</label>
			<input class="input-xxlarge" name="campocidade" value="<?php echo $cidade;?>" type="text" class="form-control" readonly >
			<label><strong>Para alterar a cidade selecione abaixo</strong></label>
			<label>Estado</label>
			<select class="selectpicker" id="estado" name="estado"></select>
			<label>*Cidade</label>
			<select class="selectpicker" id="cidade" name="cidade" value="<?php echo $cidade;?>"></select>
			<div class="control-group">
            <label class="control-label"><strong>Selecione o tipo de cliente</strong></label>
             Pessoa física   <input name="tipo" id="fisica"  value="fisica" type="radio" onclick="handleClick(this);">
             Pessoa jurídica  <input name="tipo" id="juridica" value="juridica" type="radio" onclick="handleClick(this);">
            </label>
			<label>* CPF ou CNPJ</label>
                        
          </div>
            <input class="input-xlarge" id="cpf_cnpj" name="cpf_cnpj" type="text" class="form-control" placeholder="CNPJ ou CPF" value="<?php echo $cpf_cnpj; ?>">
			
			<label>Insc. Estadual ou RG</label>
            <input class="input-xxlarge" id="rg_ie" name="rg_ie" type="text" class="form-control" placeholder="Insc. Estadual ou RG" value="<?php echo $rg_ie; ?>">
			
			
			<fieldset>
			<label>Telefones</label>
			<?php if ($value == "Alterar"){ 
			?>
			<table class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Tipo</th>
                <th>Operadora</th>
                <th>Telefone</th>
		    	<th></th>
				<th></th>
				
			 </tr>
            </thead>
            <tbody>
			
			
			<!-- Caso seja alteracao de cliente carrega os telefones do mesmo -->
			<?php
						     
              	$objfone = new ClsTelefones();
				$extra = "WHERE idcliente=".$id;
				$objfone->Pesquisar($extra);
               	while($linha = @pg_fetch_array($objfone->getconsulta()))
				{
				    $idtelefone = $linha['idtelefone'];
				    echo "<tr>";
				    echo "<td>".$linha["tipo"]."</td>";
					echo "<td>".$linha["operadora"]."</td>";
					echo "<td>".$linha["numero"]."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i><a href='index.php?page=alt_fone&id=$idtelefone'>Editar</a></td>";
					echo "<td><i class='icon-large  icon-remove-sign'></i><a href='operacoes/del_telefone.php?id=$idtelefone'>Excluir</td>";
					echo "</tr>";
				}				
				?> 
				
            </tbody>
			</table>
			
			<?php
			}
			?>
			<!-- Fim da tabela carregar telefones -->
			<a href="#" id="mostrar">Adicionar telefones</a>
			<a href="#" id="ocultar"> | Ocultar campos </a>

				<div id="telefones" class="telefones">
				<p class="campoTelefone">
				Tipo <input class="input-mini" id="tipo" type="text" name="tipo[]" />Operadora <input class="input-mini" type="text" id="operadora" name="operadora[]" />Telefone <input class="input-medium" type="text" id="telefone" name="telefone[]" data-mask="(99)9999-9999"/>
				<a href="#" class="removerCampo"><i class="icon-search icon-minus-sign"></i><a href="#" class="adicionarCampo"><i class="icon-search icon-plus-sign"></i></a>
				</p>
				</div>
			</fieldset>
			<label>Email</label>
            <input class="input-xxlarge" name="email" type="text" class="form-control" placeholder="Email" value="<?php echo $email; ?>">
			<br> 
			
            <br>			
		  <input class="btn-primary" type="submit" value="<?php echo $value; ?>">
		  <div id="aviso"></div>
          </form>
		  
		</body>
</html>		

		