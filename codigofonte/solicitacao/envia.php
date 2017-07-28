<?php 
 
// print_r($_FILES["arquivo"]);
//exit;
 
if( PATH_SEPARATOR ==';'){ $quebra_linha="\r\n";
 
} elseif (PATH_SEPARATOR==':'){ $quebra_linha="\n";
 
} elseif ( PATH_SEPARATOR!=';' and PATH_SEPARATOR!=':' )  {echo ('Esse script não funcionará corretamente neste servidor, a função PATH_SEPARATOR não retornou o parâmetro esperado.');
 
}
 
//pego os dados enviados pelo formulário 
$nome_para = $_POST["nome_para"]; 
$email = $_POST["email"]; 
$mensagem = $_POST["mensagem"]; 
$assunto = $_POST["assunto"]; 
$email_from = "danilo.souza@lets.com.br";
//formato o campo da mensagem 
$mensagem = wordwrap( $mensagem, 50, "<br>", 1); 
 

 
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE; 
 
if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){ 
 
$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb"); 
$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"])); 
$anexo = base64_encode($anexo); 
 
fclose($fp); 
 
$anexo = chunk_split($anexo); 
 
 
$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 
 
$mens = "--$boundary" . $quebra_linha . ""; 
$mens .= "Content-Transfer-Encoding: 8bits" . $quebra_linha . ""; 
$mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $quebra_linha . "" . $quebra_linha . ""; //plain 
$mens .= "$mensagem" . $quebra_linha . ""; 
$mens .= "--$boundary" . $quebra_linha . ""; 
$mens .= "Content-Type: ".$arquivo["type"]."" . $quebra_linha . ""; 
$mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"" . $quebra_linha . ""; 
$mens .= "Content-Transfer-Encoding: base64" . $quebra_linha . "" . $quebra_linha . ""; 
$mens .= "$anexo" . $quebra_linha . ""; 
$mens .= "--$boundary--" . $quebra_linha . ""; 
 
$headers = "MIME-Version: 1.0" . $quebra_linha . ""; 
$headers .= "From: $email_from " . $quebra_linha . ""; 
$headers .= "Return-Path: $email_from " . $quebra_linha . ""; 
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"" . $quebra_linha . ""; 
$headers .= "$boundary" . $quebra_linha . ""; 
 
 
//envio o email com o anexo 
mail("danilo.souza@lets.com.br",$assunto,$mens,$headers, "-r".$email_from); 
 
echo"Email enviado com Sucesso!"; 
 
} 
 
//se nao tiver anexo 
else{ 
 
$headers = "MIME-Version: 1.0" . $quebra_linha . ""; 
$headers .= "Content-type: text/html; charset=iso-8859-1" . $quebra_linha . ""; 
$headers .= "From: $email_from " . $quebra_linha . ""; 
$headers .= "Return-Path: $email_from " . $quebra_linha . ""; 
 
//envia o email sem anexo 
mail("danilo.souza@lets.com.br",$assunto,$mensagem, $headers, "-r".$email_from); 
 
 
echo"Email enviado com Sucesso!"; 
} 
 
?>