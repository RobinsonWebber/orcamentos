<?php 
 
 $nome_contato = "Robinson";

                    $email_contato = "robinsonwebber@hotmail.com";

                    $assunto_contato = "teste envio anexo"	;

                    $conteudo_completo = "<p>Novo contato enviado em :".date('d/m/Y').

                                        "<p>Nome: ".$nome_contato.

                                        "</p><p>Email: ".$email_contato.

                                        "</p><p><strong>Mensagem: </strong>". "</p>";                                       

                    // Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer

                    include_once("classes/mail/novo/class.phpmailer.php");

                    $mail = new PHPMailer();

                    // Define os dados do servidor e tipo de conexão

                    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

                    $mail->IsSMTP(); // Define que a mensagem será SMTP

                    $mail->Host = "mail.webberimoveis.com.br"; // Endereço do servidor SMTP

                    $mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)

                    $mail->Username = "atendimento@webberimoveis.com.br"; // Usuário do servidor SMTP

                    $mail->Password = "r4v3ng4"; // Senha do servidor SMTP

                    // Define o remetente

                    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

                    $mail->From = "atendimento@webberimoveis.com.br"; // E-mail remetente

                    $mail->FromName = $nome_contato; // Nome remetente
                    

                    // Define os destinatário(s)

                    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=                 

                    $mail->AddAddress('atendimento@webberimoveis.com.br' , 'Atendimento Webber Imoveis');

                    $mail->AddCC('atendimento@webberimoveis.com.br' , 'Atendimento Webber Imoveis'); // Copia

                    $mail->AddBCC('atendimento@webberimoveis.com.br' , 'Atendimento Webber Imoveis'); // Cópia Oculta

                    // Define os dados técnicos da Mensagem

                    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


                    //$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

                    // Define a mensagem (Texto e Assunto)

                    // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=

                    $mail->Subject  = "$assunto_contato"; // Assunto da mensagem

                    $mail->Body = "$conteudo_completo";

                    $mail->AltBody = "$conteudo_completo";
                 // Define os anexos (opcional)

                    $mail->AddAttachment("teste.pdf", "orcamento.pdf");  // Insere um anexo

                    // Envia o e-mail

                    $enviado = $mail->Send();
					
					if ($enviado)
					  echo "bombou!!!";
					  

                    // Após o envio limpa os destinatários e os anexos

                    $mail->ClearAllRecipients();

                    $mail->ClearAttachments();                  

?>
