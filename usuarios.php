<?php
include_once($_SERVER['DOCUMENT_ROOT']."/orcamentos/classes/ClsUsuarios.php");

if(isset($_POST['txtPesquisa'])){
$extra = " where nome ilike '".$_POST['txtPesquisa']."%'";
}
else{
$extra = "";
}
?>

<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <h2><strong>Usuários:</strong></h2> Nesta tela você tem acesso aos usuários que possuem acesso ao sistema. Somente o usuário Admin pode excluir ou criar usuários, os outros usuários podem alterar somente seus dados
</div>

<div id="pesquisa">
<form class="well form-search" action="index.php?page=usuarios" method="post">
  <input type="text" class="input-xlarge search-query" name="txtPesquisa">
  <button type="submit" class="btn btn-primary"><i class='icon-large  icon-search icon-white'></i>Pesquisar</button>
  <p class="pull-right">
  <button class="btn btn-success" href="#"><i class='icon-large  icon-plus icon-white'></i> Cadastrar usuário</button>
  </p>
</form>
</div>

<table class="table table-striped table-bordered">
            <thead>
              <tr>
			    <th>Id</th>
                <th>Nome</th>
                <th></th>
				<th></th>
			</tr>
            </thead>
            <tbody>
               <?php
				$usuario = new ClsUsuarios();
				$usuario->Pesquisar($extra);
                echo "<tr>";
				while($linha = @pg_fetch_array($usuario->getconsulta()))
				{
				   	echo "<td>".$linha["idusuarios"]."</td>";
					echo "<td>".$linha["nome"]."</td>";
					//echo "<td>".$linha["senha"]."</td>";
					echo "<td><i class='icon-large  icon-pencil'></i>Editar</td>";
					echo "<td><i class='icon-large  icon-remove-sign'></i>Excluir</td>";
					echo "</tr>";
					echo "<tr>";					
				}
				?> 
            </tbody>
</table>