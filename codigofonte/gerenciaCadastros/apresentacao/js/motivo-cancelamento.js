
// Objeto de acesso global
MotivoCancelamento = {};

(function () {
    var pub = MotivoCancelamento;

    // Objeto de acesso privado
    var priv = {};

    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-motivo-cancelamento-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-motivo-cancelamento.php?acao=U&id=" + id + "&id_menu=" + IDMenu;
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


    priv.buttonExportarPdf_onClick = function (){
        $("#form-filtro").attr('action', 'exportador-pdf-motivo-cancelamento.php');
        $("#form-filtro").attr('target', '_self').submit();
    };
    priv.buttonExportarExcel_onClick = function (){
        $("#form-filtro").attr('action', 'exportador-excel-motivo-cancelamento.php');
        $("#form-filtro").attr('target', '_self').submit();
    };


    

    priv.buttonPesquisa_onClick = function (){


       var loStatus = $("#filtro-status").val();
       var IDMenu = $("#id-menu").val();
       
        if(loStatus == ""){

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
            window.location.href = "consulta-motivo-cancelamento.php?id_menu="+IDMenu+"&status="+loStatus;
        }           

        /*$.ajax({
                data: {
                    status: loStatus

                }
                , type: "POST"
                , url: "consulta-motivo-cancelamento-ajax.php"
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
                , url: "consulta-motivo-cancelamento-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-motivo-cancelamento.php?acao=I&id_menu="+IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
       var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-motivo-cancelamento.php?id_menu="+IDMenu;
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
            , url: "gravar-motivo-cancelamento.ajax.php"
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
                    window.location.href = "../../gerenciaCadastros/apresentacao/consulta-motivo-cancelamento.php?id_menu="+IDMenu;
               }

            }
        });



    };

 
 
})();


