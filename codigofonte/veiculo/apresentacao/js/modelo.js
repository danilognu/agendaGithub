
// Objeto de acesso global
Modelo = {};

(function () {
    var pub = Modelo;

    // Objeto de acesso privado
    var priv = {};


        //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-modelo-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-modelo.php?acao=U&id=" + id + "&id_menu=" + IDMenu;
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
        $("#btn-desativar").click(priv.buttonDesativar_onClick);

        //$("#filtro-codigo-cliente").change(priv.LocalizaCliente_OnChange);

        //exportador
        $("#exportar-pdf").click(priv.buttonExportarPdf_onClick);
        $("#exportar-excel").click(priv.buttonExportarExcel_onClick);

    });

        priv.buttonExportarPdf_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-pdf-modelo.php');
            $("#form-filtro").attr('target', '_self').submit();
       };
       priv.buttonExportarExcel_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-excel-modelo.php');
            $("#form-filtro").attr('target', '_self').submit();
       };


        priv.buttonDesativar_onClick = function (){
            arrayObjetos = new Array();
             
             $('.checked').each(
                function(){
                    if(!isNaN($(this).find('[name="checkboxes-modelo"]').val())){
                        arrayObjetos.push($(this).find('[name="checkboxes-modelo"]').val());
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
                        , url: "desativa-modelo-ajax.php"
                        , success: function (retorno) {
                            window.location.reload();
                        }
                    });
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

        var nomeModelo = $("#filtro-nome-modelo").val();

        $.ajax({
                data: {
                    nome: nomeModelo
                }
                , type: "POST"
                , url: "consulta-modelo-ajax.php"
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
                , url: "consulta-modelo-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        window.location.href = "adicionar-modelo.php?acao=I";
    };

   priv.buttonCancelar_onClick = function () {
        window.location.href = "consulta-modelo.php";
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
            , url: "gravar-modelo.ajax.php"
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
                   window.location.href = "../../veiculo/apresentacao/consulta-modelo.php";
               }

            }
        });



    };

 
 
})();


