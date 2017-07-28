
// Objeto de acesso global
DisplayTempo = {};

(function () {
    var pub = DisplayTempo;

    // Objeto de acesso privado
    var priv = {};

    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-regioes-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.buttonAltera_onClick = function (id_parametro,id_vlr_parametro){

            var loIdParametro = id_parametro;
            var loIdVlrParametro = id_vlr_parametro;
            var loValor = $("#valor" + id_vlr_parametro).val();

            $(".atualiza-tempo-" + id_vlr_parametro).html("<img src='../../comum/apresentacao/imagens/ajax-loader_envio.gif'/>");

            $.ajax({
                data: {
                     id_parametro: loIdParametro
                    ,id_vlr_parametro: loIdVlrParametro
                    ,valor: loValor
                }
                , type: "POST"
                , url: "grava-tempo-ajax.php"
                , success: function (retorno) {

                    $(".atualiza-tempo-" + id_vlr_parametro).html("");

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
        $("#btn-pesquisa").click(priv.buttonPesquisa_onClick);
        $("#btn-cancelar-form").click(priv.buttonCancelar_onClick);
        $("#btn-gravar-dados").click(priv.buttonGravarDados_onClick);

        //exportador
        $("#exportar-pdf").click(priv.buttonExportarPdf_onClick);
        $("#exportar-excel").click(priv.buttonExportarExcel_onClick);


    });


    

    priv.buttonPesquisa_onClick = function (){


       var loStatus = $("#filtro-status").val();

        $.ajax({
                data: {
                    status: loStatus

                }
                , type: "POST"
                , url: "consulta-regioes-ajax.php"
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
                , url: "consulta-regioes-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-regioes.php?acao=I&id_menu="+IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
       var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-regioes.php?id_menu="+IDMenu;
    };

    priv.buttonGravarDados_onClick = function () {


        var loNome = $("#nome").val(); 
        var loStatus = $("#status").val();
        var loAcao = $("#acao").val();
        var loID = $("#id").val();  

        var loDadosJ = jQuery.parseJSON( '{ "nome": "'+loNome+'", "acao": "'+loAcao+'", "id": "'+loID+'", "status": "'+loStatus+'"  }' );


        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-regioes.ajax.php"
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
                    var IDMenu = $("#id-menu").val();
                    window.location.href = "../../gerenciaCadastros/apresentacao/consulta-regioes.php?id_menu="+IDMenu;
               }

            }
        });



    };

 
 
})();


