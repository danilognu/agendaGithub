
// Objeto de acesso global
MotoristaPassageiro = {};

(function () {
    var pub = MotoristaPassageiro;

    // Objeto de acesso privado
    var priv = {};

    $(".cadastraUsuario").hide();
    $(".motorista-condutor-div").hide();


    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-motorista-passageiro-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id_pessoa){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-motorista-passageiro.php?acao=U&id=" + id_pessoa + "&id_menu=" + IDMenu;
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

        $("#filtro-codigo-cliente").change(priv.LocalizaCliente_OnChange);
        $("#btn-desativar").click(priv.buttonDesativar_onClick);

        //exportador
        $("#exportar-pdf").click(priv.buttonExportarPdf_onClick);
        $("#exportar-excel").click(priv.buttonExportarExcel_onClick);

        $("#pesquisa-garagem").click(priv.buttonPesquisaGaragem_onClick);
        $("#pesquisa-historico").click(priv.buttonHistoricoGaragem_onClick);
        $("#btn-log-alteracoes").click(priv.buttonLogAlteracoes_onClick);

        $("#cadastra-usuario").click(priv.buttonLiberaCadastroUsuario_onClick);

        //check
        $("#ind-motorista").click(priv.checkIndMotorista_onClick);
        $("#ind-condutor").click(priv.checkIndCondutor_onClick);


    });

    priv.checkIndMotorista_onClick = function (){

        if($("#ind-motorista").is(":checked")){ loInd = 1;}else{ loInd = 0}

        if(loInd == 1){
             $(".motorista-condutor-div").show();
        }else{
             $(".motorista-condutor-div").hide();
        }
    }    
    priv.checkIndCondutor_onClick = function (){

        if($("#ind-condutor").is(":checked")){ loInd = 1;}else{ loInd = 0}

        if(loInd == 1){
             $(".motorista-condutor-div").show();
        }else{
             $(".motorista-condutor-div").hide();
        }
    }

    priv.buttonLiberaCadastroUsuario_onClick = function (){

        var email = $("#email").val();
        var login = $("#login").val();
        if(login == ""){
            $("#login").val(email);
        }

        $(".cadastraUsuario").show();
    };
    
    priv.buttonLogAlteracoes_onClick = function (){


                $loId = $("#id").val();
                 $.ajax({
                        data: {
                            id:  $loId
                            ,exibirConsulta: 0
                        }
                        , type: "POST"
                        , url: "pesquisa-log-alteracao-ajax.php"
                        , success: function (retorno) {

                               $("#dialog-modal").html(retorno);
                               var optionsPadraoVisualizar = {
                                    autoOpen: false
                                    , modal: true
                                };
                                
                                $("#dialog-modal").dialog($.extend({
                                    title: "LOGS"
                                    , width: "60%"
                                    , height: 400
                                }, optionsPadraoVisualizar));
                                $('#dialog-modal').dialog("open");                            

                        }
                    });

          };

          priv.buttonPesquisaGaragem_onClick = function (){
           
            var loAcao = $("#acao").val();
            $.ajax({
                        data: {
                            dados: ""
                            ,exibirConsulta: 0
                            ,acao: loAcao
                        }
                        , type: "POST"
                        , url: "pesquisa-garagem-ajax.php"
                        , success: function (retorno) {

                               $("#dialog-modal").html(retorno);
                               var optionsPadraoVisualizar = {
                                    autoOpen: false
                                    , modal: true
                                };
                                
                                $("#dialog-modal").dialog($.extend({
                                    title: "Pesquisa Garagem"
                                    , width: "80%"
                                    , height: 400
                                }, optionsPadraoVisualizar));
                                $('#dialog-modal').dialog("open");                            

                        }
                });


         };
 

       priv.buttonHistoricoGaragem_onClick = function (){
           
            $loId = $("#id").val();
            $.ajax({
                        data: {
                            id:  $loId
                            ,exibirConsulta: 0
                        }
                        , type: "POST"
                        , url: "pesquisa-historico-motorista-passageiro-ajax.php"
                        , success: function (retorno) {

                               $("#dialog-modal").html(retorno);
                               var optionsPadraoVisualizar = {
                                    autoOpen: false
                                    , modal: true
                                };
                                
                                $("#dialog-modal").dialog($.extend({
                                    title: "Historico Garagens"
                                    , width: "80%"
                                    , height: 400
                                }, optionsPadraoVisualizar));
                                $('#dialog-modal').dialog("open");                            

                        }
                });


         };

        priv.buttonExportarPdf_onClick = function (){

            $("#form-filtro").attr('action', 'exportador-pdf-pessoa.php');
            $("#form-filtro").attr('target', '_self').submit();
            //$("#form-filtro").submit();
        };

        priv.buttonDesativar_onClick = function (){
            arrayObjetos = new Array();
             
             $('.checked').each(
                function(){
                    if(!isNaN($(this).find('[name="checkboxes-motorista"]').val())){
                        arrayObjetos.push($(this).find('[name="checkboxes-motorista"]').val());
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

                    //var loDados = jQuery.parseJSON( '{ "arrayObjetos": "'+arrayObjetos+'" }' );

                    $.ajax({
                        data: {
                            dados: arrayObjetos
                        }
                        , type: "POST"
                        , url: "desativa-motorista-passageiro-ajax.php"
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
                , url: "alteracao-consulta-cliente-ajax.php"
                , success: function (retorno) {

                    window.location.reload();

                }
            });

        }else{
            alert("Favor Selecionar um Item pelo menos!");
        }


    };
    

    priv.buttonExportadorExcel_onClick = function (){
        $('#form-filtro').attr('action', 'exportador-excel-pessoa.php');
        $("#form-filtro").submit();
    }
    priv.buttonExportarExcel_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-excel-pessoa.php');
            $("#form-filtro").attr('target', '_self').submit();
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
                , url: "busca-dados-cliente-ajax.php"
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

        var nome = $("#filtro-nome").val();
        var cpf = $("#filtro-cpf").val();
        var status = $("#filtro-status").val();
        var IDMenu = $("#id-menu").val();

        if($("#ind-passageiro").is(":checked")){ loIndPassageiro = 1;}else{ loIndPassageiro = 0}
        if($("#ind-motorista").is(":checked")){ loIndMotorista = 1;}else{ loIndMotorista = 0}
        if($("#ind-condutor").is(":checked")){ loIndCondutor = 1;}else{ loIndCondutor = 0}

        if(nome == "" && cpf == "" && status == "" && loIndPassageiro == 0 && loIndMotorista == 0){

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
                window.location.href = "consulta-motorista-passageiro.php?id_menu="+IDMenu+"&nome="+nome+"&cpf="+cpf+"&status="+status+"&ind_passageiro="+loIndPassageiro+"&ind_motorista="+loIndMotorista+"&ind_condutor="+loIndCondutor;
            }


        /*$.ajax({
                data: {
                    nome: nome
                    ,cpf: cpf
                    ,status: status
                    ,ind_passageiro: loIndPassageiro
                    ,ind_motorista: loIndMotorista
                }
                , type: "POST"
                , url: "consulta-motorista-passageiro-ajax.php"
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
                , url: "consulta-motorista-passageiro-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-motorista-passageiro.php?acao=I&id_menu="+ IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-motorista-passageiro.php?id_menu="+ IDMenu;
    };

    priv.buttonGravarDados_onClick = function () {


        var loNome = $("#nome").val();
        var loCpf = $("#cpf").val();
        var loCep = $("#cep").val();
        var loEndereco = $("#endereco").val();
        var loBairro = $("#bairro").val();
        var loNumero = $("#numero").val();
        var loEstado = $("#estado").val();
        var loCidade = $("#cidade").val();
        var loComplemento = $("#complemento").val();
        var loTelefone =  $("#telefone").val();
        var loCelular =  $("#celular").val();
        var loEmail =  $("#email").val();
        var loStatus =  $("#status").val();
        var loNumHabilitacao = $("#num-habilitacao").val();
        var loOrgaoHabilitacao = $("#orgao-habilitacao").val();
        var loDataValidadeHabilitacao = $("#data-validade-habilitacao").val();
        var loCategoriaHabilitacao = $("#categoria-habilitacao").val();
        var loIdSetor = $("#setor").val();
        var loRegistro = $("#registro").val();

        
        var loCodigoGaragem = $("#garagem-codigo").val();
        var loMotivoTrocaGaragem = $("#motivo-troca-garagem").val();

        //login/usuario
        var loLogin = $("#login").val();
        var loSenha = $("#senha").val();
        var loConfiSenha = $("#confi-senha").val();

        var loAcao = $("#acao").val();
        var loID = $("#id").val();
        var loIDPessoaUsuario = $("#id-pessoa-usuario").val();

        if($("#ind-passageiro").is(":checked")){ loIndPassageiro = 1;}else{ loIndPassageiro = 0}
        if($("#ind-motorista").is(":checked")){ loIndMotorista = 1;}else{ loIndMotorista = 0}
        if($("#ind-condutor").is(":checked")){ loIndCondutor = 1;}else{ loIndCondutor = 0}

        if($("#cadastra-usuario").is(":checked")){ loCadastraUsuario = 1;}else{ loCadastraUsuario = 0}

        var loDadosJ = jQuery.parseJSON( '{ "nome": "'+loNome+'", "cpf": "'+loCpf+'", "cep": "'+loCep+'", "endereco": "'+loEndereco+'", "bairro": "'+loBairro+'", "numero": "'+loNumero+'", "id_estado": "'+loEstado+'", "id_cidade": "'+loCidade+'", "complemento": "'+loComplemento+'", "telefone": "'+loTelefone+'", "celular": "'+loCelular+'", "email": "'+loEmail+'", "status": "'+loStatus+'", "acao": "'+loAcao+'", "id": "'+loID+'", "num_habilitacao": "'+loNumHabilitacao+'", "orgao_habilitacao": "'+loOrgaoHabilitacao+'", "data_validade_habilitacao": "'+loDataValidadeHabilitacao+'", "categoria_habilitacao": "'+loCategoriaHabilitacao+'", "ind_passageiro": "'+loIndPassageiro+'", "ind_motorista": "'+loIndMotorista+'", "ind_condutor": "'+loIndCondutor+'", "id_setor": "'+loIdSetor+'", "id_localidade_garagem": "'+loCodigoGaragem+'", "motivo_garagem": "'+loMotivoTrocaGaragem+'", "login": "'+loLogin+'", "senha": "'+loSenha+'", "confi_senha": "'+loConfiSenha+'", "confirma_cadastro_usuario": "'+loCadastraUsuario+'", "id_pessoa_usuario": "'+loIDPessoaUsuario+'", "registro": "'+loRegistro+'"  }' );

        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-motorista-passageiro.ajax.php"
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
                   window.location.href = "../../pessoa/apresentacao/consulta-motorista-passageiro.php?id_menu="+IDMenu;
               }

            }
        });



    };

 
 
})();


