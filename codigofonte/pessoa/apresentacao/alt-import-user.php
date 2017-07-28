<?php
include("../../comum/comum.php");  
include("../../usuario/negocio-usuario.php");  
include("../negocio-pessoa.php");  

$loConsultaPessoa = new pessoaBO();
$loDados = array("idmax" => 114, "tipo" => "", "idNotUsuario" => "" );

$loConsulta = new usuarioBO();
$loRetrono = $loConsulta->ListaUsuarios($loDados);
foreach ($loRetrono as $row) {

    $loConsultaPessoa->InserirCamposTabelasDinamica($row["id_usuario"]);
    echo "<br /><br />";

}

?>