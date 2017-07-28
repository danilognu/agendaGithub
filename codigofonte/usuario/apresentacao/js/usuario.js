
// Objeto de acesso global
Usuario = {};



(function () {
    var pub = Usuario;

    // Objeto de acesso privado
    var priv = {};


    //funções pub begin
    pub.CarregaDados = function (){

        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "consulta-usuario-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    //pub.CarregaDados();

    pub.CarregaDadosAutorizador = function (nome){

        id_usuario = $("#id_usuario").val();
        $.ajax({
                data: {
                    nome: nome
                    ,id_usuario: id_usuario
                }
                , type: "POST"
                , url: "consulta-usuario-autorizador-ajax.php"
                , success: function (retorno) {

                    $("#conteudo").html(retorno);

                }
            });

    };
    pub.AbrirItem = function (id){
        var IDMenu = 1//$("#id-menu").val();
        window.location.href = "adicionar-usuario.php?acao=U&id=" + id + "&id_menu=" + IDMenu;
    };
    pub.RemoverLinhaExcluirAutorizador = function (obj,idPessoaPai,idPessoaFilho){

            bootbox.confirm({
                        message: "Deseja Realmente Excluir ?",
                        buttons: {
                            confirm: {
                                label: 'Sim',
                                className: 'btn-success'
                            },
                            cancel: {
                                label: 'N&atilde;o',
                                className: 'btn-danger'
                            }
                        },
                        callback: function (result) {

                            if(result){

                                    var loDadosJ = jQuery.parseJSON( '{ "id_pessoa_pai": "'+idPessoaPai+'", "id_pessoa_filho": "'+idPessoaFilho+'" }' );

                                    $.ajax({
                                            data: {
                                                dados: loDadosJ
                                            }
                                            , type: "POST"
                                            , dataType: "json"
                                            , url: "excluir-autorizador-ajax.php"
                                            , success: function (retorno) {

                                                if(!retorno.erro){
                                                    var tr = $(obj).closest('tr');

                                                    tr.fadeOut(400, function(){ 
                                                        tr.remove(); 
                                                    });

                                                    //var idUsuario = $("#id_usuario").val();
                                                    //window.location.href = "adicionar-usuario.php?acao=U&id=" + idUsuario;
                                                }

                                            }
                                    });

                            }


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
        $("#pesquisa").click(priv.buttonPesquisa_onClick);
        $(".btn-cancelar-form").click(priv.buttonCancelar_onClick);
        $(".btn-gravar-dados").click(priv.buttonGravarDados_onClick);
        
        //Autorizador
        $("#btn-adicionar-quem-autorizo-pesq").click(priv.buttonAbrirPesquisaQuemAutorizo_onClick);
        $("#btn-adicionar-quem-me-autoriza-pesq").click(priv.buttonAbrirPesquisaQuemMeAutoriza_onClick);
        $(".btn-excluir-autorizador").click(priv.buttonExcluirAutorizador_onClick);

    });



    priv.buttonAbrirPesquisaQuemMeAutoriza_onClick  = function (){

        $.ajax({
                data: {
                    dados: ""
                    ,exibirConsulta: 0
                    ,tipoAutorizacao: 'quem_me_autoriza' 
                }
                , type: "POST"
                , url: "pesquisa-pessoa-ajax.php"
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
                        title: "Pesquisa pessoas que me autorizam" 
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });


    };

    priv.buttonAbrirPesquisaQuemAutorizo_onClick = function (){

        
        $.ajax({
                data: {
                    dados: ""
                    ,exibirConsulta: 0 
                    ,tipoAutorizacao: 'quem_autorizo' 
                }
                , type: "POST"
                , url: "pesquisa-pessoa-ajax.php"
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
                        title: "Pesquisa pessoa a  serem autorizadas" 
                        , width: "80%"
                        , height: 500
                    }, optionsPadraoVisualizar));
                    $('#dialog-message').dialog("open");  

                }
        });


    };

    priv.buttonPesquisa_onClick = function (){

        var filtroStatus = $("#filtro-status").val();
        var IDMenu = $("#id-menu").val();
       
        if(filtroStatus == ""){

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
            window.location.href = "consulta-usuario.php?id_menu="+IDMenu+"&status="+filtroStatus;
        }       

    };


    priv.buttonAdicionar_onClick = function () {
        window.location.href = "adicionar-usuario.php?acao=I";
    };

   priv.buttonCancelar_onClick = function () {
        window.location.href = "consulta-usuario.php";
    };

    priv.buttonGravarDados_onClick = function () {

        //Localiza Autorizadores
        codigosPessoaQuemAutorizo = new Array();
        $('.codigo-pessoa-quem_autorizo').each(
                function(){           
                 codigosPessoaQuemAutorizo.push($(this).val());
                }
        ); 

        codigosPessoaQuemMeAutoriza= new Array();
        $('.codigo-pessoa-quem_me_autoriza').each(
                function(){           
                 codigosPessoaQuemMeAutoriza.push($(this).val());
                }
        );        



        var loNome = $("#nome").val();
        var loLogin = $("#login").val();
        var loSenha = $("#senha").val();
        var loConfSenha = $("#confi-senha").val();
        var loEmail = $("#email").val();
        var loStatus = $("#status").val();
        var loAcao = $("#acao").val();
        var loIDUsuario = $("#id_usuario").val();
        var loEmpresa = $("#empresa").val();
        var loGrupoAcesso = $("#grupo-acesso").val();
        var loIdPessoaOrigem = $("#id_pessoa_origem").val();
        var loSetor = "";


        var loDadosJ = jQuery.parseJSON( '{ "nome": "'+loNome+'", "login": "'+loLogin+'", "senha": "'+loSenha+'", "confirSenha": "'+loConfSenha+'", "email": "'+loEmail+'", "status": "'+loStatus+'", "acao": "'+loAcao+'", "id_usuario": "'+loIDUsuario+'", "empresa": "'+loEmpresa+'","id_grupo": "'+loGrupoAcesso+'", "id_setor": "'+loSetor+'", "id_pessoa_origem": "'+loIdPessoaOrigem+'" }' );

        $.ajax({
            data: {
                dados: loDadosJ
                ,codigosPessoaQuemAutorizo: codigosPessoaQuemAutorizo
                ,codigosPessoaQuemMeAutoriza: codigosPessoaQuemMeAutoriza
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-usuario.ajax.php"
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
                   window.location.href = "../../usuario/apresentacao/consulta-usuario.php";
               }

            }
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

                if(retorno ==  0)
                {
                    //bootbox.alert("Login ou senha, Incorretos!");    

                    bootbox.dialog({
                        message: "Login ou senha, Incorretos!",
                        title: "Acesso",
                        buttons: {
                        success: {
                            label: "OK",
                            className: "dark"
                        }
                        }
                    });


                }else{
                    window.location.href = "../../comum/apresentacao/inicio.php";
                }
               //  -----

            }
        });

    };


 
 
})();


