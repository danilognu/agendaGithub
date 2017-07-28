<?php
 
// Inclui o arquivo class.phpmailer.php localizado na pasta class
require_once("/PHPMailer/PHPMailerAutoload.php");
 
// Inicia a classe PHPMailer
$mail = new PHPMailer;
 
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
 
try {
     $mail->Host = 'SRVAQAEUROIT2.grupomorada.local'; // Endereço do servidor SMTP (Autenticação, utilize o host smtp.seudomínio.com.br)
     //$mail->SMTPAuth   = true;  // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
     //$mail->SMTPSecure = 'tls';
	 $mail->Port       = 587; //  Usar 587 porta SMTP
     //$mail->Username = ''; // Usuário do servidor SMTP (endereço de email)
     //$mail->Password = ''; // Senha do servidor SMTP (senha do email usado)
 
     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom('tecnologia@grupomorada.com.br', 'Francisco Santos'); //Seu e-mail
     $mail->AddReplyTo('tecnologia@grupomorada.com.br', 'Francisco Santos'); //Seu e-mail
     $mail->Subject = 'Teste de Email';//Assunto do e-mail
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress('danilo.souza@lets.com.br', 'Danilo Souza');
     $mail->AddCC('danilognu@gmail.com.br', 'Francisco Santos'); // Copia
     $mail->AddBCC('kikoluiss@gmail.com', 'Kiko Santos'); // Cópia Oculta
 
     //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     //$mail->AddCC('destinarario@dominio.com.br', 'Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
 
 
     //Define o corpo do email
     $mail->MsgHTML('Corpo do email - teste'); 
 
     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
     //$mail->MsgHTML(file_get_contents('arquivo.html'));
 
     $mail->Send();
     echo "Mensagem enviada com sucesso</p>\n";
 
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
?>