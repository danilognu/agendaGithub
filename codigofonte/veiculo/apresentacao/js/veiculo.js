
// Objeto de acesso global
Veiculo = {};

(function () {
    var pub = Veiculo;

    // Objeto de acesso privado
    var priv = {};

    $(".div-motivo-desativacao").hide();


    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-veiculo-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-veiculo.php?acao=U&id=" + id + "&id_menu=" + IDMenu;
    };
    //funções pub end

      jQuery(function ($) {
        var optionsPadrao = {
            autoOpen: false
            , modal: true
        };


        //Consulta
        $("#btn-adicionar").click(priv.buttonAdicionar_onClick);

        //Form Cad / Add
        $("#pesquisa").click(priv.buttonPesquisa_onClick);
        $("#btn-cancelar-form").click(priv.buttonCancelar_onClick);
        $("#btn-gravar-dados").click(priv.buttonGravarDados_onClick);
        $("#btn-modifica-consulta").click(priv.buttonModificaConsulta_onClick);
        $("#btn-desativar").click(priv.buttonDesativar_onClick);

        //on
        $("#status").change(priv.buttonVerificaStatus_onClick);

        //exportador
        $("#exportar-pdf").click(priv.buttonExportarPdf_onClick);
        $("#exportar-excel").click(priv.buttonExportarExcel_onClick);

    });

    priv.buttonVerificaStatus_onClick = function (){

        if($("#status").val() == 0){
             $(".div-motivo-desativacao").show();
        }

    }; 

    priv.buttonExportarPdf_onClick = function (){
        $("#form-filtro").attr('action', 'exportador-pdf-veiculo.php');
        $("#form-filtro").attr('target', '_self').submit();
    };
    priv.buttonExportarExcel_onClick = function (){
        $("#form-filtro").attr('action', 'exportador-excel-veiculo.php');
        $("#form-filtro").attr('target', '_self').submit();
    }; 


    priv.buttonDesativar_onClick = function (){
            arrayObjetos = new Array();
             
             $('.checked').each(
                function(){
                    if(!isNaN($(this).find('[name="checkboxes-veiculo"]').val())){
                        arrayObjetos.push($(this).find('[name="checkboxes-veiculo"]').val());
                    }
                }
            );

            if(arrayObjetos.length == 0){
                        
                        bootbox.dialog({
                                    message: "Favor selecionar um item!",
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
                            dados: arrayObjetos
                        }
                        , type: "POST"
                        , url: "desativa-veiculo-ajax.php"
                        , success: function (retorno) {
                            window.location.reload();
                        }
                    });
            }

        };




    priv.buttonModificaConsulta_onClick = function (){
        

        var IDMenu = $("#id-menu").val();
        var StrConsulta = "";

        var aChk = document.getElementsByName("grid-consulta"); 
        for (var i=0;i<aChk.length;i++){ 

            if (aChk[i].checked == true){

                StrConsulta = StrConsulta + aChk[i].value + ",";

            }

        }

        if(StrConsulta != ""){

          var loDados = jQuery.parseJSON( '{ "id_menu": "'+IDMenu+'", "strConsulta": "'+StrConsulta+'"  }' );

          $.ajax({
                data: {
                    Dados: loDados
                }
                , type: "POST"
                , url: "alteracao-consulta-veiculo-ajax.php"
                , success: function (retorno) {

                    window.location.reload();

                }
            });

        }else{
            alert("Favor Selecionar um Item pelo menos!");
        }


    };

    priv.LocalizaCliente_OnChange = function (){
        
        var codigoCliente = $("#filtro-codigo-cliente").val();

        var loDadosJ = jQuery.parseJSON( '{ "tipo_pessoa": "2", "id": "'+codigoCliente+'"  }' );

        $.ajax({
                data: {
                    dados: loDadosJ
                }
                , type: "POST"
                , dataType: "json"
                , url: "busca-dados-veiculo-ajax.php"
                , success: function (retorno) {

                    if(retorno == null){
                        //$("#filtro-codigo-cliente").val("");
                        $("#filtro-nome-cliente").val("");
                    }else{
                        $("#filtro-nome-cliente").val(retorno);
                    }

                }
         });

    }; 

    priv.buttonPesquisa_onClick = function (){

        var chassi = $("#filtro-chassi").val();
        var placa  = $("#filtro-placa").val(); 
        var status  = $("#filtro-status").val(); 
        var IDMenu = $("#id-menu").val();


        if(chassi == "" && placa == "" && status == "" ){

                bootbox.dialog({
                            message: "Por favor, selecione pelo menos um filtro",
                            title: "Aviso",
                            buttons: {
                            success: {
                                label: "OK",
                                className: "dark"
                            }
                            }
                });

        }else{
            window.location.href = "consulta-veiculo.php?id_menu="+IDMenu+"&chassi="+chassi+"&placa="+placa+"&status="+status;
        }        

       /* $.ajax({
                data: {
                    chassi: chassi
                    ,placa: placa
                    ,status: status
                }
                , type: "POST"
                , url: "consulta-veiculo-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });*/
    };

    priv.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-veiculo-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-veiculo.php?acao=I&id_menu="+IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-veiculo.php?id_menu="+IDMenu;
    };

    priv.buttonGravarDados_onClick = function () {


        var loPlaca = $("#placa").val();
        var loModelo =  $("#modelo").val();
        var loCombustivel =  $("#combustivel").val();
        var loCor =  $("#cor").val();
        var loAnoModelo =  $("#ano-modelo").val();
        var loAnoVeiculo =  $("#ano-veiculo").val();
        var loChassi =  $("#chassi").val();
        var loRenavam =  $("#renavam").val();
        var loQtdPassageiro =  $("#qtd-passageiro").val();
        var loPortas =  $("#portas").val();
        var loKm =  $("#km").val();
        var loNivelCombustivel =  $("#nivel_combustivel").val();
        var loDataSubstituidoDev =  $("#data-substituido-dev").val();
        var loGaragem =  $("#garagem").val();;
        var loExclusivo =  $("#exclusivo").val();
        var loStatus =  $("#status").val();
        var loID = $("#id").val();
        var loAcao = $("#acao").val();
        var loSituacao = $("#situacao").val();
        var loMotivoDesativacao = $("#motivo_desativacao").val();

        if($("#exclusivo").is(":checked")){ loExclusivo = 1;}else{ loExclusivo = 0}


        var loID = $("#id").val();
        var loDadosJ = jQuery.parseJSON( '{ "placa": "'+loPlaca+'", "id_modelo": "'+loModelo+'", "id_combustivel": "'+loCombustivel+'", "id_cor": "'+loCor+'", "ano_modelo": "'+loAnoModelo+'", "ano_veiculo": "'+loAnoVeiculo+'", "chassi": "'+loChassi+'", "renavam": "'+loRenavam+'", "qtd_passageiro": "'+loQtdPassageiro+'", "portas": "'+loPortas+'", "km": "'+loKm+'", "id_nivel_combustivel": "'+loNivelCombustivel+'", "data_substituidoDev": "'+loDataSubstituidoDev+'", "id_localidade_garagem": "'+loGaragem+'", "exclusivo": "'+loExclusivo+'", "status": "'+loStatus+'", "acao": "'+loAcao+'", "id": "'+loID+'", "situacao": "'+loSituacao+'", "motivo_desativacao": "'+loMotivoDesativacao+'" }' );

        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-veiculo.ajax.php"
            , success: function (retorno) {

               //alert(retorno.erro + " - " + retorno.messagem);

               if(retorno.erro){


                    bootbox.dialog({
                        message: retorno.messagem,
                        title: "Aviso",
                        buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                        }
                    });

               }else{
                    var IDMenu = $("#id-menu").val();
                    window.location.href = "../../veiculo/apresentacao/consulta-veiculo.php?id_menu="+IDMenu;
               }

            }
        });



    };

 
 
})();


