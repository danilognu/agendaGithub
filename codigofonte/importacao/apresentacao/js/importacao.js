
// Objeto de acesso global
Importacao = {};



(function () {
    var pub = Importacao;

    // Objeto de acesso privado
    var priv = {};


   jQuery(function ($) {

       
        var optionsPadrao = {
            autoOpen: false
            , modal: true
        };

        


        $("#btn-importar-dados").click(priv.buttonImportar_onClick);
        $("#btn-limpar-dados").click(priv.buttonLimpar_onClick);

    });

    priv.buttonLimpar_onClick = function () {
        
        $("#textarea-placas").val("");

    };

  
    priv.buttonImportar_onClick = function () {

        var loPlacas = $("#textarea-placas").val();

        $.ajax({
            data: {
                strPlacas: loPlacas
            }
            , type: "POST"
            , dataType: "json"
            , url: "importacao-euroit-ajax.php"
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

                   
                    bootbox.dialog({
                        message: retorno.messagem,
                        title: "Sucesso",
                        buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                        }
                    });

                  $("#textarea-placas").val("");

               }

            }
        });



    };

  
 
 
})();


