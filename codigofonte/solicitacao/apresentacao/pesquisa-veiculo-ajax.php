<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-solicitacao.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loPlaca = null;
$loExibirConsulta = 0;
$loChassi = null;


if(isset($_REQUEST["placa"])){ $loPlaca = $_REQUEST["placa"]; }
if(isset($_REQUEST["chassi"])){ $loChassi = $_REQUEST["chassi"]; }
if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }


$loComum = new comumBO();

$loSolicitacao = new solicitacaoBO();

?>

<br />

 <form class="form-inline" id="form-filtro" role="form" method="POST" >


    <div class="form-group">
            
            <label class="col-md-3 control-label">Placa</label>
            <div class="col-md-2">
                <input type="text" id="filtro-placa" name="filtro-placa" class="form-control mask_placa" value="<?php echo $loPlaca; ?>"  size="5" >
            </div>

        </div>
        <div class="form-group">
                <label class="col-md-2 control-label">Chassi</label>
                <div class="col-md-3">
                <input type="text" id="filtro-chassi" name="filtro-chassi" class="form-control" size="20" >
            </div>                                           
        </div>
    
    
    <div class="checkbox">
    </div>
    <a href="#" onclick="PesquisaVeiculos();" class="btn sbold dark"> 
            <i class="fa fa-search"></i>
    </a>
</form>

<br />



<br />

<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
        <tr>
            <th width="2%"></th>
            <th width="15%">Placa </th>
            <th width="20%">Modelo </th> 
            <th width="20%">Chassi </th> 
            <th width="15%">Dt Saida Soli</th>
            <th width="15%">Dt Retorno Soli</th> 
            <th width="10%">A&ccedil;&atilde;o  </th> 

        </tr>
    </thead>
    <tbody  >


       <?php

            $loDadosC = array( 
                    'id' => $loId 
                    , 'placa' => $loPlaca
                    , 'chassi' => $loChassi
                    , 'status' => '1'
                );


            $loLista =  $loSolicitacao->ListaVeiculo($loDadosC);

            if(count($loLista) > 0 && $loExibirConsulta == 1){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >

                    <td>  </td>   
                    <td> <?php echo $row["placa"]; ?> </td>
                    <td> <?php echo $row["nomeModelo"]; ?>  </td>
                    <td> <?php echo $row["chassi"]; ?>  </td>
                    <td> <?php echo $row["dt_saida_solicitacao"]; ?>  </td>
                    <td> <?php echo $row["dt_retorno_solicitacao"]; ?>  </td>
                    <td> 
                         <button id="btn-adicionar" onclick="Adicionar('<?php echo $row["placa"]; ?>',<?php echo $row["id_veiculo"];?> );" class="btn sbold dark"> 
                            <i class="fa fa-plus"></i>
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




function PesquisaVeiculos(){

        var loPlaca = $("#filtro-placa").val(); 
        var loChassi = $("#filtro-chassi").val();

        $.ajax({
                data: {
                    placa: loPlaca
                    ,chassi: loChassi
                    ,exibirConsulta: 1
                }
                , type: "POST"
                , url: "pesquisa-veiculo-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);

                }
        });


}

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
    //$("#select-veiculo").val(id);
    //console.log($("#select-veiculo"));
    // $('#select-veiculo option[value="' + id + '"]').attr('selected','selected');
    // console.log($('#select-veiculo option[value="' + id + '"]'));
    //$("#codigo-veiculo").val(id);

    $('#select-veiculo option[value='+id+']').attr('selected','selected');
    $("#select2-select-veiculo-container").attr("title",nome);
    $("#select2-select-veiculo-container").text(nome);

}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>