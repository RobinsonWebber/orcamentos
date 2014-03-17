<?php
/*
*    Classe SendMail  e todas as suas funções são de poder da Hosting Machine
*/
class SendMail
{
   var $Servidor = "mail.webberimoveis.com.br";       //Endereço do servidor SMTP
   var $Porta=25;       //Porta do servidor SMTP
   var $Autenticado = true;    //Autenticado ou não
   var $Usuario = "atendimento@webberimoveis.com.br";        //Usuario do servidor SMTP
   var $Senha = "r4v3ng4";          //Senha do servidor SMTP
    
   var $EmailDe;        //Email de quem está enviando
   var $EmailPara;      //Email de quem vai receber
   var $Assunto;        //Assunto do email
   var $Corpo;          //Mensagem do email

   //Aumente para mais anexos
   var $Anexos=array(" ", " ", " ", " ", " ", " "," ", " ", " "," ");
   var $NumAnexos=0;

   var $Barra="\\";     //Variavel que guarda o tipo da barra, \\ - windows | / - Linux
   var $erros=FALSE;    //Variavel que trata a situação da classev
   var $server_response;
   //Construtor
   function SendMail()
   {
       //Aumenta o tempo de espera maximo
       set_time_limit(3600);
   }

   //Criptografa o arquivo na base64
   function CodarArquivo($arq)
   {
       $fp=fopen($arq, "rb");
       if(!$fp)
       {
           $this->erros=TRUE;
           return FALSE;
       }
       $File=fread($fp, filesize($arq));
       fclose($fp);

       return base64_encode($File);
   }
   
    //Retorna o nome do arquivo
    function PegarNome($str)
    {
        $Nome="";
        $i=strlen($str)-1;
        while($str[$i]!="\\")
            $i--;

        $i++;
        $j=0;
        for($i; $i<strlen($str); $i++)
        {
            $Nome.=$str[$i];
            $j++;
        }
        return $Nome;
    }

    //Retorna a extensão do arquivo, desde que ele tenha extesão
    function PegarTipo($str)
    {
        $tipo="";
        $i=strlen($str)-1;
        $j=0;
        while($str[$i]!=".")
            $i--;

        $i++;
        $j=0;
        for($i; $i<strlen($str); $i++)
        {
            $tipo.=$str[$i];
            $j++;
        }
        return $tipo;
    }

    //Coloca o endereço do arquivo no array e aumenta o numero de anexos
    function Anexar($arq)
    {
        $this->Anexos[$this->NumAnexos]=$arq;
        $this->NumAnexos++;
        return TRUE;
    }
    
   //Função que verifica se as variaveis estão OK
   function Verificar()
   {
       //Verifica se é um servidor autenticado
       if( $this->Autenticado )
           if( !isset($this->Usuario) || !isset($this->Senha) )  //Se for autenticado, verifica o usuario e a senha
               $this->erros=TRUE;

       //Verifica se o servidor foi digitado
       if( !isset($this->Servidor) )
           $this->erros=TRUE;
           
       //Verifica se os parametros são validos
       if( !isset($this->EmailDe) || !isset($this->EmailPara) || !isset($this->Assunto) || !isset($this->Corpo) )
           $this->erros=TRUE;
   }

   //Função que espera o servidor responder
   function Esperar_Resp($socket, $response, $line = __LINE__)
   {
       while (substr($server_response, 3, 1) != ' ')
           if (!($server_response = fgets($socket, 256)))
               $this->erros=TRUE;
       if (!(substr($server_response, 0, 3) == $response))
           $this->erros=TRUE;
   }

   function Enviar()
   {
        $this->Verificar();
        if( !$this->erros )
        {
            //Tenta conectar
            if( !$socket=fsockopen($this->Servidor, $this->Porta, $errno, $errstr, 20) )
                $this->erros=TRUE;

            //Espera por resposta
            $this->Esperar_Resp($socket, "220", __LINE__);

           //Verifica se o email esta sendo autenticado
           //Caso for ele ira mandar um EHLO, pra dizer que vai ser autenticado
           //Caso não for ele manda um HELO simples.
           if( $this->Autenticado )
           {
               fputs($socket, "EHLO " . $this->Servidor . "\r\n");
               $this->Esperar_Resp($socket, "250", __LINE__);

               fputs($socket, "AUTH LOGIN\r\n");
               $this->Esperar_Resp($socket, "334", __LINE__);

               fputs($socket, base64_encode($this->Usuario) . "\r\n");
               $this->Esperar_Resp($socket, "334", __LINE__);

               fputs($socket, base64_encode($this->Senha) . "\r\n");
               $this->Esperar_Resp($socket, "235", __LINE__);

           }
           else
           {
               fputs($socket, "HELO " . $this->Servidor . "\r\n");
               $this->Esperar_Resp($socket, "250", __LINE__);
           }
           
           //Envia quem está mandando o email
           fputs($socket, "MAIL FROM: " . $this->EmailDe . "\r\n");
           $this->Esperar_Resp($socket, "250", __LINE__);

           //Diz ao servidor quem vai receber o email
           fputs($socket, "RCPT TO: " . $this->EmailPara . "\r\n");
           $this->Esperar_Resp($socket, "250", __LINE__);

           //Diz ao servidor que estou pronto para enviar a mensagem
           fputs($socket, "DATA\r\n");
           $this->Esperar_Resp($socket, "354", __LINE__);

           //Cabeçalho do email
           fputs($socket, "From: " . $this->EmailDe . "\r\n");
           fputs($socket, "To: " . $this->EmailPara . "\r\n");
           
           //Mando o assunto do email
           fputs($socket, "Subject: " . $this->Assunto . "\r\n");
           
           //Envia o cabeçalho
           fputs($socket, "MIME-Version: 1.0\r\n");
           fputs($socket, "Content-Type: multipart/mixed;\r\n");
           fputs($socket, "      boundary=KkK170891tpbkKk__FV_KKKkkkjjwq\r\n");
           fputs($socket, "\r\n");
           fputs($socket, "\r\n");
           fputs($socket, "--KkK170891tpbkKk__FV_KKKkkkjjwq\r\n");
           fputs($socket, "Content-Type: text/plain; charset=US-ASCII\r\n");
           fputs($socket, "\r\n");
           fputs($socket, $this->Corpo);
           fputs($socket, "\r\n\r\n");
           
           //verifica se existe arquivo para ser enviado junto
           if($this->NumAnexos>0)
           {
               for($i=0; $i<$this->NumAnexos; $i++)
               {
                   //Pega o tipo para o MIME TYPE
                   $tipo=$this->PegarTipo($this->Anexos[$i]);
                   strtolower($tipo);
                   switch($tipo)
                   {
                       case "jpeg":
                       case "jpg":
                           $Tipo="image/jpeg";
                           break;
                       case "gif":
                           $Tipo="image/gif";
                           break;
                       case "doc":
                           $Tipo="application/msword";
                           break;
                       case "rar":
                           $Tipo="application/rar";
                           break;
                       case "zip":
                           $Tipo="application/zip";
                           break;
                       default:
                          $Tipo="application/octet-stream";
                          break;
                          
                   }
                   //Pega o nome do arquivo
                   $Nome=$this->PegarNome($this->Anexos[$i]);
                   
                   fputs($socket, "--KkK170891tpbkKk__FV_KKKkkkjjwq\r\n");
                   fputs($socket, "Content-Type: " . $Tipo . "; name=\"". $Nome . "\"\r\n");
                   fputs($socket, "Content-Transfer-Encoding: base64\r\n");
                   fputs($socket, "Content-Disposition: attachment; filename=\"" . $Nome . "\"\r\n");
                   fputs($socket, "\r\n");
                   fputs($socket, $this->CodarArquivo($this->Anexos[$i]));
                   fputs($socket, "\r\n");
               }
               fputs($socket, "--KkK170891tpbkKk__FV_KKKkkkjjwq--\r\n");
           }

           //Avisa o servidor que ja acabei de enviar a mensagem
           fputs($socket, "\r\n.\r\n");
           $this->Esperar_Resp($socket, "250", __LINE__);

           //Sai do servidor e fecha o socket
           fputs($socket, "QUIT\r\n");
           fclose($socket);

           //Retorna um TRUE pra dizer que o email foi enviado
           if ($this->erros==TRUE)
              return FALSE;
           else
              return TRUE;
        }
    }
}
?>