<?php
include("../../comum/comum.php");  
include("../negocio-pessoa.php");


//$loDados = $_REQUEST["dados"];

$loAcao         = $_POST["acao"];
$loId           = $_POST["id"];
$loNome         = $_POST["nome"];

if(isset($_POST["nomeFantasia"])) $loNomeFantasia   = $_POST["nomeFantasia"];   else $loNomeFantasia  = "";
if(isset($_POST["cep"]))          $loCep            = $_POST["cep"];            else $loCep  = "";
if(isset($_POST["endereco"]))     $loEndereco       = $_POST["endereco"];       else $loEndereco  = "";
if(isset($_POST["bairro"]))       $loBairro         = $_POST["bairro"];         else $loBairro  = "";
if(isset($_POST["numero"]))       $loNumero         = $_POST["numero"];         else $loNumero  = "";
if(isset($_POST["estado"]))       $loEstado         = $_POST["estado"];         else $loEstado  = "";
if(isset($_POST["cidade"]))       $loCidade         = $_POST["cidade"];         else $loCidade  = "";
if(isset($_POST["complemento"]))  $loComplemento    = $_POST["complemento"];    else $loComplemento  = "";
if(isset($_POST["email"]))        $loEmail          = $_POST["email"];          else $loEmail  = "";
if(isset($_POST["status"]))       $loStatus         = $_POST["status"];         else $loStatus  = "";
if(isset($_POST["ind-carona"]))   $loCarona         = $_POST["ind-carona"];     else $loCarona  = "";

if($loCarona == "on"){$loIndloCarona = 1;}else{$loIndloCarona = 0;}


if(isset($_POST["validacao"]))    $loValidacao      = $_POST["validacao"];      else $loValidacao  = "0";

if(isset($_POST["cnpj"])){
     $loCnpj = str_replace(".", "", str_replace("/", "", str_replace("-", "", $_POST["cnpj"])));   
}else{
     $loCnpj = "";
}

if(isset($_POST["telefone"])){
     $loTelefone = str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST["telefone"])));   
}else{
     $loTelefone = "";
}

if(isset($_POST["celular"])){
     $loCelular = str_replace("(", "", str_replace(")", "", str_replace("-", "", $_POST["celular"])));
}else{
     $loCelular = "";
}


$loDados = array(
    "nome" => $loNome
    ,"nome_fantasia" => $loNomeFantasia
    ,"cnpj" => $loCnpj
    ,"cep" => $loCep
    ,"endereco" => $loEndereco
    ,"bairro" => $loBairro
    ,"numero" => $loNumero
    ,"estado" => $loEstado
    ,"id_cidade" => $loCidade
    ,"complemento" => $loComplemento
    ,"telefone" => $loTelefone
    ,"celular" => $loCelular
    ,"email" => $loEmail 
    ,"status" => $loStatus
    ,"acao" => $loAcao
    ,"id" => $loId
    ,'logoArquivo' => $_FILES
    ,'validacao' => $loValidacao
    ,'ind_carona' => $loIndloCarona
);


$loCliente = new pessoaBO();

$loRetrono = $loCliente->GravarEmpresa($loDados);

if($loValidacao == "1"){
    echo json_encode($loRetrono);
}else{
    echo "<script>
            window.location.href = 'adicionar-empresa.php?acao=U&id=".$loId."&erro=".$loRetrono["erro"]."&messagem=".$loRetrono["messagem"]."&id_menu=24'
        </script>";
}

?>