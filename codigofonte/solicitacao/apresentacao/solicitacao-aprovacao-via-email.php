<?php
session_start();
include("../../conexao.php"); 
//include("../../comum/comum.php");
include_once("../../comum/negocio-comum.php");  
include("../negocio-solicitacao.php"); 


$loIdSolicitacao = $_REQUEST["id_solicitacao"];
$loTipoAprovacao = $_REQUEST["tipo_aprovacao"];
$loIdUsuario = $_REQUEST["id_usuario"];

$_SESSION["id_usuario"] = $loIdUsuario;

$loDados = array("id_solicitacao" => $loIdSolicitacao, 'tipo_aprovacao' => $loTipoAprovacao, 'id_usuario' => $loIdUsuario);

$loSolicitacao = new solicitacaoBO();
$loRetrono = $loSolicitacao->AprovacaoViaEmail($loDados);


?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Aprova&ccedil;&atilde; via E-mail SSL</title>
    
         <?php include("../../comum/apresentacao/cabecalho.php"); ?>
        <link href="../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />

        <link href="../../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="../../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

        <h3>Solicita&ccedil;&atilde;o de Aprova&ccedil;&atilde;o via E-mail. </h3>

        <br />

        <?php if($loRetrono["erro"]){ ?>

            <div class="alert alert-danger"> <strong>Error!</strong> ocorreu um problema ao aprovar a solicita&ccedil;&atilde;o. </div>

        <?php }else{ ?>

            <div class="alert alert-warning"><strong>Solicita&ccedil;&atilde;o de n&uacute;mero: <?php echo $loIdSolicitacao; ?> </strong>, dados enviados com sucesso ao requisitante. </div>

        <?php } ?>

        <?php include("../../comum/apresentacao/scripts.php"); ?>

        <script src="../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>

        <script src="js/solicitacao.js" type="text/javascript"></script>
        <script src="../../comum/js/comum.js" type="text/javascript"></script>
        <script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>

        <script src="../../../assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>

        <script src="../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="../../../assets/pages/scripts/table-datatables-managed.js" type="text/javascript"></script>
        <script src="../../../assets/global/plugins/select2/js/select2.full.js" type="text/javascript"></script>
    </body>

</html>