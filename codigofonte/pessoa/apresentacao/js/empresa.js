
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
                , url: "consulta-empresa-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();


    pub.AbrirItem = function (id_pessoa){
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-empresa.php?acao=U&id=" + id_pessoa + "&id_menu=" + IDMenu;
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

        $("#filtro-codigo-empresa").change(priv.Localiza_OnChange);
        $("#imageUpload").click(priv.UploadImagem_OnChange);
        $("#btn-remover-logo").click(priv.RemoverImagemLogo);

    });

    priv.RemoverImagemLogo = function (){

          var loIdEmpresa = $("#id").val();
          $.ajax({
                data: {
                    id_empresa: loIdEmpresa
                }
                , type: "POST"
                , url: "remover-imagem-logo-ajax.php"
                , success: function (retorno) {

                    window.location.reload();

                }
            });        

    }

    priv.UploadImagem_OnChange = function (){
        $("#ImageLogo").hide(1000);
    }

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
                , url: "alteracao-consulta-empresa-ajax.php"
                , success: function (retorno) {

                    window.location.reload();

                }
            });

        }else{
            alert("Favor Selecionar um Item pelo menos!");
        }


    };

    priv.Localiza_OnChange = function (){
        
        var codigoEmpresa = $("#filtro-codigo-empresa").val();

        var loDadosJ = jQuery.parseJSON( '{ "tipo_pessoa": "2", "id": "'+codigoEmpresa+'"  }' );

        $.ajax({
                data: {
                    dados: loDadosJ
                }
                , type: "POST"
                , dataType: "json"
                , url: "busca-dados-empresa-ajax.php"
                , success: function (retorno) {

                    if(retorno == null){
                       
                        $("#filtro-nome-empresa").val("");
                    }else{
                        $("#filtro-nome-empresa").val(retorno);
                    }

                }
         });

    }; 

    priv.buttonPesquisa_onClick = function (){

        var filtroStatus = $("#filtro-status").val();

        var codigoEmpresa = $("#filtro-codigo-empresa").val();
        var nomeEmpresa = $("#filtro-nome-empresa").val();
        var cnpj = $("#filtro-cnpj-empresa").val();

        $.ajax({
                data: {
                    id: codigoEmpresa
                    ,nome: nomeEmpresa
                    ,cnpj: cnpj
                }
                , type: "POST"
                , url: "consulta-empresa-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });
    };



    priv.buttonAdicionar_onClick = function () {
        var IDMenu = $("#id-menu").val();
        window.location.href = "adicionar-empresa.php?acao=I&id_menu="+ IDMenu;
    };

   priv.buttonCancelar_onClick = function () {
       var IDMenu = $("#id-menu").val();
        window.location.href = "consulta-empresa.php?id_menu="+IDMenu;
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

        $.ajax({
            data: {
                 nome: loNome
                ,nome_fantasia: loNomeFantasia
                ,cnpj: loCnpj
                ,cep: loCep
                ,endereco: loEndereco
                ,bairro: loBairro
                ,numero: loNumero
                ,id_estado: loEstado
                ,id_cidade: loCidade
                ,complemento: loComplemento
                ,telefone: loTelefone
                ,celular: loCelular
                ,email: loEmail
                ,status: loStatus
                ,acao: loAcao
                ,id: loID
                ,validacao: "1"  
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-empresa.ajax.php"
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
                     //var IDMenu = $("#id-menu").val();
                     //window.location.href = "../../pessoa/apresentacao/consulta-empresa.php?id_menu="+IDMenu;

                     $("#form-empresa").attr("action","gravar-empresa.ajax.php");
                     $("#form-empresa").submit();
               }

            }
        });



    };

 
 
})();


