<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../localidade/negocio-localidade.php");  ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php

$loId = null;
$loNome = null;
$loEndereco = null;
$loConsulta = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
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
            <label class="col-md-2 control-label">Nome</label>
            <div class="col-md-2">
                <input type="text" id="filtro-nome" name="filtro-nome" class="form-control input-sm"  size="30" >
            </div>
     </div>
   

    <div class="form-group">
            <label class="col-md-2 control-label">Endere&ccedil;o</label>
            <div class="col-md-2">
                <input type="text" id="filtro-endereco" name="filtro-endereco" class="form-control input-sm"  size="30" >
            </div>
     </div>
    
    <div class="btn-group btn-group-sm btn-group-solid">
        <a href="#" onclick="PesquisaLocalidade();" class="btn dark"> 
                <i class="fa fa-search"></i>
        </a>
    </div >


    <input type="hidden" id="consulta" name="consulta" value="<?php echo $loConsulta; ?>" >
</form>

<br />


<div class="col-md-6">
    <div class="btn-group btn-group-sm btn-group-solid">
        <button id="btn-adicionar" onclick="Adicionar('<?php echo $loConsulta; ?>');" class="btn dark"> Adicionar
            <i class="fa fa-plus"></i>
        </button>
    </div>
</div>

<br />

<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
        <tr>
            <th>
                <input type="checkbox" class="group-checkable" onclick="marcardesmarcar();" data-set="#sample_1 .checkboxes" /> 
            </th>
            <th width="30%">Nome </th>
            <th width="40%">Endere&ccedil;o </th>
            <th width="10%">Numero </th> 
            <th width="10%">Bairro </th>
            <th width="10%">Cidade </th>

        </tr>
    </thead>
    <tbody  >


       <?php
            $loDadosC = array( 
                      'nome' => $loNome
                    , 'endereco' => $loEndereco
                    , 'status' => '1'
                );

            $loLista =  $loLocalidade->ListaLocalidade($loDadosC);

            if(count($loLista) > 0 && $loExibirConsulta == 1){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td>
                        <input type="checkbox" class="checkboxes" value="<?php echo $row["id_localidade"]; ?>" name="checkboxes-" value="" /> 
                    </td>
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td> <?php echo $row["endereco"]; ?> </td>
                    <td> <?php echo $row["numero"]; ?> </td>
                    <td> <?php echo $row["bairro"]; ?> </td>
                    <td> <?php echo $row["nome_cidade"]."/".$row["uf"]; ?> </td>

                </tr>
            <?php

                }
                
            }

            ?>


    </tbody>
</table>



<script>



/*if($("#nome-passageiro-pesq").val() != ""){
    $("#filtro-nome").val($("#nome-passageiro-pesq").val());
    PesquisaPassageiro();
    $("#nome-passageiro-pesq").val("");
}*/



function PesquisaLocalidade(){

        var loNome = $("#filtro-nome").val(); 
        var loEndereco = $("#filtro-endereco").val();
        var loConsulta = $("#consulta").val();

        $.ajax({
                data: {
                    nome: loNome
                    ,endereco: loEndereco
                    ,consulta: loConsulta
                    ,exibirConsulta: 1
                }
                , type: "POST"
                , url: "pesquisa-localidade-ajax.php"
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


function Adicionar(consulta){

    var loIdSolicitacao = $("#id").val()
    var camposMarcados = new Array();
    var validaCampos = false;

    if(consulta == "paradas"){

       $('.checkboxes').each( //Busca Todos os itens 
         function(){           
           if ($(this).prop( "checked")) { //Verifica se item esta selecionado

               camposMarcados.push($(this).val()); // cria array
               var codigoSelecionados = $(this).val();

               
                //BEGIN GRID
                $('.codigo-localidade-paradas').each(function () { //Verifica todos os passageiros cadastrado na grid
                    
                    var codigoCadastradoGridElemento = $(this).val();
                    codigoCadastradoGridTrim = codigoCadastradoGridElemento.trim();

                    if(codigoCadastradoGridTrim.indexOf(":") > 0){
                        var codigoCadastradoGridSplit = codigoCadastradoGridTrim.split(":");
                        codigoCadastradoGrid = codigoCadastradoGridSplit[0];
                    }else{
                        codigoCadastradoGrid = codigoCadastradoGridTrim;
                    }

                    if( (codigoSelecionados.trim() == codigoCadastradoGrid) || (codigoSelecionados.trim()+":0" == codigoCadastradoGrid) ){
                        validaCampos = true;
                    }

                });
                //END GRID

            }              
            }
        );

        //console.log(camposMarcados);

    }else{
        
        $('.checkboxes').each(
                function(){           
                if ($(this).prop( "checked")) {
                    camposMarcados.push($(this).val());
                }              
                }
            );

    }

    if(consulta == "origem" && camposMarcados.length > 1){

                    bootbox.dialog({
                        message: "Por favor Selecione somente um Item para Origem!",
                        title: "Aviso",
                        buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                        }
                    });

    }else{

         
        if(consulta == "paradas"){


            if(validaCampos){

                bootbox.dialog({
                            message: "Destino selecionado ja esta cadastrado, por favor, selecione outro!",
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
                                ,consulta: consulta 
                                ,id_solicitacao: loIdSolicitacao
                            }
                            , type: "POST"
                            , dataType: "json"
                            , url: "lista-destinos-ajax.php"
                            , success: function (retorno) {

                                jQuery('#dialog-message').dialog('close');
                                for (var i = 0; i < retorno.length; i++) {
                                    var newRow = $("<tr>");
                                    var contaItemAdicionado = $(".codigo-localidade-paradas").length + 1;
                                    newRow.append(contaItemAdicionado);
                                    newRow.append(retorno[i].td);
                                    $("#table-paradas").append(newRow);

                                }

                            }
                    });
            }

        }else{

            $.ajax({
                    data: {
                        dados: camposMarcados
                        ,consulta: consulta 
                        ,id_solicitacao: loIdSolicitacao
                    }
                    , type: "POST"
                    , url: "lista-localidade-ajax.php"
                    , success: function (retorno) {
                        jQuery('#dialog-message').dialog('close');
                        $("#grupo-"+consulta).html(retorno);
                    }
            });
        }


    }

    
}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>