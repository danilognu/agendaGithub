<?php  include_once("../../comum/comum.php");  ?>
<?php  include_once("../../comum/negocio-comum.php");  ?>
<?php  include_once("../../pessoa/negocio-pessoa.php");  ?>
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

$loPessoa = new pessoaBO();

?>

<br />

 <form class="form-inline" id="form-filtro" role="form" method="POST" >


    <div class="form-group">
            
            <label class="col-md-2 control-label">Nome</label>
            <div class="col-md-2">
                <input type="text" id="filtro-nome" name="filtro-nome" class="form-control input-sm" value="<?php echo $loNome; ?>"  size="30" >
            </div>

        </div>
        <div class="form-group">
                <label class="col-md-2 control-label">CPF</label>
                <div class="col-md-2">
                <input type="text" id="filtro-cpf" name="filtro-cpf" class="form-control input-sm mask_cpf" size="20" >
            </div>                                           
        </div>
    
    
    <div class="btn-group btn-group-sm btn-group-solid">
        <a href="#" onclick="PesquisaPassageiro();" class="btn dark"> 
            <i class="fa fa-search"></i>
        </a>
    </div>

</form>

<br />


<div class="col-md-6">
    <div class="btn-group btn-group-sm btn-group-solid">
        <button id="btn-adicionar" onclick="Adicionar();" class="btn dark"> Adicionar
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
            <th>Nome </th>
            <th>Motorista </th> 

        </tr>
    </thead>
    <tbody  >


       <?php
       if($loExibirConsulta == 1){

        $loDadosC = array( 
                'tipo_pessoa' => '4,5'
                , 'id' => '' 
                , 'nome' => $loNome
                , 'cpf' => $loCpf 
                , 'ind_passageiro' => '1'
            );

            $loLista =  $loPessoa->ListaPessoa($loDadosC);

            if(count($loLista) > 0){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td>
                        <input type="checkbox" class="checkboxes" value="<?php echo $row["id_pessoa"]; ?>" name="checkboxes-" value="" /> 
                    </td>
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td>  </td>

                </tr>
            <?php

                }
                
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



function PesquisaPassageiro(){

        var loNome = $("#filtro-nome").val(); 
        var loCpf = $("#filtro-cpf").val();

        $.ajax({
                data: {
                    nome: loNome
                    ,cpf: loCpf
                    ,exibirConsulta: 1 
                }
                , type: "POST"
                , url: "pesquisa-passageiros-ajax.php"
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