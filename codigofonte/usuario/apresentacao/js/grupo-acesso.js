
// Objeto de acesso global
GrupoAcesso = {};



(function () {
    var pub = GrupoAcesso;

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

    pub.buttonAltera_onClick = function (id){

        window.location.href = "adicionar-grupo-acesso.php?acao=U&id="+id;

    };

    pub.buttonGerenciar_onClick = function (id){

        window.location.href = "gerenciar-grupo-acesso.php?acao=U&id_grupo="+id;

    };
    //pub.CarregaDados();

    pub.AbrirItem = function (id){
        var IDMenu = 1//$("#id-menu").val();
        window.location.href = "adicionar-grupo-acesso.php?acao=U&id=" + id + "&id_menu=" + IDMenu;
    };

    pub.ValidaPermissao = function (idGrupo,idMenu,perm,acesso,css_class,obj){

        if($("#"+idGrupo+idMenu+perm).attr('class') == "fa fa-check" ){
          $("#"+idGrupo+idMenu+perm).removeClass("fa fa-check").addClass("fa fa-close");
        }else if($("#"+idGrupo+idMenu+perm).attr('class') == "fa fa-close" ){
           $("#"+idGrupo+idMenu+perm).removeClass("fa fa-close").addClass("fa fa-check");
        }

        var loDadosJ = jQuery.parseJSON( '{  "id_grupo": "'+idGrupo+'", "id_menu": "'+idMenu+'", "perm": "'+perm+'", "acesso": "'+acesso+'" }' );

        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-permissao.ajax.php"
            , success: function (retorno) {                    
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
        $("#btn-cancelar-form").click(priv.buttonCancelar_onClick);
        $("#btn-excluir-form").click(priv.buttonExcluir_onClick);
        $("#btn-gravar-dados").click(priv.buttonGravarDados_onClick);
        $("#btn-permissao-dados").click(priv.buttonAtualizaPermissao_onClick);

    });

    priv.buttonExcluir_onClick = function (){
        

            bootbox.dialog({
                message: "Desaja realmente Excluir ?",
                title: "Aviso",
                buttons: {
                    confirm: {
                        label: "Sim",
                        className: "dark",
                        callback: function() {
                            priv.ExcluirGrupo();
                        }
                    }
                    ,cancel: {
                        label: 'N&atilde;o',
                        className: 'btn-danger'
                    }
                }
            });

    };

    priv.ExcluirGrupo = function (){

        var loId = $("#id").val(); 

        $.ajax({
            data: {
                id_grupo: loId
            }
            , type: "POST"
            , url: "excluir-grupo-acesso.ajax.php"
            , success: function (retorno) {

               window.location.href = "../../usuario/apresentacao/consulta-grupo-acesso.php";

            }
        });


    };

    priv.buttonAtualizaPermissao_onClick = function (){
        
         var indGestor = "";
         if($("#ind-gestor").is(":checked")){ indGestor = 1;}else{ indGestor = 0}

         var indOperador = "";
         if($("#ind-operador").is(":checked")){ indOperador = 1;}else{ indOperador = 0}   

         var indAdm = "";
         if($("#ind-adm").is(":checked")){ indAdm = 1;}else{ indAdm = 0} 

         var indUsuario = "";
         if($("#ind-usuario").is(":checked")){ indUsuario = 1;}else{ indUsuario = 0} 

         var idGrupoAcesso = $("#id").val();                 

         var loDadosJ = jQuery.parseJSON( '{ "ind_gestor": "'+indGestor+'", "ind_operador": "'+indOperador+'", "ind_adm": "'+indAdm+'", "ind_usuario": "'+indUsuario+'", "id_grupo": "'+idGrupoAcesso+'" }' );


                    $.ajax({
                        data: {
                            dados: loDadosJ
                        }
                        , type: "POST"
                        , dataType: "json"
                        , url: "altera-acessos-grupo-acesso.ajax.php"
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
                                window.location.href = "consulta-grupo-acesso.php";
                            }

                        }
                    });
    };

    priv.buttonAdicionar_onClick = function (){
        window.location.href = "adicionar-grupo-acesso.php?acao=I";
    };



   priv.buttonCancelar_onClick = function () {
        window.location.href = "consulta-grupo-acesso.php";
   };

    priv.buttonGravarDados_onClick = function () {

        var loNome = $("#nome").val();
        var loID = $("#id").val();
        var loAcao = $("#acao").val();

        var loDadosJ = jQuery.parseJSON( '{  "acao": "'+loAcao+'", "nome": "'+loNome+'", "id": "'+loID+'" }' );


        $.ajax({
            data: {
                dados: loDadosJ
            }
            , type: "POST"
            , dataType: "json"
            , url: "gravar-grupo-acesso.ajax.php"
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
                   window.location.href = "../../usuario/apresentacao/consulta-grupo-acesso.php";
               }

            }
        });



    };

  
 
 
})();


