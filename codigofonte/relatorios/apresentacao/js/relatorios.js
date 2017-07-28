
// Objeto de acesso global
MotoristaPassageiro = {};

(function () {
    var pub = MotoristaPassageiro;

    // Objeto de acesso privado
    var priv = {};



    jQuery(function ($) {

        //Botoes
        $("#btn-gerar-excel-rateio-solicitacao").click(priv.buttonRatioSolicitacaoGerarExcel_onClick);


    });

    priv.buttonRatioSolicitacaoGerarExcel_onClick = function (){

        var loDataSaida = $("#data-saida").val();
        var loDataRetorno = $("#data-retorno").val();

        if(loDataSaida == "" ||  loDataRetorno == ""){
            
                bootbox.dialog({
                    message: "Por favor, preencher a Data de Saida e Data de Retorno!",
                    title: "Aviso",
                    buttons: {
                    success: {
                        label: "OK",
                        className: "dark"
                    }
                    }
                });

        }else{
            $("#form-relatorio").attr('action', 'gerar-rateio-solicitacao-excel.php');
            $("#form-relatorio").attr('target', '_self').submit();
        }

    };
    
    priv.buttonGerarExpordador_onClick = function (tipo){

        $("#form-relatorio").attr('action', 'gerar-rateio-solicitacao-excel.php');
        $("#form-relatorio").attr('target', '_self').submit();

        var dataSaida = $("#data-saida").val();
        var dataRetorno = $("#data-retorno").val();
        var codigoVeiculo = $("#select-veiculo").val();
        var dataInicioPrev = $("#data-inic-prev").val();
        var dataTerminoPrev = $("#data-termino-prev").val();
        var codigoMotorista = $("#select-motorista").val();
        var codigoRequisitante = $("#select-requisitante").val();
        var codigoSetor = $("#setor").val();
        var localidaOrigem = $("#select-origem").val();
        var localidaDestino = $("#select-destino").val();
        var planejado = $("#planejado").val();

        if($("#ind-pernoite").is(":checked")){ IndPernoite = 1;}else{ IndPernoite = 0}
        if($("#ind-viagem").is(":checked")){ IndViagem = 1;}else{ IndViagem = 0}
        if($("#ind-com-motorista").is(":checked")){ IndMotorista = 1;}else{ IndMotorista = 0}



        var loDados = jQuery.parseJSON( '{ "dt_saida": "'+dataSaida+'", "dt_retorno_prev": "'+dataRetorno+'", "id_veiculo": "'+codigoVeiculo+'", "dt_partida": "'+dataInicioPrev+'", "id_pessoa_motorista": "'+codigoMotorista+'", "id_pessoa_requisitante": "'+codigoRequisitante+'", "id_setor": "'+codigoSetor+'", "id_localidade_origem": "'+localidaOrigem+'", "id_localidade_destino": "'+localidaDestino+'", "ind_planejado": "'+planejado+'", "tipo_exportacao": "'+tipo+'"  }' );

        $.ajax({
                data: {
                    dados: loDados
                }
                , type: "POST"
                , dataType: "json"
                , url: "gerar-atendimentos-por-setor-ajax.php"
                , success: function (retorno) {


                }
         });

    }; 



 

 
 
})();


