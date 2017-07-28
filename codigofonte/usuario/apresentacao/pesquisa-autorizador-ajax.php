<!DOCTYPE html>
<?php  include("../../comum/comum.php");  ?>
<?php  include("../negocio-usuario.php");  ?>

<?php


$loNomeAutorizador = null;
if(isset($_REQUEST["nomeAutorizador"])){
    $IdMenu = $_REQUEST["nomeAutorizador"];
}


//$loPessoa = new pessoaBO();


?>
    
    <br />
    <h4><i class="fa fa-filter"></i> Localizar Usuarios</h4>
    <br />

    <form class="form-inline" role="form">


            <div class="form-group">
                                                        
            <label class="col-md-3 control-label">Nome</label>
            <div class="col-md-2">
                <input type="text" id="nome-autorizador-pesquisa" name="filtro-nome" class="form-control"  size="30" >
            </div>

            </div>

            <div class="form-group">
            </div>
            <div class="checkbox">
            </div>
            <a href="#" id="pesquisa-autorizador" onClick="PesquisaAutorizador_onClick();" class="btn sbold dark"> Pesquisar
                    <i class="fa fa-search"></i>
            </a>
            
        </form>

        <br />
        <br />

        <?php if(isset($_REQUEST["nomeAutorizador"])){ ?>

          <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
                <tr>
                    <th width="10%">
                        <input type="checkbox" class="group-checkable"  data-set="#sample_1 .checkboxes" onclick='Marcardesmarcar_onClick();' /> 
                    </th>
                    <th width="60%"> Nome </th>
                    <th width="30%"> Login </th>
                </tr>
            </thead>

            <tbody id="conteudo" >

            
                
            </tbody>
        </table>
        <button type="button" class="btn dark" id="btn-gravar-autorizador" onClick="AdiconarAutorizador_onClick();" >Adicionar</button>
        <script> Usuario.CarregaDadosAutorizador('<?php echo $_REQUEST["nomeAutorizador"]; ?>'); </script>
        <?php } ?>

                    

<script>

function PesquisaAutorizador_onClick(){

        var nomeAutorizador =  $("#nome-autorizador-pesquisa").val();
        
        
        $.ajax({
                data: {
                    nomeAutorizador: nomeAutorizador
                }
                , type: "POST"
                , url: "pesquisa-autorizador-ajax.php"
                , success: function (retorno) {

                    $("#tab2").html(retorno);

                }
            });

    };

function Marcardesmarcar_onClick(){

    $('.checkboxes-autorizador').each(
         function(){
           if ($(this).prop( "checked")) 
           $(this).prop("checked", false);
           else $(this).prop("checked", true);               
         }
    );

}

function AdiconarAutorizador_onClick(){

    id_usuario = $("#id_usuario").val();
    camposMarcados = new Array();

    $("input[type=checkbox][name='autorizadores[]']:checked").each(function(){
        camposMarcados.push($(this).val());

    });

    $.ajax({
        data: {
            camposMarcados: camposMarcados,
            id_usuario: id_usuario
        }
        , type: "POST"
        , url: "gravar-usuario-autorizador.ajax.php"
        , success: function (retorno) {

             window.location.href = "adicionar-usuario.php?acao=U&id=" + id_usuario;

        }
    });

}

</script>

