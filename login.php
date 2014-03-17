<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>SOEM - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Le styles -->
	<link rel="shortcut icon" href="imagens\icones\login.png">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <script src="bootstrap/js/jquery.js"></script>
	<script type="text/javascript">  
    jQuery(document).ready(function(){  
        jQuery('#formulariooooooooo').submit(function(){  
            var dados = jQuery( this ).serialize();  
              jQuery.ajax({  
                type: "POST",  
                url: "operacoes/efetuar_login.php",  
                data: dados,  
                success: function( data )  
                {  
				  
				  if(data)
				  {
				  $("#aviso").fadeIn(2000);
                  $("#aviso").fadeOut(3000)
				  $("#aviso").html("<div class='alert alert-info'>" + data + "</div>");
				  }
				 
		        } 
						
            });  
              
            return false;  
        }); 
		
 	
    });  
</script>  

</head>
<body>
      <div class="container">
      <form class="form-signin" action="operacoes/efetuar_login.php" id="formulario" method="post">
        <h2 class="form-signin-heading">Login</h2>
		<div id="aviso"></div>
        <input type="text" name="nome" class="input-block-level" placeholder="usuário">
        <input type="password" name="senha" class="input-block-level" placeholder="senha">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Lembrar de mim
        </label>
        <button class="btn btn-large btn-primary" type="submit">Efetuar Login</button>
      </form>
   
    </div> 
</body>
</html>