
// Objeto de acesso global
UsuarioLogin = {};

(function () {
    var pub = UsuarioLogin;

    // Objeto de acesso privado
    var priv = {};

    pub.VerificaTecla = function (event) {

        if(event.keyCode == 13){ // Se for enter
            priv.buttonVerificarLogin_onClick();
        } 

    };

    jQuery(function ($) {
        var optionsPadrao = {
            autoOpen: false
            , modal: true
        };
        priv.inicializaEventosLinhasDocumentos();
        var optionsPadraoSublistas = $.extend({
            width: 400
            , height: 200
        }, optionsPadrao);

        $("#btn-entrar").click(priv.buttonVerificarLogin_onClick);
        $("#recuperar-senha").click(priv.buttonEsqueciMinhaSenha_onClick);


    });

    priv.buttonEsqueciMinhaSenha_onClick = function () {

        bootbox.prompt("Por Favor, digite seu e-mail", 
            function(result){ 


                $.ajax({
                            data: {
                                email: result
                            }
                            , type: "POST"
                            , dataType: "json"
                            , url: "verifica-email-ajax.php"
                            , success: function (retorno) {
                                
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
                        });

            });
    };

    priv.buttonVerificarLogin_onClick = function () {

        var login = $("#usuario").val();
        var senha = $("#senha").val();

        var query = jQuery.parseJSON( '{ "acao": "login", "login": "'+login+'", "senha": "'+senha+'" }' );


        $.ajax({
            data: {
                query: query
            }
            , type: "POST"
            , dataType: "json"
            , url: "login.ajax.php"
            , success: function (retorno) {

                //alert(JSON.stringify(retorno));

                if(retorno.id_usuario == null)
                {
                    //bootbox.alert("Login ou senha, Incorretos!");    

                    bootbox.dialog({
                        message: retorno.messagem,
                        title: "Acesso",
                        buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                        }
                    });


                }else{

                    if(retorno.id_grupo == 2){
                        window.location.href = "../../solicitacao/apresentacao/consulta-solicitacao.php?id_menu=12";
                    }else{
                        window.location.href = "../../comum/apresentacao/inicio.php";
                    }
                }
               //  -----

            }
        });

    };



    priv.buttnoUploadDocumento_onClick = function () {
       var campo1 = 'A473_link';
       var campo2 = 'A473_nome';

       window.open("../../../../erental/seleciona_documento.asp?pasta=Img&tipo=I&campo=" + campo1 + "&campo2=" + campo2 + "&callbackDepoisUpload=atualizaGrade",'','height=300,width=400,scrollbars=yes');
      
    };

    priv.inputPorChassi_onBlur = function() {
        var chassiCampo =  $("#cadastro-blindagem-chassi").val();
        if(chassiCampo){
            $.ajax({
                url: "carregar-dados-veiculo-por-chassi.ajax.asp",
                dataType: "json",
                data: { chassi: chassiCampo},
                success: function(data, textStatus, jqXHR) {
                    $("#codigoVeiculoHidden").val(data.id);
                    $("#codigoClienteHidden").val(data.codigoCliente);
                    $("#cadastro-blindagem-modelo").text(data.modelo);
                    $("#cadastro-blindagem-cliente").text(data.cliente);
                    $("#cadastro-blindagem-contratoFrota").text(data.contratoFrota);
                    $("#cadastro-blindagem-cidadeEmplacamento").text(data.cidadeUf);
                    $("#cadastro-blindagem-renavam").text(data.renavam);
                    $("#cadastro-blindagem-placa").text(data.placa);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                     alert('Erro');
                }
            })
        } else {
            $("#codigoVeiculoHidden").val("");
            $("#codigoClienteHidden").val("");
            $("#cadastro-blindagem-modelo").text("");
            $("#cadastro-blindagem-cliente").text("");
            $("#cadastro-blindagem-contratoFrota").text("");
            $("#cadastro-blindagem-cidadeEmplacamento").text("");
            $("#cadastro-blindagem-renavam").text("");
            $("#cadastro-blindagem-placa").text("");
        }
    };

    priv.buttonVoltar_onClick = function () {
        window.location = "index.asp";
    };

    priv.inicializaEventosLinhasDocumentos = function () {
        $("table.documentosUpload button.download").click(buttonDownloadDocumento_onClick);
        $("table.documentosUpload button.desvincular").click(buttonDesvincularDocumento_onClick);
    };

    priv.buttonSalvar_onClick = function () {
        $table = $("#tblArquivos");
        $linhaSelecionadas = $("tr.nao-editando", $table)

        var documentosUpload = [];
        $linhaSelecionadas.each(function( i ) {
            documentosUpload.push($(this).metadata().chaveDocumento + "|" +  $(this).metadata().nomeDocumento);
        });

        $.ajax({
            data: {
                codigoBlindagem: $("#codigoBlindagemHidden").val()
                , codigoVeiculo: $("#codigoVeiculoHidden").val()
                , documentos: documentosUpload
                , dataSolAutorizacaoExercito: $("#cadastro-blindagem-dataSolAutExercito").val()
                , dataConclusaoBlindagem: $("#cadastro-blindagem-dataConclusaoBlindagem").val()
                , dataEmissaoExercito: $("#cadastro-blindagem-dataEmissaoExercito").val()
                , dataEnvioExercitoDespachante: $("#cadastro-blindagem-dataEnvioAutExercitoDespachante").val()
                , dataSolInspInmetro: $("#cadastro-blindagem-dataSolInspInmetro").val()
				, dataVistoriaDetran: $("#cadastro-blindagem-dataVistoriaDetran").val()
                , dataEmissaoAutInmetro: $("#cadastro-blindagem-dataEmissaoAutInmetro").val()
                , dataInspecaoInmetro: $("#cadastro-blindagem-dataInspecaoInmetro").val()
                , dataEnvioDespachanteLaudoInmetro: $("#cadastro-blindagem-dataEnvioDespachanteLaudosInmetro").val()
                , dataEnvioClienteCRLV: $("#cadastro-blindagem-dataEnvioClienteCRLV").val()
                , dataRecAutorizacaoVistoria: $("#cadastro-blindagem-dataRecAutVistoria").val()
                , numeroAR: $("div.formulario.cadastro-blindagem div.numerocr select").val()
                , observacao: $("#cadastro-blindagem-observacao").val()
            }
            , type: "POST"
            , url: "salvar.ajax.asp"
            , success: Comum.jqueryAjax_onSuccess(function (data) {
                 window.location = "index.asp";
            })
            , error: Comum.jqueryAjax_onError
        });
    };

})();

atualizaGrade = function () {
    $("#tblArquivos tbody").append(
        '<tr class="nao-editando { chaveDocumento: \'' + $("#A473_link").val() + '\',nomeDocumento: \'' + $("#A473_nome").val() + '\'}">'+
        '<td>' + $("#A473_nome").val() + '</td>'+
        '<td><button class="grade acao download" title="Download" type="button"></button></td>'+
        '<td><button class="grade acao desvincular" title="Desvincular" type="button"></button></td>'+
        '</tr>');
    var $tabelaDocumentosPendentes = $("#tblArquivos");
    var $linhas = $("tbody tr", $tabelaDocumentosPendentes);
    $("button.download", $linhas).click(buttonDownloadDocumento_onClick);
    $("button.desvincular", $linhas).click(buttonDesvincularDocumento_onClick);
        
}

buttonDownloadDocumento_onClick = function () {

    var $this = $(this);
    var $linha = $this.closest("tr");
    var md = $linha.metadata();
    var caminhoUpload = md.chaveDocumento;
    window.location = "../../comum/download.asp?filename=" + caminhoUpload;
        
}

buttonDesvincularDocumento_onClick = function () {

    if (confirm("Deseja realmente desvincular o upload?")) {

        var $this = $(this);
        var $linha = $this.closest("tr");
        var $tabela = $linha.closest("table");
        var md = $linha.metadata();
        var caminhoUpload = md.chaveDocumento;
        var par = $this.parent().parent(); //tr
        par.remove();
        
    }
}

