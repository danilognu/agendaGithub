
// Objeto de acesso global
Carona = {};

(function () {
    var pub = Carona;

    // Objeto de acesso privado
    var priv = {};

    //publico befin
    pub.EncaminharAtorizador = function (idSolicitacao){

            $.ajax({
                        data: {
                            id: idSolicitacao
                            ,exibirConsulta: 1 
                        }
                        , type: "POST"
                        , url: "pesquisa-autorizadores-ajax.php"
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
                                title: "Pesquisa Autorizador"
                                , width: "60%"
                                , height: 400
                            }, optionsPadraoVisualizar));
                            $('#dialog-message').dialog("open");  

                        }
                }); 
                        
    };
    pub.ModalPesquisaAutorizador = function (idSolicitacao){

        var loNome = $("#filtro-nome").val(); 
        var loCpf = "";//$("#filtro-cpf").val();

        $.ajax({
                data: {
                    id: idSolicitacao
                    ,nome: loNome
                    ,cpf: loCpf
                    ,exibirConsulta: 1 
                }
                , type: "POST"
                , url: "pesquisa-autorizadores-ajax.php"
                , success: function (retorno) {

                        ~//$('#dialog-message').dialog("close");  
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
                            title: "Pesquisa Autorizador"
                            , width: "60%"
                            , height: 400
                        }, optionsPadraoVisualizar));
                        $('#dialog-message').dialog("open");  

                }
        });

    };
    pub.EnviaEmailAutorizador = function (idPessoa,idSolicitacao){

        $.ajax({
                    data: {
                        id_pessoa: idPessoa
                        ,id_solicitacao: idSolicitacao
                    }
                    , type: "POST"
                    , url: "envia-email-autorizadores-ajax.php"
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
                            window.location.href = "consulta-carona.php?id="+idSolicitacao;
                        }

                    }
            });

    };
    //publico end

    //elementos ocultos
    $(".messagem-valida-placa").hide();

 
       jQuery(function ($) {
        var optionsPadrao = {
            autoOpen: false
            , modal: true
        };

        //Form Cad / Add
        $("#pesquisa-carona").click(priv.buttonPesquisa_onClick);
   


    });

   priv.buttonPesquisa_onClick = function (){

        $("#form-filtro").attr('action', 'consulta-carona.php');
        $("#form-filtro").submit();

    };
 
})();


