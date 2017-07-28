<?php
include("../../comum/comum.php");  
include("../negocio-usuario.php");


 $loCodigosPessoaQuemAutorizo = null;
 $loCodigosPessoaQuemMeAutoriza = null;

$loDados = $_REQUEST["dados"];

if(isset($_REQUEST["codigosPessoaQuemAutorizo"]) && !empty($_REQUEST["codigosPessoaQuemAutorizo"])){
        $loCodigosPessoaQuemAutorizo = $_REQUEST["codigosPessoaQuemAutorizo"];
}
if(isset($_REQUEST["codigosPessoaQuemMeAutoriza"]) && !empty($_REQUEST["codigosPessoaQuemMeAutoriza"])){
    $loCodigosPessoaQuemMeAutoriza = $_REQUEST["codigosPessoaQuemMeAutoriza"];
}

$loUsuario = new usuarioBO();

$loRetronoUser = $loUsuario->GravarUsuario($loDados,$loCodigosPessoaQuemAutorizo,$loCodigosPessoaQuemMeAutoriza);

echo json_encode($loRetronoUser);

?>