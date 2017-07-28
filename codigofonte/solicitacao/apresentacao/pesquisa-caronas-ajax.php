<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../negocio-solicitacao.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loStatus = null;
$loIdMenu = null;
$loCpf = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["cpf"])){ $loCpf = $_REQUEST["cpf"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }

if(isset($_REQUEST["exibirConsulta"])){ $loExibirConsulta = $_REQUEST["exibirConsulta"]; }

$loComum = new comumBO();
$loSolicitacao = new solicitacaoBO();

?>

<br />  

<!--div class="col-md-6">
    <div class="btn-group btn-group-sm btn-group-solid">
        <button id="btn-adicionar" onclick="AdicionarSolicitacaoCarona(<?php //echo $loId; ?>);" class="btn dark"> Abrir Solicita&ccedil;&atilde;o Nr: <?php echo $loId; ?>
            <i class="fa fa-mail-forward"></i>
        </button>
    </div>
</div-->

<br />

<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
    <thead>
        <tr>
            <!--th>
                <input type="checkbox" class="group-checkable" onclick="marcardesmarcar();" data-set="#sample_1 .checkboxes" /> 
            </th-->
            <th width="20%">Nome Solicitante </th>
            <th width="">Data Solicitado </th>
            <th width="">Origem</th>
            <th width="">Ult Destino</th>
            <th width="8%">Qtd Pass Veic</th>
            <th width="8%">Qtd Pass Solic</th>
            <th width="17%">A&ccedil;&atilde;o</th>
        </tr>
    </thead>
    <tbody  >


       <?php
       if($loExibirConsulta == 1){

            $loDados = array('id_solicitacao' => $loId);

            $loLista =  $loSolicitacao->ListaCaronasSolicitadas($loDados);

            $loQtdPassageiroSolicitacao = 0;
            if(count($loLista) > 0){

                foreach ($loLista as $row){

                    $loQtdPassageiroSolicitacao = $row["qtd_passageiro"];
                    if($row["id_pessoa_motorista"] != ""){
                        $loQtdPassageiroSolicitacao++;
                    }
                    
         ?>

                <tr class="odd gradeX"  >
                    <!--td>
                        <input type="checkbox" class="checkboxes" value="<?php //echo $row["id_pessoa"]; ?>" name="checkboxes-" value="" /> 
                    </td-->
                    <td> 
                        <?php echo $row["nome_pessoa_solicitante"]; ?> 
                        <div class="btn-group btn-group-sm btn-group-solid" style='padding-left:20px;' >
                            <button id=""  class="btn" onClick='Solicitacao.ListaDadosPessoaSolicitadaCarona(<?php echo $row["id_pessoa_solicitante"]; ?>)' >
                                <i class="fa fa-eye" title='Ver Dados da Pessoa' ></i> 
                            </button> 
                        </div>
                    </td>
                    <td> <?php echo $row["dt_cad"]; ?> </td>
                    <td> <?php echo $row["origem"]; ?> </td>
                    <td> <?php echo $row["ultimo_destino"]; ?> </td>
                    <td> <?php echo $row["qtd_passageiro_veiculo"]; ?> </td>
                    <td> <?php echo $loQtdPassageiroSolicitacao; ?> </td>
                    <td> 
                        <div class="btn-group btn-group-sm btn-group-solid" id="div-acao-carona-<?php echo $row["id_pessoa_solicitante"]; ?>">
                            <button id="aprovar-carona-moral-<?php echo $row["id_pessoa_solicitante"]; ?>" onClick="AprovarNegarCaronaUnica(<?php echo $row["id_pessoa_solicitante"]; ?>,<?php echo $loId; ?>,'A');"  class="btn btn-success"> 
                                Aprovar <i class="fa fa-check"></i>
                            </button> 
                            <button id="negar-carona-<?php echo $row["id_pessoa_solicitante"]; ?>" onClick="AprovarNegarCaronaUnica(<?php echo $row["id_pessoa_solicitante"]; ?>,<?php echo $loId; ?>,'C');" class="btn red"> 
                                Negar <i class="fa fa-check"></i>
                            </button> 
                        </div>
                    </td>

                </tr>
            <?php

                }
                
            }
       }

            ?>


    </tbody>
</table>



<script>
function AdicionarSolicitacaoCarona(id_solicitacao){
        //window.location.href = "adicionar-solicitacao.php?acao=U&id="+id_solicitacao+"&id_menu=12&atendimento=1";
        window.open("adicionar-solicitacao.php?acao=U&id="+id_solicitacao+"&id_menu=12&atendimento=1&removeTop=S", "_blank", "width=1300 height=600");
}


function AprovarNegarCaronaUnica(id_pessoa_solicitante,id_solicitacao,status){

       var loDados = jQuery.parseJSON( '{ "id_pessoa_solicitante": "'+id_pessoa_solicitante+'", "id_solicitacao": "'+id_solicitacao+'", "status": "'+status+'" }' );

        $.ajax({
                data: {
                    dados: loDados
                }
                , type: "POST"
                , dataType: "json"
                , url: "envia-aprovacao-negacao-carona-ajax.php"
                , success: function (retorno) {

                    if(status == "A"){
                        $("#aprovar-carona-moral-"+id_pessoa_solicitante).hide();
                        $("#negar-carona-"+id_pessoa_solicitante).hide();
                        $("#div-acao-carona-"+id_pessoa_solicitante).html("<strong>Aprovado</strong>");    
                    }else{
                        $("#aprovar-carona-moral-"+id_pessoa_solicitante).hide();
                        $("#div-acao-carona-"+id_pessoa_solicitante).html("<strong>Negado</strong>");   
                    }

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


function Adicionar(){

  validaCampos = false;
  camposMarcados = new Array();
  $('.checkboxes').each( //Busca Todos os itens 
         function(){           
           if ($(this).prop( "checked")) { //Verifica se item esta selecionado

               camposMarcados.push($(this).val()); // cria array
               var passageiroSelecionados = $(this).val();
                
                //BEGIN GRID
                $('.codigo-passageiros').each(function () { //Verifica todos os passageiros cadastrado na grid
                    
                    var passageiroCadastradoGrid = $(this).val();

                    if(passageiroSelecionados.trim() == passageiroCadastradoGrid.trim()){
                        validaCampos = true;
                    }

                });
                //END GRID

           }              
         }
    );


    if(validaCampos){

        bootbox.dialog({
            message: "Passageiro selecionado ja esta cadastrado, por favor, selecione outro!",
            title: "Aviso",
            buttons: {
                success: {
                    label: "OK",
                    className: "dark"
                }
            }
        });                                   

    }else{

        $.ajax({
                    data: {
                        dados: camposMarcados
                    }
                    , type: "POST"
                    , dataType: "json"
                    , url: "lista-passageiros-ajax.php"
                    , success: function (retorno) {

                        for (var i = 0; i < retorno.length; i++) {
                            //console.log(retorno[i].td);
                            var newRow = $("<tr>");
                            newRow.append(retorno[i].td);
                            $("#table-passageiros").append(newRow);

                        }

                        //Conta passageiros BEGIN ------
                        $(".qtd-passageiro-visual").val($(".codigo-passageiros").length);
                        //Conta Passageiros END   ------

                        jQuery('#dialog-message').dialog('close');

                    }
            });

    }

    
}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>