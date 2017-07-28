function loacalizaCidadeSelect(id_cidade){


    var id_estado = $("#estado option:selected").val();

    $.ajax({
            data: {
                 id_estado: id_estado
                 ,id_cidade: id_cidade
            }
            , type: "POST"
            //, dataType: "json"
            , url: "../../comum/apresentacao/busca-cidade.ajax.php"
            , success: function (data) {

               $('#cidade').html("");
               $('#cidade').append(data);
            }
        });//Ajax
    
        
}

function MotoristaHabilitacaoVenc_onClick() {


        $.ajax({
                data: {
                    dados: ""
                }
                , type: "POST"
                , url: "../../pessoa/apresentacao/lista-motorista-habilitacao-a-vencer-ajax.php"
                , success: function (retorno) {

                    $("#dialog-habilitacao").html(retorno);

                }
        });


        $( "#dialog-habilitacao" ).dialog({
                width: "80%",
                height: 400,
                title: "Motoristas",
                modal: true,
                buttons: {
                    "Sair": function() {
                    $( this ).dialog( "close" );
                    }
                }
            });

}

