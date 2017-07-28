<?php

require_once '../comum/PHPMailer-master/class.phpmailer.php';

// Instanciar a classe para envio de email
$mail = new PHPMailer(true);

// Vamos tentar realizar o envio
try {

    // Remetente
    $mail->AddReplyTo('meunome@example.com', 'Meu Nome');
    $mail->SetFrom('meunome@example.com', 'Meu Nome');

    // Destinatário
    $mail->AddAddress('danilo.souza@lets.com.br', 'Destinatário');

    // Assunto
    $mail->Subject = 'Segue ficheiro anexo com XPTO';

    // Mensagem para clientes de email sem suporte a HTML
    $mail->AltBody = 'Em anexo o ficheiro com XPTO.';

    // Mensagem para clientes de email com suporte a HTML
    $mail->MsgHTML('<p>Em anexo o ficheiro com XPTO.</p>');

    // Adicionar anexo
    $caminho = 'apresentacao/autorizacoes/';
    $ficheiro = 'AutorizacaoDeSolicitacao_35_20161220143529.pdf';

    $mail->AddAttachment($caminho.$ficheiro);

    // Enviar email
    $mail->Send();

    echo "Mensagem enviada!";
}
catch (phpmailerException $e) {
    // Mensagens de erro do PHPMailer
    echo $e->errorMessage();
}
catch (Exception $e) {
    // Outras mensagens de erro
    echo $e->getMessage();
}

?>