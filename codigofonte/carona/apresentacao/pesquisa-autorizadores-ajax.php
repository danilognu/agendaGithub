<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../solicitacao/negocio-solicitacao.php");  ?>

<?php  include_once("../negocio-carona.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loIdSolicitacao = null;
$loNome = null;
$loStatus = null;
$loIdMenu = null;
$loCpf = null;
$loExibirConsulta = null;

if(isset($_REQUEST["id"])){ $loIdSolicitacao = $_REQUEST["id"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }

if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }


$loComum = new comumBO();
$loCarona = new caronaBO();
$loSolicitacao = new solicitacaoBO();

?>
 <form class="form-inline" id="form-filtro" role="form" method="POST" >


    <div class="form-group">
            
            <label class="col-md-3 control-label">Nome</label>
            <div class="col-md-2">
                <input type="text" id="filtro-nome" name="filtro-nome" class="form-control input-sm" value="<?php echo $loNome; ?>"  size="30" >
            </div>

        </div>
    
    
    <div class="checkbox">
    </div>
    <div class="form-group btn-group btn-group-sm btn-group-solid">
    <a href="#" onclick="Carona.ModalPesquisaAutorizador(<?php echo $loIdSolicitacao; ?>);" class="btn sbold dark"> 
            <i class="fa fa-search"></i>
    </a>
    </div>
</form>

<br />

<table class="table table-striped table-bordered table-hover order-column" id="">
    <thead>
        <tr>
            <th width="50%">Nome </th>
            <th width="30%">E-mail </th> 
            <th width="15%">A&ccedil;&atilde;o  </th> 

        </tr>
    </thead>
    <tbody  >


       <?php
        $loDadosC = array( 
                 'id' => $loIdSolicitacao
                 ,'nome_requisitante' => $loNome
            );

            $loLista =  $loSolicitacao->ListaSolicitacao($loDadosC);

            if(count($loLista) > 0 && $loExibirConsulta == 1){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >

                    <td> <?php echo $row["nome_requisitante"]; ?> </td>
                    <td> <?php echo $row["email_requisitante"]; ?>  </td>
                    <td> 
                         <button id="" onclick="Carona.EnviaEmailAutorizador(<?php echo $row["id_pessoa_requisitante"];?>,<?php echo $loIdSolicitacao;?> );" class="btn sbold dark"> 
                            Encaminhar <i class="fa fa-mail-forward"></i>
                        </button>
                    </td>

                </tr>
            <?php

                }
                
            }

            ?>


    </tbody>
</table>



<script>

function marcardesmarcar(){
  $('.checkboxes').each(
         function(){
           if ($(this).prop( "checked")) 
           $(this).prop("checked", false);
           else $(this).prop("checked", true);               
         }
    );
}


function Adicionar(nome,id){

    jQuery('#dialog-message').dialog('close');
    $("#id-gestor").val(id);
    Solicitacao.PubGravaDados();

}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>