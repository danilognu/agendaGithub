var UIBootbox = function () {

    var handleDemo = function() {

        $('#demo_1').click(function(){
                bootbox.alert("Hello world!");    
        });
   
    }

    return {

        //main function to initiate the module
        init: function () {
            handleDemo();
        }
    };

}();

jQuery(document).ready(function() {    
   UIBootbox.init();
});