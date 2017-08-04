
// Objeto de acesso global
Solicitacao = {};

(function () {
    var pub = Solicitacao;

    // Objeto de acesso privado
    var priv = {};

   //$("#sample_1").DataTable();

  /*  $('#sample_1').Datatable( {
        "order": [[ 3, "desc" ]]
    } );*/


    //Messagem de Aviso de 


    //elementos ocultos
    $(".messagem-valida-placa").hide();

    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-solicitacao-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();

    pub.ListaDadosPessoaSolicitadaCarona = function (id_pessoa){


                $.ajax({
                data: {
                    id_pessoa: id_pessoa
                }
                , type: "POST"
                , url: "pesquisa-pessoa-formulario-ajax.php"
                , success: function (retorno) {


                        $("#dialog-itens").html(retorno);
                        var optionsPadraoVisualizar = {
                            autoOpen: false
                            , modal: true
                            ,buttons: {
                                "Sair": function() {
                                $( this ).dialog( "close" );
                                }
                            }
                        };
                        
                        $("#dialog-itens").dialog($.extend({
                            title: "Pesquisa Pessoa"
                            , width: "65%"
                            , height: 600
                        }, optionsPadraoVisualizar));
                        $("#dialog-itens").dialog("open");  

                }
        });



    };

    pub.Situacao_onClick = function (obj){
        if(obj.value == 4){
            $("#grupo-motivo-cancelamento").css("display","block");
        }else{
            $("#grupo-motivo-cancelamento").css("display","none");
            $('#motivo-cancelamento option[value=""]').attr({ selected : "selected" });
        }

    };

    pub.SituacaoAtendimento_onClick = function (obj){

        $('#situacao option[value="' + $("#situacao-atendimento").val() + '"]').attr({ selected : "selected" });

        if(obj.value == 4){
            $("#grupo-motivo-cancelamento-atendimento").css("display","block");
            $("#grupo-motivo-cancelamento").css("display","block");
        }

    };

    pub.MotivoCancSituacaoAtendimento_onClick = function (obs){
        $('#motivo-cancelamento option[value="' + $("#motivo-cancelamento-atendimento").val() + '"]').attr({ selected : "selected" });
    };

    pub.AbrirItem = function (id){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-solicitacao.php?acao=U&id=" + id + "&id_menu=" + IDMenu;
    };

   pub.AbrirItemMapa = function (id){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-solicitacao.php?acao=U&id=" + id + "&id_menu=" + IDMenu + "&removeTop=S";
    };

    pub.AbrirItemAtendimento = function (id){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-solicitacao.php?acao=U&id=" + id + "&id_menu=" + IDMenu + "&atendimento=1";
    };


    pub.AbaAtendimento = function (){

    };

    pub.RemoverLinha = function (obj){

        var tr = $(obj).closest('tr');

        tr.fadeOut(400, function(){ 
            tr.remove(); 
        });

    };

    pub.RemoverLinhaParadasDinamico = function (obj){

        //console.log( $(obj).closest("codigo-localidade-paradas").val() );
        $(obj).closest('tr').remove();

        var table = $('#table-paradas');

        var contaItens = 0;
        table.find('tr').each(function(){
            
            var contatr = 0;
            $(this).find('td').each(function(){
                if(contatr == 0){
                    $(this).text(contaItens);
                }

                contatr = contatr + 1;
            });

            contaItens = contaItens + 1;
        });

    }

    pub.RemoverLinhaPassageiros = function (obj){

        var tr = $(obj).closest('tr');

        tr.fadeOut(400, function(){ 
            tr.remove(); 
        });

        var QtdPassageiroInput = $(".qtd-passageiro-visual").val();

         $(".qtd-passageiro-visual").val(QtdPassageiroInput-1);
    };

    pub.RemoverLinhaParadas = function (obj,id_destino){



       $.ajax({
                data: {
                    id_destino: id_destino
                }
                , type: "POST"
                , url: "remover-destinos-ajax.php"
                , success: function (retorno) {

                    var tr = $(obj).closest('tr');

                    tr.fadeOut(400, function(){ 
                        tr.remove(); 
                    });

                   var IdSolicitacao = $("#id").val();
                   var IdMenu = $("#id-menu").val();
                   window.location.href = "adicionar-solicitacao.php?acao=U&id="+IdSolicitacao+"&id_menu="+IdMenu+"&passageiro_rota=1";

                }
        });

    };

    /*pub.testeteste = function(){

        var contagem_paradas = 1;
        console.log("entro");
        $('.table-tr-paradas').each(function() {                                
            console.log( $(this).text() );
            //$(this).text("55");
            //contagem_paradas = contagem_paradas + 1;
        }); 

    }*/

    pub.ReplicaIdentificacao = function (){

        var DataSaidaAtendiemnto = $("#dt-saida-atencimento").val();
        var DataRetornoAtendimento = $("#dt-retorno-atencimento").val();

        $("#data-saida").val(DataSaidaAtendiemnto);
        $("#retorno-previsto").val(DataRetornoAtendimento);

    };
    pub.AbaRota = function (){
        $("#informacoes-rota-table").css("display","block");
        $("#div-base-conteudo").addClass("col-md-11");
    };
    pub.AbaRetornaCss = function () {
        $("#div-base-conteudo").removeClass("col-md-11").addClass("col-md-7");
    };
    pub.AbaVerificaRotaCss = function (){
        var tbRotaAtiva = $("#tab6-rota").parent().hasClass("active");        
        if(tbRotaAtiva){  pub.AbaRota(); }
    }
    pub.CheckPlanejado = function (){

        $("#panejado-check-nao").attr('checked', false);
        alert($("#panejado-check-sim").is(":checked"));
        if($("#panejado-check-sim").is(":checked")){ 
           document.getElementById("panejado-check-nao").checked = false;
        }

    };

    pub.EncaminharGestro = function (obj){

        if(obj.value == 2){

                    $.ajax({
                                data: {
                                    dados: ""
                                    ,exibirConsulta: 0 
                                }
                                , type: "POST"
                                , url: "pesquisa-gestor-ajax.php"
                                , success: function (retorno) {

                                    $("#dialog-message").html(retorno);
                                    var optionsPadraoVisualizar = {
                                        autoOpen: false
                                        , modal: true
                                        ,buttons: {
                                            "Sair": function() {
                                            $( this ).dialog( "close" );
                                            }
                                        }
                                    };
                                    
                                    $("#dialog-message").dialog($.extend({
                                        title: "Pesquisa Gestor"
                                        , width: "80%"
                                        , height: 400
                                    }, optionsPadraoVisualizar));
                                    $('#dialog-message').dialog("open");  

                                }
                        }); 
                        
        }else{
            $("#id-gestor").val("");
        }

    };
    pub.ModalPesquisaEncGestor = function (){

        var loNome = $("#filtro-nome").val(); 
        var loCpf = $("#filtro-cpf").val();

        $.ajax({
                data: {
                    nome: loNome
                    ,cpf: loCpf
                    ,exibirConsulta: 1 
                }
                , type: "POST"
                , url: "pesquisa-gestor-ajax.php"
                , success: function (retorno) {

                        //$('#dialog-message').dialog("close");  
                        $("#dialog-message").html(retorno);
                        var optionsPadraoVisualizar = {
                            autoOpen: false
                            , modal: true
                            ,buttons: {
                                "Sair": function() {
                                $( this ).dialog( "close" );
                                }
                            }
                        };
                        
                        $("#dialog-message").dialog($.extend({
                            title: "Pesquisa Gestor"
                            , width: "80%"
                            , height: 400
                        }, optionsPadraoVisualizar));
                        $('#dialog-message').dialog("open");  

                }
        });

    };
    pub.PubGravaDados = function (){
        priv.buttonGravarDados_onClick();
    };
    
    pub.VerificaMotivoNaoPlaRota = function (obj){
        
        if(obj.value == 0){
            $(obj).parent().parent().find("select[name=motivo-nao-plan]").prop( "disabled", false  );
        }

    };
    pub.ExcluirDestino = function (obj){

        var IdDestino =  $(obj).parent().parent().find("input[name=id-destino]").val();

        //bootbox
        bootbox.confirm({
            message: "Deseja realmente apagar o Destino apagar ?",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'N&atilde;o',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                    pub.ApagarDestino(IdDestino);
                }
            }
        });
        //bootbox
    };

    pub.ApagarDestino = function (IdDestino){

        $.ajax({
                data: {
                    id_destino: IdDestino
                }
                , type: "POST"
                , url: "excluir-destino-rota-ajax.php"
                , success: function (retorno) {
                     
                     var IdSolicitacao = $("#id").val();
                     var IdMenu = $("#id-menu").val();
                     window.location.href = "adicionar-solicitacao.php?acao=U&id="+IdSolicitacao+"&id_menu="+IdMenu+"&atendimento=1&atendimento_rota=1";

                }
        });  

    };

    pub.RotaItensDestino = function (obj){

        var IdDestino =  $(obj).parent().parent().find("input[name=id-destino]").val();
        var DataPartida =  $(obj).parent().parent().find("input[name=data-partida]").val();
        var KmPartida = $(obj).parent().parent().find("input[name=km-partida]").val();
        var DataChegada = $(obj).parent().parent().find("input[name=data-chegada]").val();
        var KmChegada = $(obj).parent().parent().find("input[name=km-chegada]").val();
        var IndPlanejado = $(obj).parent().parent().find("select[name=ind-planejado]").val();
        var MotivoNaoPlan = $(obj).parent().parent().find("select[name=motivo-nao-plan]").val();
        var IndRealizado = $(obj).parent().parent().find("select[name=ind-realizado]").val();
        var ObsOutros = "";


        var loDados = jQuery.parseJSON( '{ "id_destino": "'+IdDestino+'", "data_partida": "'+DataPartida+'", "data_chegada": "'+DataChegada+'", "km_partida": "'+KmPartida+'", "km_chegada": "'+KmChegada+'", "ind_planejado": "'+IndPlanejado+'", "id_mot_plan": "'+MotivoNaoPlan+'", "ind_realizado": "'+IndRealizado+'","outros": "'+ObsOutros+'" }' );

         $.ajax({
                data: {
                    dados: loDados
                }
                , type: "POST"
                , dataType: "json"
                , url: "gravar-rota-atendimento-ajax.php"
                ,beforeSend: function(){
                       $(obj).parent().parent().find("button[name='salvar']").html("<img src='../../comum/apresentacao/imagens/ajax-loader_envio.gif'/>");
                 }
                , success: function (retorno) {

                     $(obj).parent().parent().find("button[name='salvar']").html("<i class='fa fa-save'>");

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
                         pub.AtualizaGridRotaDestinos();
                     }

                }
        });
       


    };  

    pub.AtualizaGridRotaDestinos = function (){

        var loIdSolicitacao =  $("#id").val();

        $.ajax({
                data: {
                    id_solicitacao: loIdSolicitacao
                }
                , type: "POST"
                , url: "grid-rota-destinos-ajax.php"
                , success: function (retorno) {
                    $("#conteudo-grid-rota").html(retorno);
                }
        });        
        

    }

    pub.modalObsOutrosRota = function (obj) {

        var IdDestino =  $(obj).parent().parent().find("input[name=id-destino]").val();

        $.ajax({
                data: {
                    id_destino: IdDestino
                }
                , type: "POST"
                , url: "observacao-outros-rota-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Salvar Dados": function() {
                                
                                     var Obs = $("#textareaObsOutros").val();
                                     $.ajax({
                                                data: {
                                                    id_destino: IdDestino
                                                    ,obs: Obs
                                                }
                                                , type: "POST"
                                                , url: "grava-observacao-outros-rota-ajax.php"
                                                , success: function (retorno) {

                                                    $("#dialog-message").dialog( "close" );

                                                }
                                        });

                               
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Outros"
                        , width: "28%"
                        , height: 210
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });


   };
   pub.buttonEnviaDadosCadastroPassageiro_onClick = function () {

        var loNome = $("#nome-passageiro-modal").val();
        var loCpf =  $("#cpf-passageiro-modal").val();
        var loCep = $("#cep-passageiro-modal").val();
        var loEndereco = $("#endereco-passageiro-modal").val();
        var loBairro = $("#bairro-passageiro-modal").val();
        var loNumero = $("#numero-passageiro-modal").val();
        var loTelefone = $("#telefone-passageiro-modal").val();
        var loCelular = $("#celular-passageiro-modal").val();
        var loEmail = $("#email-passageiro-modal").val();
        var loSetor =  $("#setor-passageiro-modal").val();
        var loIdCidade = $("#cidade").val();
        var loAcao  = $("#acao-passageiro-modal").val();

        console.log(loIdCidade);

        var loDados = jQuery.parseJSON( '{ "nome": "'+loNome+'", "cpf": "'+loCpf+'", "cep": "'+loCep+'", "endereco": "'+loEndereco+'", "bairro": "'+loBairro+'", "numero": "'+loNumero+'", "id_cidade": "'+loIdCidade+'", "telefone": "'+loTelefone+'", "celular": "'+loCelular+'", "email": "'+loEmail+'", "id_setor": "'+loSetor+'","acao": "'+loAcao+'","ind_passageiro": "1","tela": "solicitacao","status": "1","complemento": "complemento","id_localidade_garagem": "","num_habilitacao": "","orgao_habilitacao": "","data_validade_habilitacao": "","categoria_habilitacao": "","ind_motorista": "0","ind_condutor": "0"  }' );

        $.ajax({
                        data: {
                             dados: loDados
                        }
                        , type: "POST"
                        , dataType: "json"
                        , url: "gravar-cadastro-passageiro-ajax.php"
                        , success: function (retorno) {

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
                                //console.log(retorno);

                                var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>";
                                var newRow = $("<tr>");
                                var cols = "";

                                cols += "<td>" + retorno.nome + "</td>";
                                cols += "<td>" + button + " <input type='hidden' class='codigo-passageiros' value='"+retorno.id+"' /> </td>";

                                newRow.append(cols);
                                $("#table-passageiros").append(newRow);

                                //Conta passageiros BEGIN ------
                                $(".qtd-passageiro-visual").val($(".codigo-passageiros").length);
                                //Conta Passageiros END   ------

                                $('#dialog-message').dialog("close"); 

                            }
                            
                        }
        });        


   }
    pub.buttonEnviaDadosCadastroLocalidade_onClick = function () {
        

        var loNome         = $("#nome-localidade-modal").val();
        var loCategoria    = $("#categoria-localidade-modal").val();
        var loLongitude    = $("#longitude-localidade-modal").val();
        var loLatitude     = $("#latitude-localidade-modal").val();
        var loCep          = $("#cep-localidade-modal").val();
        var loIdLogradouro = $("#logradouro-localidade-modal").val();
        var loEndereco     = $("#endereco-localidade-modal").val();
        var loBairro       = $("#bairro-localidade-modal").val();
        var loNumero       = $("#numero-localidade-modal").val();
        var loEstado       = $("#estado").val();
        var loCidade       = $("#cidade").val();
        var loTelefone     = $("#telefone-localidade-modal").val();
        var loTelefone2    = $("#telefone2-localidade-modal").val()
        var loGaragem      = $("#garagem-localidade-modal").val();
        var loAcao         = $("#acao-localidade-modal").val();
        var loStatus = 1; 

        var loTipoLocalidade = $("#tipo-localidade-modal").val();

        var loDados = jQuery.parseJSON( '{ "nome": "'+loNome+'", "categoria": "'+loCategoria+'", "id_pessoa_unidade": "", "longitude": "'+loLongitude+'", "latitude": "'+loLatitude+'", "cep": "'+loCep+'", "endereco": "'+loEndereco+'", "bairro": "'+loBairro+'", "numero": "'+loNumero+'", "complemento": "", "id_cidade": "'+loCidade+'", "telefone": "'+loTelefone+'", "telefone2": "'+loTelefone2+'", "garagem": "'+loGaragem+'", "cod_rastreamento": "", "acao": "'+loAcao+'", "status": "'+loStatus+'", "id_tipo_logradouro": "'+loIdLogradouro+'","tela": "solicitacao"  }' );


        $.ajax({
                        data: {
                             dados: loDados
                        }
                        , type: "POST"
                        , dataType: "json"
                        , url: "gravar-cadastro-localidade-ajax.php"
                        , success: function (retorno) {

                            console.log(retorno);

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
                                //console.log(retorno);

                                if(loTipoLocalidade == "origem"){

                                    var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>";
                                    var newRow = $("<tr>");
                                    var cols = "";

                                    cols += "<td>" + retorno.nome + " - " + retorno.cidadeEstado + " </td>";
                                    cols += "<td>" + button + " <input type='hidden' class='codigo-localidade-origem' value='"+retorno.id+"' /> </td>";

                                    newRow.append(cols);
                                    $("#table-origem").append(newRow);
                                    $('#dialog-message').dialog("close"); 

                                }
                                if(loTipoLocalidade == "paradas"){
                                    
                                    var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>";
                                    var newRow = $("<tr>");
                                    var cols = "";

                                    var contaItemAdicionado = $(".codigo-localidade-paradas").length + 1; 

                                    cols += "<td> " + contaItemAdicionado + " </td>";

                                    cols += "<td>" + retorno.nome + " - " + retorno.cidadeEstado + " </td>";
                                    cols += "<td>" + button + " <input type='hidden' class='codigo-localidade-paradas' value='"+retorno.id+"' /> </td>";

                                    newRow.append(cols);
                                    $("#table-paradas").append(newRow);
                                    $('#dialog-message').dialog("close"); 

                                }

                            }
                            
                        }
        });        


   }

   pub.MessagemUsuarioRequeCarona = function () {

        bootbox.confirm({
            message: "Deseja verificar se existe carona disponivel ?",
            buttons: {
                confirm: {
                    label: 'Sim',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'N&atilde;o',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                    window.location.href = "../../carona/apresentacao/consulta-carona.php?id_menu=33";
                }
            }
        });

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
        $("#pesquisa-atendimento").click(priv.buttonPesquisaAtendimentos_onClick);
        $("#pesquisa-mapa").click(priv.buttonPesquisaMapaSolicitacao_onClick);
        $("#pesquisa-mapa-atendimento").click(priv.buttonPesquisaMapaAtendimento_onClick);

        $(".btn-voltar").click(priv.buttonVoltar_onClick);
        $(".btn-gravar-dados").click(priv.buttonGravarDados_onClick);
        $(".btn-aprovar").click(priv.buttonAprovar_onClick);
        
        $(".btn-btn-gestor").click(priv.buttonEncaminharGestor_onClick);

        $(".btn-fechar").click(priv.buttonFechado_onClick);
        $(".btn-cancelar").click(priv.buttonCancelar_onClick);
        $(".btn-agendado").click(priv.buttonAgendado_onClick);
        $(".btn-aguardando-veiculo").click(priv.buttonAguardandoVeiculo_onClick)

        $("#btn-modifica-consulta").click(priv.buttonModificaConsulta_onClick);
        $("#btn-desativar").click(priv.buttonDesativar_onClick);
        
        $("#pesquisa-passageiro").click(priv.buttonPesquisaPassageiro_onClick);
        $("#pesquisa-rota-origem").click(priv.buttonPesquisaRota_onClick);
        $("#pesquisa-rota-paradas").click(priv.buttonPesquisaRota_onClick);
        $("#pesquisa-requisitante").click(priv.buttonPesquisaRequisitante_onClick);

        $("#pesquisa-mapa-origem").click(priv.buttonPesquisaOrigemMapa_onClick);
        $("#pesquisa-mapa-destino").click(priv.buttonPesquisaOrigemMapa_onClick);

        $("#pesquisa-motorista").click(priv.buttonPesquisaMotorista_onClick);
        $("#pesquisa-placa").click(priv.buttonPlaca_onClick);
        $("#modal-cadastro-rapido--passageiro").click(priv.buttonCadastroPassageiroAbrirModal_onClick);
        $("#btn-cadastrar-passageiro-modal").click(priv.buttonEnviaDadosCadastroPassageiro_onClick);
        $("#modal-cadastro-rapido-origem").click(priv.buttonModalCadastraOrigem_onClick);
        $("#modal-cadastro-rapido-paradas").click(priv.buttonModalCadastraParadas_onClick);

        //exportador
        $("#exportar-pdf").click(priv.buttonExportarPdf_onClick);
        $("#exportar-excel").click(priv.buttonExportarExcel_onClick);

        //exportador atendimento
        $("#exportar-pdf-atencimento").click(priv.buttonExportarPdfAtendimento_onClick);
        $("#exportar-excel-atencimento").click(priv.buttonExportarExcelAtendimento_onClick);

        $(".btn-imprimir-autorizacao").click(priv.buttonImprimirAutorizacao_onClick);
        $(".btn-email-autorizacao").click(priv.buttonEmailAutorizacao_onClick);

        //Rota
        $(".btn-salvar-rota").click(priv.buttonGravaRota_onClick);

        //validacoes
        $("#data-saida").blur(priv.inputValidaDataSaida_onChange);
        $("#retorno-previsto").change(priv.inputValidaDataSaidaRetorno_onChange);
        //$("#km-saida").blur(priv.inputValidaKMSaida_onBlur);
        $("#km-retorno").blur(priv.inputValidaKMRetorno_onBlur);
        $("#placa").blur(priv.inputValidaPlaca_onBlur);
        $("#select-motorista").change(priv.selectValidaMotorista_onChange);
        $("#select-veiculo").change(priv.selectValidaPlaca_onChange);
        $("#data-evento").change(priv.inputValidaDataEvento_onChange);
        

        $("#btn-adicionar-item-passageiro").click(priv.buttonAdicionaLinhaPassageiro_onClick);
        $("#btn-adicionar-item-origem").click(priv.buttonAdicionaLinhaOrigem_onClick);
        $("#btn-adicionar-item-paradas").click(priv.buttonAdicionaLinhaParadas_onClick);
        $("#btn-adicionar-item-paradas-rota").click(priv.buttonAdicionaLinhaParadasRotas_onClick);   

        //caronas
        $(".verificar-caronas").click(priv.buttonModalVerificaCaronas);       


    });

    priv.inputValidaDataEvento_onChange = function(){

         //Verifica de data do evento é menor que a atual.
         var data_evento = $("#data-evento").val(); 
          var loDados = jQuery.parseJSON( '{ "dt_evento": "'+data_evento+'"  }' );
         $.ajax({
                    data: {
                        dados: loDados
                    }
                    , type: "POST"
                    , dataType: "json"
                    , url: "valida-data-evento-ajax.php"
                    , success: function (retorno) {

                        if(retorno.dias < 0){

                             $("#data-evento").val(""); 
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

                        }

                    }
            }); 

    }

    priv.buttonAgendado_onClick = function(){
        
        var loCodigoVeiculo = $("#select-veiculo").val();
        var loCodigoMotorista = $("#select-motorista").val();
        
        if(loCodigoVeiculo == ""){

            bootbox.dialog({
                    message: "Favor preencher o ve&iacute;culo.",
                    title: "Aviso",
                    buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                    }
            });    

        }else{
            priv.AtualizaStatusSolicitacao(6); 
        }

    };

    priv.buttonAguardandoVeiculo_onClick = function(){
        priv.AtualizaStatusSolicitacao(7);        
    };

    priv.AtualizaStatusSolicitacao = function(status){
            
            var idSolicitacao = $("#id").val();

            $.ajax({
                    data: {
                        id: idSolicitacao
                        ,status: status
                    }
                    , type: "POST"
                    , url: "atualiza-status-solicitacao-ajax.php"
                    , success: function (retorno) {
                        $('#situacao option[value="'+status+'"]').attr({ selected : "selected" });
                        $('#situacao-atendimento option[value="'+status+'"]').attr({ selected : "selected" });                        
                    }
            }); 

    };


    priv.buttonModalVerificaCaronas = function(){
        
            var idSolicitacao = $(this).val();
            $.ajax({
                    data: {
                        id: idSolicitacao
                        ,exibirConsulta: 1
                    }
                    , type: "POST"
                    , url: "pesquisa-caronas-ajax.php"
                    , success: function (retorno) {

                        $("#dialog-message").html(retorno);
                        var optionsPadraoVisualizar = {
                            autoOpen: false
                            , modal: true
                        };
                        
                        $("#dialog-message").dialog($.extend({
                            title: "Caronas Solicitadas"
                            , width: "80%"
                            , height: 400
                        }, optionsPadraoVisualizar));
                        $('#dialog-message').dialog("open");  

                    }
            });        

    };


    priv.selectValidaPlaca_onChange = function (){
        
        var codigoVeiculo = $(this).val();
        var codigoSolicitacao  = $("#id").val();

        var loDados = jQuery.parseJSON( '{ "id_veiculo": "'+codigoVeiculo+'", "id_solicitacao": "'+codigoSolicitacao+'"  }' );

        $.ajax({
                    data: {
                        dados: loDados
                    }
                    , type: "POST"
                    , dataType: "json"
                    , url: "valida-veiculo-ajax.php"
                    , success: function (retorno) {

                        if(retorno.erro){

                            $(this).val("");
                            $("#select2-select-veiculo-container").attr("title","");
                            $("#select2-select-veiculo-container").text("");

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

                        }
                    }
            });   
    };


    priv.selectValidaMotorista_onChange = function (){
        
        var codigoMotorista = $(this).val();
        $.ajax({
                    data: {
                        id_motorista: codigoMotorista
                    }
                    , type: "POST"
                    , dataType: "json"
                    , url: "valida-motorista-ajax.php"
                    , success: function (retorno) {

                        if(retorno.erro){

                            $(this).val("");
                            $("#select2-select-motorista-container").attr("title","");
                            $("#select2-select-motorista-container").text("");

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
                             if($("#select-motorista").val() != ""){
                                var loContaPassageiroCorrente =  $(".qtd-passageiro-visual").val();
                                loContaPassageiroCorrente = parseInt(loContaPassageiroCorrente) + 1;
                                $(".qtd-passageiro-visual").val(loContaPassageiroCorrente);
                             }
                        }
                    }
            });    
    };


    priv.buttonModalCadastraParadas_onClick = function (){

        $.ajax({
                    data: {
                        tipolocalidade: "paradas"
                    }
                    , type: "POST"
                    , url: "cadastra-localidade-ajax.php"
                    , success: function (retorno) {

                        $("#dialog-message").html(retorno);
                        var optionsPadraoVisualizar = {
                            autoOpen: false
                            , modal: true
                        };
                        
                        $("#dialog-message").dialog($.extend({
                            title: "Cadastra Localidade"
                            , width: "60%"
                            , height: 670
                        }, optionsPadraoVisualizar));
                        $('#dialog-message').dialog("open");  

                    }
            });    

    };

    priv.buttonModalCadastraOrigem_onClick = function () {

        $.ajax({
                    data: {
                        tipolocalidade: "origem"
                    }
                    , type: "POST"
                    , url: "cadastra-localidade-ajax.php"
                    , success: function (retorno) {

                        $("#dialog-message").html(retorno);
                        var optionsPadraoVisualizar = {
                            autoOpen: false
                            , modal: true
                        };
                        
                        $("#dialog-message").dialog($.extend({
                            title: "Cadastra Localidade"
                            , width: "60%"
                            , height: 670
                        }, optionsPadraoVisualizar));
                        $('#dialog-message').dialog("open");  

                    }
            });            

    };

    priv.buttonCadastroPassageiroAbrirModal_onClick = function () {

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "cadastra-passageiro-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Cadastra Novo Passageiro"
                        , width: "60%"
                        , height: 600
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });        

    };

    priv.inputValidaPlaca_onBlur = function (){

        var placa = $("#placa").val();

        $.ajax({
                data: {
                    placa: placa
                }
                , type: "POST"
                , dataType: "json"
                , url: "verifica-placa-ajax.php"
                , success: function (retorno) {
                    
                     if(retorno.contagem == "0"){
                         $(".col-veiculo").addClass("has-error");
                         $(".messagem-valida-placa").html(retorno.messagem);
                         $(".messagem-valida-placa").show();
                         $("#placa").val("");
                         $("#codigo-veiculo").val("");
                     }else{
                         $(".messagem-valida-placa").html();
                         $(".messagem-valida-placa").hide();
                         $(".col-veiculo").removeClass("has-error");
                         $("#codigo-veiculo").val(retorno.id_veiculo);
                     }

                }
        });        

    };

    priv.buttonAdicionaLinhaParadasRotas_onClick = function (){

        var itensParadaRota = $("#select-paradas-rota").val();
        var resCdNome = itensParadaRota.split(":");
        var codigo = resCdNome[0];
        var nome = resCdNome[1];

        var IdSolicitacao = $("#id").val();
        var IdMenu = $("#id-menu").val();

        $.ajax({
                data: {
                    id_solicitacao: IdSolicitacao
                    ,codigoDestino: codigo
                    ,nomeDestino: nome
                }
                , type: "POST"
                , url: "grava-destino-rota-ajax.php"
                , success: function (retorno) {
                     window.location.href = "adicionar-solicitacao.php?acao=U&id="+IdSolicitacao+"&id_menu="+IdMenu+"&atendimento=1&atendimento_rota=1";
                }
        });        

    };

    priv.inputValidaKMRetorno_onBlur = function (){

        var KmRetorno = $("#km-retorno").val();
        var KmSaida = $("#km-saida").val();

        if(KmRetorno < KmSaida && KmRetorno != ""){
            bootbox.dialog({
                    message: "KM de Retorno n&atilde;o pode ser menor que o KM de saida!",
                    title: "Aviso",
                    buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                    }
            });            

            $("#km-retorno").val("");
        }

    };

    priv.inputValidaKMSaida_onBlur = function (){

        var KmRetorno = $("#km-retorno").val();
        var KmSaida = $("#km-saida").val();

        if(KmSaida < KmRetorno  && KmRetorno != "" && KmSaida !== ""){
            bootbox.dialog({
                    message: "KM de saida n&atilde;o pode ser menor que o KM de Retorno!",
                    title: "Aviso",
                    buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                    }
            });            

            $("#km-saida").val("");
        }

    };

     priv.buttonAdicionaLinhaParadas_onClick = function (){
    
        var codigoNomeParadas = $("#select-paradas").val();

        var resCdNomeParadas = codigoNomeParadas.split(":");
        var codigoParada = resCdNomeParadas[0];
        var nomeParada = resCdNomeParadas[1];
        aviso = false;

       //Verifica se foi selecionado algum passageiros
       if(codigoParada.length == 0){
            messagem = "Por favor, selecione um Destino!";
            aviso = true;
        }

       //Verifica se passageiro ja esta cadastrado na grid 
       $('.codigo-localidade-paradas').each(function () {
           
           var codigoCorrenteThis = $(this).val();
           var codigoCorrenteTrim = codigoCorrenteThis.trim();

           if(codigoCorrenteTrim.indexOf(":") > 0){
               var codigoCorrenteSplit = codigoCorrenteTrim.split(":");
               codigoCorrente = codigoCorrenteSplit[0];
           }else{
               codigoCorrente = codigoCorrenteTrim;
           }

           if( (codigoCorrente == codigoParada) || (codigoCorrente == codigoParada+":0") ) {
                messagem = "Destino ja cadastrado!";
                aviso = true;               
           }
       });
      
        if(aviso){

            bootbox.dialog({
                    message: messagem,
                    title: "Aviso",
                    buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                    }
            });

        }else{

                var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinhaParadasDinamico(this);' ><i class='fa fa-close'></i> Remover </a>";
                var newRow = $("<tr>");
                var cols = "";

                var contaItemAdicionado = $(".codigo-localidade-paradas").length + 1; 

                cols += "<td> " + contaItemAdicionado + " </td>";
                cols += "<td>" + nomeParada + "</td>";
                cols += "<td>" + button + " <input type='hidden' class='codigo-localidade-paradas' value='"+codigoParada+"' /> </td>";

                newRow.append(cols);
                $("#table-paradas").append(newRow);

                $("#select2-select-paradas-container").attr("title","");
                $("#select2-select-paradas-container").text("");

        }
        return false;

    }; 

    priv.buttonAdicionaLinhaOrigem_onClick = function (){


        var codigoNomeOrigem = $("#select-origem").val();

        var resCdNomeOrigem = codigoNomeOrigem.split(":");
        var codigoOrigem = resCdNomeOrigem[0];
        var nomeOrigem = resCdNomeOrigem[1];
        var messagem ="";
        var aviso = false;

        //Avisos
        if($(".codigo-localidade-origem").length > 0){
            messagem = "Ja existe uma Origem cadastrada!";
            aviso = true;
        }
        if(codigoOrigem == ""){
            messagem = "Por favor, selecione uma Origem!";
            aviso = true;
        }

       //Valida Aviso
       if(aviso){

            bootbox.dialog({
                    message: messagem,
                    title: "Aviso",
                    buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                    }
            });

        }else{
    


                var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>";
                var newRow = $("<tr>");
                var cols = "";

                cols += "<td>" + nomeOrigem + "</td>";
                cols += "<td>" + button + " <input type='hidden' class='codigo-localidade-origem' value='"+codigoOrigem+"' /> </td>";

                newRow.append(cols);
                $("#table-origem").append(newRow);

                $("#select2-select-origem-container").attr("title","");
                $("#select2-select-origem-container").text("");

                return false;

        }

    };     

    priv.buttonAdicionaLinhaPassageiro_onClick = function (){

       var codigoNomePassageiro = $("#select-passageiros").val();
       
       var resCdNomePassageiro = codigoNomePassageiro.split(":");
       var codigoPassageiro = resCdNomePassageiro[0];
       var nomePassageiro = resCdNomePassageiro[1];
       aviso = false;

       //Verifica se foi selecionado algum passageiros
       if(codigoPassageiro.length == 0){
            messagem = "Por favor, selecione um Passageiro!";
            aviso = true;
        }

       //Verifica se passageiro ja esta cadastrado na grid 
       $('.codigo-passageiros').each(function () {
           
           var codigoCorrente = $(this).val();

           if(codigoCorrente.trim() == codigoPassageiro){
                messagem = "Passageiro ja cadastrado!";
                aviso = true;               
           }
       });

       //Valida Aviso
       if(aviso){

            bootbox.dialog({
                    message: messagem,
                    title: "Aviso",
                    buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                    }
            });

        }else{

            var button = "<a href='#' class='btn-rota' onclick='Solicitacao.RemoverLinha(this);' ><i class='fa fa-close'></i> Remover </a>";
            var newRow = $("<tr>");
            var cols = "";

            cols += "<td>" + nomePassageiro + "</td>";
            cols += "<td>" + button + " <input type='hidden' class='codigo-passageiros' value='"+codigoPassageiro+"' /> </td>";

            newRow.append(cols);
            $("#table-passageiros").append(newRow);

            //Conta passageiros BEGIN ------
            $(".qtd-passageiro-visual").val($(".codigo-passageiros").length);
            //Conta Passageiros END   ------

             $("#select2-select-passageiros-container").attr("title","");
             $("#select2-select-passageiros-container").text("");
        }

        return false;

    }; 

    priv.inputValidaDataSaidaRetorno_onChange = function (){

        var dataSaida = $("#data-saida").val();
        var dataRetornoPrevisto = $("#retorno-previsto").val();

        $.ajax({
                data: {
                    dataRetornoPrevisto: dataRetornoPrevisto
                    ,dataSaida: dataSaida
                }
                , type: "POST"
                , dataType: "json"
                , url: "valida-data-saida-retorno-ajax.php"
                , success: function (retorno) {

                    if(retorno.valida_data == 0){
                        
                          $("#retorno-previsto").val("");  
                          bootbox.dialog({
                                message: retorno.messagem_data,
                                title: "Aviso",
                                buttons: {
                                    success: {
                                        label: "OK",
                                        className: "dark"
                                    }
                                }
                        });

                    }  

                    if(retorno.valida_per_noite == 0){
                        $("#ind-pernoite").parent().addClass("checked");   
                        $("#ind-pernoite").prop("checked", true);  

                        //$("#ind-viagem").parent().addClass("checked");   
                        //$("#ind-viagem").prop("checked", true);  

                        $("#finalidade").focus();             
         
                    }                  

                   if(retorno.valida_per_noite == 1){
                        $("#ind-pernoite").parent().removeClass("checked");   
                        $("#ind-pernoite").prop("checked", false);  

                        //$("#ind-viagem").parent().addClass("checked");   
                        //$("#ind-viagem").prop("checked", true);  

                        $("#finalidade").focus();                       
                    }                  
                     
                }
        });
        

    };

    priv.inputValidaDataSaida_onChange = function (){
        var dataEvento = $("#data-evento").val();
        var dataSaida = $("#data-saida").val();

        
        $.ajax({
                data: {
                    dataEvento: dataEvento
                    ,dataSaida: dataSaida
                }
                , type: "POST"
                , dataType: "json"
                , url: "valida-data-saida-ajax.php"
                , success: function (retorno) {

                    if(retorno.valida == 0){
                        
                          $("#data-saida").val("");
                          $("#data-saida").focus();

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

                    }
                     
                }
        });

    };

 
   priv.buttonGravaRota_onClick = function () { 
       alert($(".rota-itens").parent().attr('name'));
   };
    
   priv.buttonEmailAutorizacao_onClick = function () {
        
       $(".btn-email-autorizacao").html("<img src='../../comum/apresentacao/imagens/ajax-loader_envio.gif'/>");

        var IDSolicitacao = $("#id").val();
        $.ajax({
                data: {
                    id_solicitacao: IDSolicitacao
                    ,tipo_out_envio: "F"
                    ,email_autorizacao: "S"
                }
                , type: "POST"
                , url: "email-autorizacao-motorista-ajax.php"
                , success: function (retorno) {

                     $(".btn-email-autorizacao").html("E-mail enviado");

                }
        });

    };

   priv.buttonImprimirAutorizacao_onClick = function () {
        var IDMenu = $("#id-menu").val();
        var IDSolicitacao = $("#id").val();
        window.location.href = "autorizacao-solicitacao-pdf.php?acao=I&id_menu="+IDMenu+"&id_solicitacao="+IDSolicitacao;
    };
    

 priv.buttonPlaca_onClick = function (){
         
     var loPlaca = $("#placa").val();  
     var loExibirConsulta = 0;

     /*if(loPlaca != ""){
         loExibirConsulta = 1;
     }*/
      
     $.ajax({
                data: {
                    dados: ""
                    ,placa: loPlaca
                    ,exibirConsulta: loExibirConsulta 
                }
                , type: "POST"
                , url: "pesquisa-veiculo-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Sair": function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Pesquisa veiculos"
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });


       /* $( "#dialog-message" ).dialog({
            width: "50%",
            height: 400,
            title: "Pesquisa veiculos",
            modal: true,
            buttons: {
                "Sair": function() {
                $( this ).dialog( "close" );
                }
            }
            });*/

    };

    priv.buttonPesquisaMotorista_onClick = function (){
         
     var loNomeMotorista = $("#nome-motorista").val();  
     var loExibirConsulta = 0;

     /*if(loNomeMotorista != ""){
         loExibirConsulta = 1;
     }*/
      
     $.ajax({
                data: {
                    dados: ""
                    ,nome: loNomeMotorista
                    ,exibirConsulta: loExibirConsulta 
                }
                , type: "POST"
                , url: "pesquisa-motorista-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Sair": function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Pesquisa motorista"
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });


        /*$( "#dialog-message" ).dialog({
            width: "50%",
            height: 400,
            title: "Pesquisa motorista",
            modal: true,
            buttons: {
                "Sair": function() {
                $( this ).dialog( "close" );
                }
            }
            });*/

    };

    priv.buttonPesquisaRequisitante_onClick = function (){
         
        var loNomeRequisitante = $("#nome-requisitante").val();

        if(loNomeRequisitante != ""){
            loExibirConsulta = 1;
        }

        loExibirConsulta = 0; 
        $.ajax({
                data: {
                    dados: ""
                    ,nome: loNomeRequisitante
                    ,exibirConsulta: loExibirConsulta 
                }
                , type: "POST"
                , url: "pesquisa-requisitante-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Sair": function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Pesquisa requisitante"
                        , width: "80%"
                        , height: 400
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");                        

                }
        });


       /* $( "#dialog-message" ).dialog({
            width: "80%",
            height: 400,
            title: "Pesquisa requisitante",
            modal: true,
            buttons: {
                "Sair": function() {
                $( this ).dialog( "close" );
                }
            }
            });*/

    };
    

    priv.buttonPesquisaRota_onClick = function (){

        var classe = $(this).attr("class");
        var str = classe.split(" ");
        var consulta = str[2];

        loExibirConsulta = 0;

        $.ajax({
                data: {
                    consulta: consulta
                    ,exibirConsulta: loExibirConsulta 
                }
                , type: "POST"
                , url: "pesquisa-localidade-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Sair": function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Pesquisa " + consulta
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        }); 

        /* $( "#dialog-message" ).dialog({
            width: "70%",
            height: 400,
            title: "Pesquisa " + consulta,
            modal: true,
            buttons: {
                "Sair": function() {
                $( this ).dialog( "close" );
                }
            }
            });*/
    };


    priv.buttonPesquisaOrigemMapa_onClick = function (){

        var classe = $(this).attr("class");
        var str = classe.split(" ");
        var consulta = str[2];

        loExibirConsulta = 0;

        $.ajax({
                data: {
                    consulta: consulta,
                    exibirConsulta: loExibirConsulta 
                }
                , type: "POST"
                , url: "pesquisa-localidade-mapa-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Sair": function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Pesquisa Origem" 
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        }); 

         /*$( "#dialog-message" ).dialog({
            width: "70%",
            height: 400,
            title: "Pesquisa Origem",
            modal: true,
            buttons: {
                "Sair": function() {
                $( this ).dialog( "close" );
                }
            }
            });*/
    };    

    priv.buttonPesquisaPassageiro_onClick = function (){

        var loNomePassageiroPesq = $("#nome-passageiro-pesq").val();

        
        $.ajax({
                data: {
                    dados: ""
                    ,exibirConsulta: 0 
                }
                , type: "POST"
                , url: "pesquisa-passageiros-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Sair": function() {
                            $( this ).dialog( "close" );
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Pesquisa passageiros" 
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });


        /*$( "#dialog-message" ).dialog({
            width: "50%",
            height: 400,
            title: "Pesquisa passageiros",
            modal: true,
            buttons: {
                "Sair": function() {
                $( this ).dialog( "close" );
                }
            }
            });*/
    };
      
      priv.buttonExportarPdf_onClick = function (){
            $("#tela_solicitacao").val("1");
            $("#form-filtro").attr('action', 'exportador-pdf-solicitacao.php');
            $("#form-filtro").attr('target', '_self').submit();
      };
      priv.buttonExportarExcel_onClick = function (){
            $("#tela_solicitacao").val("1");
            $("#form-filtro").attr('action', 'exportador-excel-solicitacao.php');
            $("#form-filtro").attr('target', '_self').submit();
      };

      priv.buttonExportarPdfAtendimento_onClick = function (){
            $("#tela_atendimento").val("1");
            $("#form-filtro").attr('action', 'exportador-pdf-solicitacao.php');
            $("#form-filtro").attr('target', '_self').submit();
      };
      priv.buttonExportarExcelAtendimento_onClick = function (){
            $("#tela_atendimento").val("1");
            $("#form-filtro").attr('action', 'exportador-excel-solicitacao.php');
            $("#form-filtro").attr('target', '_self').submit();
      };



    
        priv.buttonDesativar_onClick = function (){
            arrayObjetos = new Array();
             
             $('.checked').each(
                function(){
                    if(!isNaN($(this).find('[name="checkboxes-solicitacao"]').val())){
                        arrayObjetos.push($(this).find('[name="checkboxes-localidade"]').val());
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
                        , url: "desativa-solicitacao-ajax.php"
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
                , url: "alteracao-consulta-solicitacao-ajax.php"
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
                , url: "busca-dados-solicitacao-ajax.php"
                , success: function (retorno) {

                    if(retorno == null){
                        $("#filtro-nome-cliente").val("");
                    }else{
                        $("#filtro-nome-cliente").val(retorno);
                    }

                }
         });

    }; 

    /*menino*/
 priv.buttonPesquisaAtendimentos_onClick = function (){


        var codigo = $("#filtro-codigo-localidade").val();
        var situacao = $("#filtro-situacao").val();
        var IDMenu = $("#id-menu").val();

        if($("#requer-carona").is(":checked")){ loIndCarona = 1;}else{ loIndCarona = 0}


        if(codigo == "" && situacao == "" && loIndCarona == 0){

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
            window.location.href = "consulta-atencimentos.php?id_menu="+IDMenu+"&id="+codigo+"&situacao="+situacao+"&not_limit=0&ind_carona="+loIndCarona;
        }
    };



    priv.buttonPesquisa_onClick = function (){


        var codigo = $("#filtro-codigo-localidade").val();
        var situacao = $("#filtro-situacao").val();
        var IDMenu = $("#id-menu").val();


        if(codigo == "" && situacao == ""){

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
            window.location.href = "consulta-solicitacao.php?id_menu="+IDMenu+"&id="+codigo+"&situacao="+situacao+"&not_limit=0&ind_carona=0";
        }

       /*$.ajax({
                data: {
                    id: codigo
                    ,status: status
                    ,not_limit: 0
                    ,id_menu: IDMenu
                    ,situacao: situacao
                }
                , type: "POST"
                , url: "consulta-solicitacao-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
         });*/
    };


    priv.buttonPesquisaMapaSolicitacao_onClick = function (){


        var loOrdenar = $("#filtro-ordenar").val();
        var loIdMenu = $("#id-menu").val();
        var loSituacao  = $("#filtro-situacao").val();
        var loDtEventoIni = $("#filtro-data-inicio").val();
        var loDtEventoFim = $("#filtro-data-fim").val();
        var loCodigoOrigem = $("#codigo-origem").val();
        var loCodigoDestino = $("#codigo-destino").val();
        var loPlaca = $("#filtro-placa").val();
        var loMotorista = $("#filtro-select-motorista").val();


        $.ajax({
                data: {
                    ordenar: loOrdenar
                    ,situacao: loSituacao
                    ,dt_evento_ini: loDtEventoIni
                    ,dt_evento_fim: loDtEventoFim
                    ,codigo_origem: loCodigoOrigem
                    ,codigo_destino: loCodigoDestino
                    ,not_limit: 0
                    ,id_menu: loIdMenu
                    ,placa: loPlaca
                    ,id_motorista: loMotorista
                }
                , type: "POST"
                , url: "consulta-mapa-solicitacao-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });
    };    



    priv.buttonPesquisaMapaAtendimento_onClick = function (){


        var loOrdenar = $("#filtro-ordenar").val();
        var loIdMenu = $("#id-menu").val();
        var loSituacao  = $("#filtro-situacao").val();
        var loDtEventoIni = $("#filtro-data-inicio").val();
        var loDtEventoFim = $("#filtro-data-fim").val();
        var loCodigoOrigem = $("#codigo-origem").val();
        var loCodigoDestino = $("#codigo-destino").val();
        var loPlaca = $("#filtro-placa").val();
        var loMotorista = $("#filtro-select-motorista").val();
        

        $.ajax({
                data: {
                    ordenar: loOrdenar
                    ,situacao: loSituacao
                    ,dt_evento_ini: loDtEventoIni
                    ,dt_evento_fim: loDtEventoFim
                    ,codigo_origem: loCodigoOrigem
                    ,codigo_destino: loCodigoDestino
                    ,not_limit: 0
                    ,id_menu: loIdMenu
                    ,placa: loPlaca
                    ,id_motorista: loMotorista
                }
                , type: "POST"
                , url: "consulta-mapa-atendimento-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });
    };    

    priv.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-solicitacao-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-solicitacao.php?acao=I&id_menu="+IDMenu;
    };

   priv.buttonVoltar_onClick = function () {
       var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-solicitacao.php?id_menu="+IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
       
       var loIdSolicitacao = $("#id").val();
       var IDMenu = $("#id-menu").val();

        $.ajax({
                data: {
                    id_solicitacao: loIdSolicitacao
                }
                , type: "POST"
                , url: "motivo-cancelamento-ajax.php"
                , success: function (retorno) {

                    $("#dialog-message").html(retorno);
                    var optionsPadraoVisualizar = {
                        autoOpen: false
                        , modal: true
                        ,buttons: {
                            "Cancelar Solicitacao": function() {
                                
                                     var loIdMotivoCandelmaneto = $("#motivo-cancelamento-modal").val();
                                     if(loIdMotivoCandelmaneto == ""){
                                         alert("Por favor, selecione um motivo.");
                                     }else{
                                            $.ajax({
                                                    data: {
                                                        id_solicitacao: loIdSolicitacao
                                                        ,id_motivo_cancelamento: loIdMotivoCandelmaneto
                                                    }
                                                    , type: "POST"
                                                    , url: "grava-motivo-cancelamento-ajax.php"
                                                    , success: function (retorno) {

                                                        if(retorno){window.location.href = "consulta-solicitacao.php?id_menu="+IDMenu;}

                                                    }
                                        });
                                     }

                               
                            }
                        }
                    };
                    
                    $("#dialog-message").dialog($.extend({
                        title: "Motivo do Cancelamento"
                        , width: "28%"
                        , height: 180
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });



    };

    priv.buttonAprovar_onClick = function () {

        $('#situacao option[value="3"]').attr({ selected : "selected" });
        $("#ativa-aprovar").val("1");
         var IdSolicitacao = $("#id").val();

            $.ajax({
                data: {
                    id_solicitacao: IdSolicitacao
                }
                , type: "POST"
                , dataType: "json"
                , url: "encaminhar-email-aprovacao-ajax.php"
                , success: function (retorno) {

                    if(retorno.erro){
                        
                        bootbox.dialog({
                            message: retorno.mensagem,
                            title: "Aviso",
                            buttons: {
                            success: {
                                label: "OK",
                                className: "dark"
                            }
                            }
                        });

                    }else{
                        priv.buttonGravarDados_onClick();
                    }

                }
            });

        

    };

    priv.buttonEncaminharGestor_onClick = function () {
        
        //priv.PesquisarGestor(); //Antigo
        var IdSolicitacao = $("#id").val();
        var loAcao = $("#acao").val();

        if(loAcao == "I"){
                    bootbox.dialog({
                            message: "Por favor, salve a solicita&ccedil;&atilde;o antes de encaminhar ao gestor.",
                            title: "Aviso",
                            buttons: {
                            success: {
                                label: "OK",
                                className: "dark"
                            }
                            }
                        });
        }else{

            $('#situacao option[value="2"]').attr({ selected : "selected" });

            $.ajax({
                data: {
                    id_solicitacao: IdSolicitacao
                }
                , type: "POST"
                , dataType: "json"
                , url: "encaminhar-gestor-ajax.php"
                , success: function (retorno) {

                    if(retorno.autorizador == 0){
                        $('#situacao option[value="3"]').attr({ selected : "selected" });
                        priv.buttonGravarDados_onClick();
                    }else{
                        $(".btn-gestor").text("E-mail Enviado");
                        $("#ind-solicitacao-envida-gestor").val("1");
                        $('#situacao option[value="2"]').attr({ selected : "selected" });
                        priv.buttonGravarDados_onClick();
                    }

                }
            });

        }

    };

    priv.buttonFechado_onClick = function () {

        $('#situacao option[value="5"]').attr({ selected : "selected" });
        $('#situacao-atendimento option[value="5"]').attr({ selected : "selected" });
        var IdSolicitacao = $("#id").val();       
        var DataSaidaAtendiemnto = $("#dt-saida-atencimento").val();
        var DataRetornoAtendimento = $("#dt-retorno-atencimento").val();
        var KmSaida = $("#km-saida").val();
        var KMRetorno =  $("#km-retorno").val();
        var loValidacao = true;
        var loMessagem = "";
        var IDMenu = $("#id-menu").val();

        if(DataSaidaAtendiemnto == ""){
            loValidacao = false;
            loMessagem = "Favor Preencher a Data Saida!";
        }else       if(DataRetornoAtendimento == ""){
            loValidacao = false;
            loMessagem = "Favor Preencher a Data Retorno Previsto!";
        }
        if(KmSaida == "" || KmSaida == "0" ){
            loValidacao = false;
            loMessagem = "Favor Preencher a Hodometro Saida!";
        }
        if(KMRetorno == "" || KMRetorno == "0"){
            loValidacao = false;
            loMessagem = "Favor Preencher a Hodometro Retorno!";
        }

        if(loValidacao){

                $.ajax({
                    data: {
                        id_solicitacao: IdSolicitacao
                    }
                    , type: "POST"
                    , url: "fechar-atendimento-ajax.php"
                    , success: function (retorno) {

                        window.location.href = "adicionar-solicitacao.php?acao=U&id=" + IdSolicitacao+ "&id_menu=" + IDMenu + "&atendimento=1";

                        /*bootbox.dialog({
                            message: "Solicita&ccedil;&atilde;o Fechada",
                            title: "Aviso",
                            buttons: {
                                success: {
                                    label: "OK",
                                    className: "dark"
                                }
                            },
                            callback: function (result) {
                                alert(result);
                                    if(result){
                                        
                                    }
                            }
                        });*/
                    }
                });

        }else{

            bootbox.dialog({
                message: loMessagem,
                title: "Aviso",
                buttons: {
                success: {
                    label: "OK",
                    className: "dark"
                }
                }
            });

        }
        
    };

    priv.buttonGravarDados_onClick = function () {

        priv.inputValidaDataSaidaRetorno_onChange();

        codigosPassageiros = new Array();
        $('.codigo-passageiros').each(
                function(){           
                 codigosPassageiros.push($(this).val());
                }
        );

        codigosOrigens = new Array();
        $('.codigo-localidade-origem').each(
                function(){        
                 codigosOrigens.push($(this).val());
                }
        );

        codigosParadas = new Array();
        $('.codigo-localidade-paradas').each(
                function(){        
                 codigosParadas.push($(this).val());
                }
        );

        codigosDestinoParadas = new Array();
        $('.codigo-destino-paradas').each(
                function(){        
                 codigosDestinoParadas.push($(this).val());
                }
        );


        if($("#ind-viagem").is(":checked")){ loindViagem = 1;}else{ loindViagem = 0}
        if($("#ind-com-motorista").is(":checked")){ loindComMotorista = 1;}else{ loindComMotorista = 0}
        if($("#ind-pernoite").is(":checked")){ loIndPernoite = 1;}else{ loIndPernoite = 0}


        var loDataEvento = $("#data-evento").val();
        var loCdRequisitante = $("#codigo-requisitante").val(); 
        var loSetor = $("#setor").val(); 
        var loProjetos = $("#projeto").val(); 
        var loCentroDeCusto = $("#centro-de-custo").val();
        var loFinalidade = $("#finalidade").val(); 
        var loDataSaida = $("#data-saida").val(); 
        var loDataRetorno = $("#retorno-previsto").val(); 
        var loMotivoCancelamento = $("#motivo-cancelamento").val();
        var loAcao = $("#acao").val();
        var loID = $("#id").val();   
        var loSituacao = $("#situacao").val();
        var loCodigoVeiculo = $("#select-veiculo").val();
        var loCodigoMotorista = $("#select-motorista").val();
        var loIdCnpjFaturamento = $("#cnpj-faturamento").val();

        var loKmSaida = $("#km-saida").val();
        var loKmRetorno = $("#km-retorno").val();  
        var loIdGestor = $("#id-gestor").val(); 

        //Rota
        var loDataPartida = "";//$("#data-partida").val();
        var loDataChegada = "";//$("#data-chegada").val();
        var loKmPartida = "";//$("#km-partida").val();
        var loKmChegada = "";//$("#km-chegada").val();
        var loIndPlanejado = "";//$("#ind-planejado").val();
        var loMotivoNaoPlan = "";//$("#motivo-nao-plan").val(); // 
        var loIndRealizado = "";//$("#ind-realizado").val();//
        var loObsRealizado = "";//$("#obs-realizado").val();       


        var loSituacaoAtendimento = $("#situacao-atendimento").val();
        var loMotivoCancelamentoAtendimento = $("#motivo-cancelamento-atendimento").val();  
        var loIndEnviadoAoGestor = $("#ind-solicitacao-envida-gestor").val();  


        var loDadosJ = jQuery.parseJSON( '{ "dt_evento": "'+loDataEvento+'", "id_setor": "'+loSetor+'", "id_projeto": "'+loProjetos+'", "finalidade": "'+loFinalidade+'", "ind_viagem": "'+loindViagem+'", "ind_com_motorista": "'+loindComMotorista+'", "ind_pernoite": "'+loIndPernoite+'", "dt_saida": "'+loDataSaida+'", "dt_retorno_prev": "'+loDataRetorno+'", "id_status_solicitacao": "'+loSituacao+'", "codigoRequisitante": "'+loCdRequisitante+'", "acao": "'+loAcao+'", "id": "'+loID+'", "id_motivo_cancelamento": "'+loMotivoCancelamento+'", "id_pessoa_gestor": "'+loIdGestor+'", "id_centro_custo": "'+loCentroDeCusto+'", "id_encaminhado_gestor": "'+loIndEnviadoAoGestor+'", "id_cnpj_faturamento": "'+loIdCnpjFaturamento+'"  }' );

        var loDadosAtencimento = jQuery.parseJSON( '{ "id_veiculo": "'+loCodigoVeiculo+'", "id_pessoa_motorista": "'+loCodigoMotorista+'", "km_saida": "'+loKmSaida+'", "km_retorno": "'+loKmRetorno+'", "dt_partida": "'+loDataPartida+'", "dt_chegada": "'+loDataChegada+'", "km_partida": "'+loKmPartida+'", "km_chegada": "'+loKmChegada+'", "ind_planejado": "'+loIndPlanejado+'", "obs_realizado": "'+loObsRealizado+'", "id_mot_plan": "'+loMotivoNaoPlan+'", "ind_realizado": "'+loIndRealizado+'", "id_status_solicitacao_atend": "'+loSituacaoAtendimento+'", "id_motivo_cancelamento_atend": "'+loMotivoCancelamentoAtendimento+'" }' );

        $.ajax({
            data: {
                dados: loDadosJ
                ,codigosParada: codigosParadas
                ,codigosPassageiro: codigosPassageiros
                ,codigosOrigem: codigosOrigens
                ,dadosAtendimento: loDadosAtencimento
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-solicitacao.ajax.php"
            , success: function (retorno) {

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

                   
                   if(loSituacao == 1){

                                if(loAcao == "I"){
                                    loRtIdSolicitacao = retorno.id_solicitacao
                                }else{
                                    loRtIdSolicitacao = loID
                                }

                                $.ajax({
                                    data: {
                                        id_solicitacao: loRtIdSolicitacao
                                    }
                                    , type: "POST"
                                    , dataType: "json"
                                    , url: "encaminhar-gestor-ajax.php"
                                    , success: function (retorno) {

                                        if(retorno.erro){
                                            
                                            bootbox.dialog({
                                                message: retorno.messagem,
                                                title: "Problema",
                                                buttons: {
                                                success: {
                                                    label: "OK",
                                                    className: "dark"
                                                }
                                                }
                                            });

                                            return;

                                        }

                                    }
                                });

                   }

                   

                   var IDMenu = $("#id-menu").val();
                   var loAtivaAprovar = $("#ativa-aprovar").val();

                   //Verifica Qual o Grupo de acesso que o usuario tem se é gestor ou so usuario
                   var indGrupoAcessoOperador= $("#grupoAcessoOperador").val();

                   if(loAtivaAprovar == 1 && indGrupoAcessoOperador == 1){
                       
                       if(loAcao == "I"){
                           window.location.href = "adicionar-solicitacao.php?acao=U&id=" + retorno.id_solicitacao + "&id_menu=" + IDMenu + "&atendimento=1";
                       }else{
                            window.location.href = "adicionar-solicitacao.php?acao=U&id=" + loID + "&id_menu=" + IDMenu + "&atendimento=1";
                       }

                   }else{

                        var loIndSolicitacaoEnvidaGestor = $("#ind-solicitacao-envida-gestor").val();

                        if(loIndSolicitacaoEnvidaGestor == 0){
                            window.location.href = "../../solicitacao/apresentacao/consulta-solicitacao.php?id_menu="+IDMenu;
                        }
                   }

               }

               

            }
        });



    };

    priv.PesquisarGestor = function () {

                $.ajax({
                                data: {
                                    dados: ""
                                    ,exibirConsulta: 0 
                                }
                                , type: "POST"
                                , url: "pesquisa-gestor-ajax.php"
                                , success: function (retorno) {

                                    $("#dialog-message").html(retorno);
                                    var optionsPadraoVisualizar = {
                                        autoOpen: false
                                        , modal: true
                                        ,buttons: {
                                            "Sair": function() {
                                            $( this ).dialog( "close" );
                                            }
                                        }
                                    };
                                    
                                    $("#dialog-message").dialog($.extend({
                                        title: "Pesquisa Gestor"
                                        , width: "80%"
                                        , height: 500
                                    }, optionsPadraoVisualizar));
                                    $('#dialog-message').dialog("open");  

                                }
                        });         

    };

    

 
 
})();


