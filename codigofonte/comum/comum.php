<?php   
session_start();
include("../../conexao.php"); 
include_once("../../comum/negocio-comum.php");  

// Verifica se não há a variável da sessão que identifica o usuário
if (!isset($_SESSION['id_usuario'])) {
    session_destroy();
    header("Location: ../../login/apresentacao/login.php"); exit;
}
$IdMenuAtual = null;
$loComumBO = new comumBO();
if(isset($_REQUEST["id_menu"])){
    $IdMenuAtual = $_REQUEST["id_menu"];
}

/*Verifica Permissao*/
$loDadosAcesso = array('id_usuario' => $_SESSION["id_usuario"], 'id_menu' =>  $IdMenuAtual);
$verificaPermissao = $loComumBO->VerificaPermissao($loDadosAcesso);




?> 
