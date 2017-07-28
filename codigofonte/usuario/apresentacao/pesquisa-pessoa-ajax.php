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
$loTipoAutorizacao = null;

if(isset($_REQUEST["id"])){ $loId = $_REQUEST["id"]; }
if(isset($_REQUEST["cpf"])){ $loCpf = $_REQUEST["cpf"]; }
if(isset($_REQUEST["nome"])){ $loNome = $_REQUEST["nome"]; }
if(isset($_REQUEST["tipoAutorizacao"])){ $loTipoAutorizacao = $_REQUEST["tipoAutorizacao"]; }

if($loTipoAutorizacao == "quem_autorizo"){
    $loTabelaHtml = "table-pessoa-quem-autorizo";
}
if($loTipoAutorizacao == "quem_me_autoriza"){
    $loTabelaHtml = "table-pessoa-que-me-autoriza";
}

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
        <a href="#" onclick="PesquisaPessoa();" class="btn dark"> 
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
            <th width="10%">
                <input type="checkbox" class="group-checkable" onclick="marcardesmarcar();" data-set="#sample_1 .checkboxes" /> 
            </th>
            <th>Nome </th>
            <th>E-mail </th> 
            <th>A&ccedil;&atilde;o</th>

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
            );

            $loLista =  $loPessoa->ListaPessoa($loDadosC);

            if(count($loLista) > 0){

                foreach ($loLista as $row){
                    
         ?>

                <tr class="odd gradeX"  >
                    <td >
                        <input type="checkbox" class="checkboxes" value="<?php echo $row["id_pessoa"].":".$row["nome"]; ?>" name="checkboxes" value="" /> 
                    </td>
                    <td> <?php echo $row["nome"]; ?> </td>
                    <td> <?php echo $row["email"]; ?> </td>
                    <td>  <button id="btn-adicionar" onclick="AdicionarUnico('<?php echo $row["id_pessoa"].":".$row["nome"]; ?>');" class="btn dark"> <i class="fa fa-plus"></i></button> </td>

                </tr>
            <?php

                }
                
            }
       }

            ?>


    </tbody>
</table>



<script>

function PesquisaPessoa(){

        var loNome = $("#filtro-nome").val(); 
        var loCpf = $("#filtro-cpf").val();

        $.ajax({
                data: {
                    nome: loNome
                    ,cpf: loCpf
                    ,exibirConsulta: 1 
                    ,tipoAutorizacao: '<?php echo $loTipoAutorizacao; ?>'
                }
                , type: "POST"
                , url: "pesquisa-pessoa-ajax.php"
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
               var codigoPessoaSelecionados = $(this).val();
                
                
                //BEGIN GRID
                var classPessoaGridCompleto = ".codigo-pessoa-cad-<?php echo $loTipoAutorizacao; ?>";
               $(classPessoaGridCompleto).each(function () { //Verifica todos os passageiros cadastrado na grid
                    
                    var codigoPessoaCadastradoGrid = $(this).val();

                    codigoPessoaSelecionadosTrim = codigoPessoaSelecionados.trim()
                    if(codigoPessoaSelecionadosTrim.indexOf(":") > 0){
                        var codigoCorrenteSplit = codigoPessoaSelecionadosTrim.split(":");
                        codigoCorrente = codigoCorrenteSplit[0];
                    }else{
                        codigoCorrente = codigoPessoaSelecionadosTrim;
                    }

                    if(codigoCorrente == codigoPessoaCadastradoGrid.trim()){
                        validaCampos = true;
                    }

                });
                var classPessoaGridCompleto = ".codigo-pessoa-<?php echo $loTipoAutorizacao; ?>";
               $(classPessoaGridCompleto).each(function () { //Verifica todos os passageiros cadastrado na grid
                    
                    var codigoPessoaCadastradoGrid = $(this).val();

                    codigoPessoaSelecionadosTrim = codigoPessoaSelecionados.trim()
                    if(codigoPessoaSelecionadosTrim.indexOf(":") > 0){
                        var codigoCorrenteSplit = codigoPessoaSelecionadosTrim.split(":");
                        codigoCorrente = codigoCorrenteSplit[0];
                    }else{
                        codigoCorrente = codigoPessoaSelecionadosTrim;
                    }

                    if(codigoCorrente == codigoPessoaCadastradoGrid.trim()){
                        validaCampos = true;
                    }

                });                
                //END GRID

           }              
         }
    );



    if(validaCampos){

        bootbox.dialog({
            message: "Pessoa selecionado ja esta cadastrado, por favor, selecione outro!",
            title: "Aviso",
            buttons: {
                success: {
                    label: "OK",
                    className: "dark"
                }
            }
        });                                   

    }else{



        for (var i = 0; i < camposMarcados.length; i++) {
            
            var camposMarcadosSplit = camposMarcados[i].split(":");
            var codigo = camposMarcadosSplit[0]; 
            var nome = camposMarcadosSplit[1];

            var cols = ""; 
            cols += "<td>" + codigo + "</td>";
            cols += "<td>" + nome + "</td>";
            cols += "<td><a href='javascript;' id='' class='btn btn-default'><i class='fa fa-close'></i></a> <input type='hidden' class='codigo-pessoa-<?php echo $loTipoAutorizacao; ?>' value='"+codigo+"' /> </td>";
            
            var newRow = $("<tr>");
            newRow.append(cols);
            $(<?php echo "'#".$loTabelaHtml."'"; ?>).append(newRow);

        }
        jQuery('#dialog-message').dialog('close');


    }

    
}

function AdicionarUnico(Item){

                validaCampos = false;
                camposMarcados = new Array();

               camposMarcados.push(Item); // cria array
               var codigoPessoaSelecionados = Item;
                
                
                //BEGIN GRID
                var classPessoaGridCompleto = ".codigo-pessoa-cad-<?php echo $loTipoAutorizacao; ?>";
               $(classPessoaGridCompleto).each(function () { //Verifica todos os passageiros cadastrado na grid
                    
                    var codigoPessoaCadastradoGrid = $(this).val();

                    codigoPessoaSelecionadosTrim = codigoPessoaSelecionados.trim()
                    if(codigoPessoaSelecionadosTrim.indexOf(":") > 0){
                        var codigoCorrenteSplit = codigoPessoaSelecionadosTrim.split(":");
                        codigoCorrente = codigoCorrenteSplit[0];
                    }else{
                        codigoCorrente = codigoPessoaSelecionadosTrim;
                    }

                    if(codigoCorrente == codigoPessoaCadastradoGrid.trim()){
                        validaCampos = true;
                    }

                });
                var classPessoaGridCompleto = ".codigo-pessoa-<?php echo $loTipoAutorizacao; ?>";
               $(classPessoaGridCompleto).each(function () { //Verifica todos os passageiros cadastrado na grid
                    
                    var codigoPessoaCadastradoGrid = $(this).val();

                    codigoPessoaSelecionadosTrim = codigoPessoaSelecionados.trim()
                    if(codigoPessoaSelecionadosTrim.indexOf(":") > 0){
                        var codigoCorrenteSplit = codigoPessoaSelecionadosTrim.split(":");
                        codigoCorrente = codigoCorrenteSplit[0];
                    }else{
                        codigoCorrente = codigoPessoaSelecionadosTrim;
                    }

                    if(codigoCorrente == codigoPessoaCadastradoGrid.trim()){
                        validaCampos = true;
                    }

                });                
                //END GRID





    if(validaCampos){

        bootbox.dialog({
            message: "Pessoa selecionado ja esta cadastrado, por favor, selecione outro!",
            title: "Aviso",
            buttons: {
                success: {
                    label: "OK",
                    className: "dark"
                }
            }
        });                                   

    }else{



        for (var i = 0; i < camposMarcados.length; i++) {
            
            var camposMarcadosSplit = camposMarcados[i].split(":");
            var codigo = camposMarcadosSplit[0]; 
            var nome = camposMarcadosSplit[1];

            var cols = ""; 
            cols += "<td>" + codigo + "</td>";
            cols += "<td>" + nome + "</td>";
            cols += "<td><a href='javascript;' id='' class='btn btn-default'><i class='fa fa-close'></i></a> <input type='hidden' class='codigo-pessoa-<?php echo $loTipoAutorizacao; ?>' value='"+codigo+"' /> </td>";
            
            var newRow = $("<tr>");
            newRow.append(cols);
            $(<?php echo "'#".$loTabelaHtml."'"; ?>).append(newRow);

        }
        jQuery('#dialog-message').dialog('close');


    }

    
}


</script>
<script src="../../comum/js/form-input-mask.js" type="text/javascript"></script>