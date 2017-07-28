<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../localidade/negocio-localidade.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loEndereco = null;
$loConsulta = null;
$loAcao = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["acao"])){ $loAcao = $_REQUEST["acao"]; }
if(isset($_REQUEST["endereco"])){ $loEndereco = $_REQUEST["endereco"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["consulta"])){ $loConsulta = $_REQUEST["consulta"]; }

if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }



$loComum = new comumBO();

$loLocalidade = new localidadeBO();

?>

<br />

 <form class="form-inline" id="form-filtro" role="form" method="POST" >


    <div class="form-group">
            <label class="col-md-3 control-label">Nome</label>
            <div class="col-md-2">
                <input type="text" id="filtro-nome" name="filtro-nome" class="form-control"  size="30" >
            </div>
     </div>
   

    <div class="form-group">
            <label class="col-md-3 control-label">Endere&ccedil;o</label>
            <div class="col-md-2">
                <input type="text" id="filtro-endereco" name="filtro-endereco" class="form-control"  size="30" >
            </div>
     </div>
    
    <div class="checkbox">
    </div>
    <a href="#" onclick="PesquisaLocalidade();" class="btn sbold dark"> 
            <i class="fa fa-search"></i>
    </a>

    <input type="hidden" id="consulta" name="consulta" value="<?php echo $loConsulta; ?>" >
    <input type="hidden" id="acao" name="acao" value="<?php echo $loAcao; ?>" >
</form>

<br />



<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
        <tr>
            <th>
            </th>
            <th width="30%">Nome </th>
            <th width="40%">Endere&ccedil;o </th>
            <th width="10%">Numero </th> 
            <th width="10%">Bairro </th>
            <th width="10%">Cidade </th>
            <th>Item </th>

        </tr>
    </thead>
    <tbody  >


       <?php
            $loDadosC = array( 
                      'nome' => $loNome
                    , 'endereco' => $loEndereco
                    , 'status' => '1'
                    , 'garagem' => 'S'
                );

            $loLista =  $loLocalidade->ListaLocalidade($loDadosC);

            if(count($loLista) > 0 && $loExibirConsulta == 1){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td>
                    </td>
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td> <?php echo $row["endereco"]; ?> </td>
                    <td> <?php echo $row["numero"]; ?> </td>
                    <td> <?php echo $row["bairro"]; ?> </td>
                    <td> <?php echo $row["nome_cidade"]."/".$row["uf"]; ?> </td>
                    <td>
                        <button id="btn-adicionar" onclick="Adicionar('<?php echo $row["nome"]." - ".$row["endereco"]; ?>',<?php echo $row["id_localidade"];?>);" class="btn sbold dark"> 
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


function PesquisaLocalidade(){

        var loNome = $("#filtro-nome").val(); 
        var loEndereco = $("#filtro-endereco").val();
        var loConsulta = $("#consulta").val();
        var loAcao = $("#acao").val();

        $.ajax({
                data: {
                    nome: loNome
                    ,endereco: loEndereco
                    ,consulta: loConsulta
                    ,exibirConsulta: 1
                    ,acao: loAcao
                }
                , type: "POST"
                , url: "pesquisa-garagem-ajax.php"
                , success: function (retorno) {

                    $("#dialog-modal").html(retorno);

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


function Adicionar(nome,id,acao){

    var id_garagem_atual = $("#id-garagem-atual").val();
    jQuery('#dialog-modal').dialog('close');
    $("#garagem-nome").val(nome);
    $("#garagem-codigo").val(id);
    
    if( $("#acao").val() == "U" && id_garagem_atual != 0 ){
        $(".motivo-troca-garagem").css("display", "block");
    }

    
}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>