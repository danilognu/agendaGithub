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
$loExibirConsulta = 0;

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
            
            <label class="col-md-3 control-label">Nome</label>
            <div class="col-md-2">
                <input type="text" id="filtro-nome" name="filtro-nome" class="form-control" value="<?php echo $loNome; ?>"  size="30" >
            </div>

        </div>
        <div class="form-group">
                <label class="col-md-2 control-label">CPF</label>
                <div class="col-md-3">
                <input type="text" id="filtro-cpf" name="filtro-cpf" class="form-control mask_cpf" size="20" >
            </div>                                           
        </div>
    
    
    <div class="checkbox">
    </div>
    <a href="#" onclick="PesquisaPassageiro();" class="btn sbold dark"> 
            <i class="fa fa-search"></i>
    </a>
</form>

<br />



<br />

<table class="table table-striped table-bordered table-hover order-column" id="">
    <thead>
        <tr>
            <th width="50%">Nome </th>
            <th width="30%">Cpf </th> 
            <th width="15%">A&ccedil;&atilde;o  </th> 
        </tr>
    </thead>
    <tbody  >


       <?php
        $loDadosC = array( 
                'tipo_pessoa' => '4,6'
                , 'id' => '' 
                , 'nome' => $loNome
                , 'cpf' => $loCpf 
                , 'ind_motorista' => '1'
            );

            $loLista =  $loPessoa->ListaPessoa($loDadosC);

            if(count($loLista) > 0 && $loExibirConsulta == 1){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td> <?php echo $row["cpf"]; ?>  </td>
                    <td class="btn-group btn-group-sm btn-group-solid"> 
                         <button id="btn-adicionar" onclick="Adicionar('<?php echo $row["nome"]; ?>',<?php echo $row["id_pessoa"];?> );" class="btn dark"> 
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
                , url: "pesquisa-motorista-ajax.php"
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
    //$("#nome-motorista").val(nome);
    //$("#codigo-motorista").val(id);

    $('#select-motorista option[value='+id+']').attr('selected','selected');
    $("#select2-select-motorista-container").attr("title",nome);
    $("#select2-select-motorista-container").text(nome);

}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>