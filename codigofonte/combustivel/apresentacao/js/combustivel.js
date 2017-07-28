
// Objeto de acesso global
Modelo = {};

(function () {
    var pub = Modelo;

    // Objeto de acesso privado
    var priv = {};

    jQuery(function ($) {
        var optionsPadrao = {
            autoOpen: false
            , modal: true
        };

        priv.CarregaDados();

        //Consulta
        $("#btn-adicionar").click(priv.buttonAdicionar_onClick);

        //Form Cad / Add
        $("#pesquisa").click(priv.buttonPesquisa_onClick);
        $("#btn-cancelar-form").click(priv.buttonCancelar_onClick);
        $("#btn-gravar-dados").click(priv.buttonGravarDados_onClick);

        //$("#filtro-codigo-cliente").change(priv.LocalizaCliente_OnChange);

    });

    priv.LocalizaCliente_OnChange = function (){
        
        var codigoCliente = $("#filtro-codigo-cliente").val();

        var loDadosJ = jQuery.parseJSON( '{ "tipo_pessoa": "2", "id": "'+codigoCliente+'"  }' );

        $.ajax({
                data: {
                    dados: loDadosJ
                }
                , type: "POST"
                , dataType: "json"
                , url: "busca-dados-combustivel-ajax.php"
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

        var nomeModelo = $("#filtro-nome-modelo").val();

        $.ajax({
                data: {
                    nome: nomeModelo
                }
                , type: "POST"
                , url: "consulta-combustivel-ajax.php"
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
                , url: "consulta-combustivel-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        window.location.href = "adicionar-combustivel.php?acao=I";
    };

   priv.buttonCancelar_onClick = function () {
        window.location.href = "consulta-combustivel.php";
    };

    priv.buttonGravarDados_onClick = function () {


        var loNome = $("#nome").val();
        var loStatus =  $("#status").val();
        var loAcao = $("#acao").val();
        var loID = $("#id").val();

        var loDadosJ = jQuery.parseJSON( '{ "nome": "'+loNome+'", "status": "'+loStatus+'", "acao": "'+loAcao+'", "id": "'+loID+'" }' );

        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-combustivel.ajax.php"
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
                   window.location.href = "../../combustivel/apresentacao/consulta-combustivel.php";
               }

            }
        });



    };

 
 
})();


