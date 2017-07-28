
// Objeto de acesso global
Pessoa = {};

(function () {
    var pub = Pessoa;

    // Objeto de acesso privado
    var priv = {};


    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-cliente-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id_pessoa){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-cliente.php?acao=U&id=" + id_pessoa + "&id_menu=" + IDMenu;
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


    });

       priv.buttonExportarPdf_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-pdf-pessoa.php');
            $("#form-filtro").attr('target', '_self').submit();
       };
       priv.buttonExportarExcel_onClick = function (){
            $("#form-filtro").attr('action', 'exportador-excel-pessoa.php');
            $("#form-filtro").attr('target', '_self').submit();
       };

        priv.buttonDesativar_onClick = function (){
            arrayObjetos = new Array();
             
             $('.checked').each(
                function(){
                    if(!isNaN($(this).find('[name="checkboxes-cliente"]').val())){
                        arrayObjetos.push($(this).find('[name="checkboxes-cliente"]').val());
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
                        , url: "desativa-cliente-ajax.php"
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

        var filtroStatus = $("#filtro-status").val();

        var codigoCliente = $("#filtro-codigo-cliente").val();
        var nomeCliente = $("#filtro-nome-cliente").val();
        var cnpj = $("#filtro-cnpj-cliente").val();
        var status = $("#filtro-status").val();

        $.ajax({
                data: {
                    id: codigoCliente
                    ,nome: nomeCliente
                    ,cnpj: cnpj
                    ,status: status
                }
                , type: "POST"
                , url: "consulta-cliente-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });
    };



    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-cliente.php?acao=I&id_menu="+ IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
       var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-cliente.php?id_menu="+IDMenu;
    };

    priv.buttonGravarDados_onClick = function () {

        var loNome = $("#nome").val();
        var loNomeFantasia = $("#nome-fantasia").val();
        var loCnpj = $("#cnpj").val();
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
        var loAcao = $("#acao").val();
        var loID = $("#id").val();


        var loDadosJ = jQuery.parseJSON( '{ "nome": "'+loNome+'", "nome_fantasia": "'+loNomeFantasia+'", "cnpj": "'+loCnpj+'", "cep": "'+loCep+'", "endereco": "'+loEndereco+'", "bairro": "'+loBairro+'", "numero": "'+loNumero+'", "id_estado": "'+loEstado+'", "id_cidade": "'+loCidade+'", "complemento": "'+loComplemento+'", "telefone": "'+loTelefone+'", "celular": "'+loCelular+'", "email": "'+loEmail+'", "status": "'+loStatus+'", "acao": "'+loAcao+'", "id": "'+loID+'", "ind_carona": "'+loIndCarona+'"  }' );

        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-cliente.ajax.php"
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
                   window.location.href = "../../pessoa/apresentacao/consulta-cliente.php?id_menu="+IDMenu;
               }

            }
        });



    };

 
 
})();


