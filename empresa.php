<html>
<?php
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsEmpresa.php");
include($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsCidades.php");
?>
<head>
<script type="text/javascript" src="http://cidades-estados-js.googlecode.com/files/cidades-estados-v0.2.js"></script>

<script type="text/javascript">
    window.onload = function() {
        new dgCidadesEstados(
            document.getElementById('estado'),
            document.getElementById('cidade'),
            true
			);
    }
</script>

<style>
.pull-center {
    display: table;
    margin-left: auto;
    margin-right: auto;
}
</style>
		
		
</head>		

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Empresa:</strong></h2> Nesta tela você tem acesso aos dados da empresa, podendo alterar conforme sua necessidade
	<div id="aviso"> </div>
</div>
</div>
<?php
$empresa = new ClsEmpresa();
$extra = "inner join cidades on empresa.idcidade = cidades.idcidade";
$empresa->Pesquisar($extra);
while($linha = @pg_fetch_array($empresa->getconsulta()))
{
?>
    <form enctype='multipart/form-data' class="well pull-center" id="form_empresa" method="post" action="operacoes/alter_empresa.php">
    <label>Empresa</label>
    <input class="input-xxlarge" name="empresa" value="<?php echo $linha["nome"]?>"type="text" class="form-control" placeholder="Empresa" required>
    <label>Endereço</label>
    <input class="input-xxlarge" name="endereco" value="<?php echo $linha["endereco"]?>" type="text" class="form-control" placeholder="Endereço">
    <label>Bairro</label>
    <input class="input-xxlarge" name="bairro" value="<?php echo $linha["bairro"]?>" type="text" class="form-control" placeholder="Bairro">
	<label>CEP</label>
    <input class="input-xxlarge" name="cep" value="<?php echo $linha["cep"]?>" type="text" class="form-control" placeholder="Bairro">
	
	<!-- Aqui carrega combo estados	-->	
	
		
	<label>Cidade</label>
	<input class="input-xxlarge" name="campocidade" value="<?php echo $linha["cidade"]?>" type="text" class="form-control" placeholder="Cidade" readonly >
	<label><strong>Para alterar a cidade selecione abaixo</strong></label>
	<label>Estado</label>
	<select class="selectpicker" id="estado" value="RS" name="estado"></select>
			
	<label>Cidade</label>
	<select class="selectpicker" id="cidade" value="Torres" name="cidade">
	</select>
	   
	<label>CNPJ</label>
    <input class="input-xlarge" name="cnpj" value="<?php echo $linha["cnpj"]?>" type="text" class="form-control" placeholder="CNPJ" data-mask="99.999.999/9999-99">
	<label>Insc. Estadual</label>
    <input class="input-xxlarge" name="ie" value="<?php echo $linha["ie"]?>" type="text" class="form-control" placeholder="Insc. Estadual">
			
	<label>Telefone</label>
    <input class="input-xxlarge" name="telefone" value="<?php echo $linha["telefones"]?>" type="text" class="form-control" placeholder="Telefone" data-mask="(99)9999-9999">
			
	<label>Email</label>
    <input class="input-xxlarge" name="email" value="<?php echo $linha["email"]?>" type="email" class="form-control" placeholder="Email">
	<label>Logotipo da empresa</label>	
	<div class="fileupload fileupload-new" data-provides="fileupload">
	<div class="fileupload-preview thumbnail" style="width: 200px; height: 150px;">
	<img src="imagens/empresa/<?php echo $linha["logo"]?>" alt="" style="width: 200px; height: 150px;">
	</div>
	<br>
	<div>
	<span class="btn btn-file"><span class="fileupload-new">Alterar logotipo</span><span class="fileupload-exists">Change</span><input name="foto" type="file" accept="image/*"/></span>
	<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
	</div>
	
	</div>
	<?php
	}
	?>
	<br>
	<input class="btn-primary" type="submit" value="Alterar dados">
	</form>
    
</html>
