
// Objeto de acesso global
Localidade = {};

(function () {
    var pub = Localidade;

    // Objeto de acesso privado
    var priv = {};

    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-localidade-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id_pessoa){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-localidade.php?acao=U&id=" + id_pessoa + "&id_menu=" + IDMenu;
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

        //exportador
        $("#exportar-pdf").click(priv.buttonExportarPdf_onClick);
        $("#exportar-excel").click(priv.buttonExportarExcel_onClick);

    });

      
      priv.buttonExportarPdf_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-pdf-localidade.php');
            $("#form-filtro").attr('target', '_self').submit();
       };
      priv.buttonExportarExcel_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-excel-localidade.php');
            $("#form-filtro").attr('target', '_self').submit();
       };



    
        priv.buttonDesativar_onClick = function (){
            arrayObjetos = new Array();
             
             $('.checked').each(
                function(){
                    if(!isNaN($(this).find('[name="checkboxes-localidade"]').val())){
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
                        , url: "desativa-localidade-ajax.php"
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
                , url: "alteracao-consulta-localidade-ajax.php"
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
                , url: "busca-dados-localidade-ajax.php"
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


        var codigoLocalidade = $("#filtro-codigo-localidade").val();
        var nomeLocalidade = $("#filtro-nome-localidade").val();
        var status = $("#filtro-status").val();
        var IDMenu = $("#id-menu").val();

        if(codigoLocalidade == "" && nomeLocalidade == "" && status == "" ){

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
            window.location.href = "consulta-localidade.php?id_menu="+IDMenu+"&id="+codigoLocalidade+"&nome="+nomeLocalidade+"&status="+status;
        }
        

        /*$.ajax({
                data: {
                    id: codigoLocalidade
                    ,nome: nomeLocalidade
                    ,status: status
                }
                , type: "POST"
                , url: "consulta-localidade-ajax.php"
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
                , url: "consulta-localidade-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };

    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-localidade.php?acao=I&id_menu="+IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
       var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-localidade.php?id_menu="+IDMenu;
    };

    priv.buttonGravarDados_onClick = function () {


        var loNome = $("#nome").val(); 
        var loCategoria = $("#categoria").val();
        var loIdPessoaUnidade = $("#id-pessoa-unidade").val(); 
        var loLongitude = $("#longitude").val(); 
        var loLatitude = $("#latitude").val(); 
        var loCep = $("#cep").val(); 
        var loEndereco = $("#endereco").val(); 
        var loBairro = $("#bairro").val(); 
        var loNumero = $("#numero").val();
        var loComplemento = $("#complemento").val(); 
        var loCidade = $("#cidade").val(); 
        var loTelefone = $("#telefone").val(); 
        var loTelefone2 = $("#telefone2").val(); 
        var loGaragem = $("#garagem").val(); 
        var loCodRastreamento = $("#cod-rastreamento").val();
        var loStatus = $("#status").val();
        var loAcao = $("#acao").val();
        var loID = $("#id").val();  
        var loIdLogradouro = $("#logradouro").val();

            



        var loDadosJ = jQuery.parseJSON( '{ "nome": "'+loNome+'", "categoria": "'+loCategoria+'", "id_pessoa_unidade": "'+loIdPessoaUnidade+'", "longitude": "'+loLongitude+'", "latitude": "'+loLatitude+'", "cep": "'+loCep+'", "endereco": "'+loEndereco+'", "bairro": "'+loBairro+'", "numero": "'+loNumero+'", "complemento": "'+loComplemento+'", "id_cidade": "'+loCidade+'", "telefone": "'+loTelefone+'", "telefone2": "'+loTelefone2+'", "garagem": "'+loGaragem+'", "cod_rastreamento": "'+loCodRastreamento+'", "acao": "'+loAcao+'", "id": "'+loID+'", "status": "'+loStatus+'", "id_tipo_logradouro": "'+loIdLogradouro+'"  }' );

        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-localidade.ajax.php"
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
                    window.location.href = "../../localidade/apresentacao/consulta-localidade.php?id_menu="+IDMenu;
               }

            }
        });



    };

 
 
})();


