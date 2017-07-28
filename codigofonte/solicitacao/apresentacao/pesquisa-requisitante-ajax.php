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
$loExibirConsulta = null;

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

<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
    <thead>
        <tr>
            <th ></th>
            <th width="50%">Nome </th>
            <th width="30%">Cpf </th> 
            <th width="15%">A&ccedil;&atilde;o  </th> 

        </tr>
    </thead>
    <tbody  >


       <?php
        $loDadosC = array( 
                'tipo_pessoa' => '4,5,6'
                , 'id' => '' 
                , 'nome' => $loNome
                , 'cpf' => $loCpf 
            );

            $loLista =  $loPessoa->ListaPessoa($loDadosC);

            if(count($loLista) > 0 && $loExibirConsulta == 1){

                foreach ($loLista as $row){

                    $loIndGravaGridPassageiros = 0;
                    if($row["ind_passageiro"] == 1 || $row["ind_condutor"] == 1){
                        //Verifica se pe passageiro ou condutor para gravar na gride de passageiro
                        $loIndGravaGridPassageiros = 1;
                    }
                    
         ?>

                <tr class="odd gradeX"  >

                    <td>  </td>   
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td> <?php echo $row["cpf"]; ?>  </td>
                    <td> 
                         <button 
                            id="btn-adicionar" 
                            onclick="Adicionar('<?php echo $row["nome"]; ?>',<?php echo $row["id_pessoa"];?>, <?php echo $loIndGravaGridPassageiros; ?>);" 
                            class="btn sbold dark"> 
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
                , url: "pesquisa-requisitante-ajax.php"
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


function Adicionar(nome,id,indGravaGridePassageiro){

    jQuery('#dialog-message').dialog('close');
    $("#nome-requisitante").val(nome);
    $("#codigo-requisitante").val(id);

    if(indGravaGridePassageiro == 1){


            $("#table-passageiros tbody tr").remove(); 
           
            var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>";
            var newRow = $("<tr>");
            var cols = "";

            cols += "<td>" + nome + "</td>";
            cols += "<td>" + button + " <input type='hidden' class='codigo-passageiros' value='"+id+"' /> </td>";

            newRow.append(cols);
            $("#table-passageiros").append(newRow);


    }

}

</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>