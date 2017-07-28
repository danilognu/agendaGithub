<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  //include_once($_SERVER['DOCUMENT_ROOT']."/agendaLets/codigofonte/pessoa/negocio-pessoa.php"); ?>
<?php  include_once($_SERVER['DOCUMENT_ROOT']."/codigofonte/pessoa/negocio-pessoa.php"); ?>
<?php  //include_once("../../pessoa/negocio-pessoa.php"); ?>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

/*if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["cpf"])){ $loCpf = $_REQUEST["cpf"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }*/


$loComum = new comumBO();
$loPessoa = new pessoaBO();


//Verica Acesso
$loDadosAcessoUsuarioCc = $loComum->ListaDadosAcessoUsuarioCorrente();
if(count($loDadosAcessoUsuarioCc) > 0){
    foreach ($loDadosAcessoUsuarioCc as $row){ 

        $loTopAcessoIndOperador = $row["ind_operador"];
        $loTopAcessoIndGestor = $row["ind_gestor"];
        $loTopAcessoIndAdm = $row["ind_adm"];
        $loTopAcessoIndUsuario = $row["ind_usuario"];

    }
}

?>

<br />

<table class="table table-striped table-bordered table-hover order-column" id="">
    <thead>
        <tr>
            <th width="30%">Nome </th>
            <th width="15%">Setor </th> 
            <th width="10%">Validade </th>
            <th width="10%">Telefone </th> 
            <th width="13%">Dias Venc </th> 
            <th width="13%">Dias para Venc </th>
            <th width="5%">Tipo </th> 

        </tr>
    </thead>
    <tbody  >


       <?php
        $loDadosC = array( 
                 'ind_gestor' => $loTopAcessoIndGestor
                , "ind_usuario" => $loTopAcessoIndUsuario
            );

            $loLista =  $loPessoa->ListaMotoristaVencHabilitacao($loDadosC);

            if(count($loLista) > 0 ){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX" style="cursor: pointer;" onclick="javascript:window.location.href='../../pessoa/apresentacao/adicionar-motorista-passageiro.php?acao=U&id=<?php echo $row["id_pessoa"]; ?>&id_menu=8'" >
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td> <?php echo $row["nome_setor"]; ?> </td>
                    <td> <?php echo $row["validade_habilitacao"]; ?> </td>
                    <td> <?php if($row["telefone"]!=""){echo "(".$row["telefone_dd"].")".$row["telefone"];} ?> </td>
                    <td> <?php if($row["DiasVenc"]>0){ echo $row["DiasVenc"]; } ?>  </td>
                    <td> <?php if($row["DiasparaVenc"]>0){ echo $row["DiasparaVenc"];} ?> </td>
                    <td>  </td>                    
                </tr>
            <?php

                }
                
            }

            ?>


    </tbody>
</table>



