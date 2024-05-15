$(document).ready(function() {
    console.log('Initiated customRelatorio!');
    $("#menu").append('<li id="menu1"><a href="#" id="customRelatorio" title="Home" class="itemP">Relatório suporte</a></li>');
    
    function createFormPage(){
        return $("#page").html('<div class="center horizontal ui-tabs ui-widget ui-widget-content ui-corner-all ui-corner-left"><div class="loadingindicator">Carregando...</div></div>');
    }
    
    $("#customRelatorio").click(function(){
        var objectPage = createFormPage().children();
        
        $.ajax({
            url:        '../plugins/customreport/getCustomRelatorio.php',
            type:       'POST',
            dataType:   'html',
            success: function(data){
                objectPage.html(data);
            }
        });
    });
    
    function setHookSubmitMenu(object){
        object.submit(function(){
            $.ajax({
                url:        '../plugins/customreport/getCustomRelatorio.php?opt=getTasks',
                type:       'GET',
                dataType:   'html',
                data:       {
                                query: $(this).serialize()
                            },
                success: function(data){
                    $("#report").html(data);
                    $("#imprimir").click(function(){
                        var conteudo = data.replace('border="0"', 'border="1"');
                        print = window.open('about:blank');
                        print.document.write(conteudo);
                        print.window.print();
                        print.window.close();
                    });
                }
            });
        });
    }
    
    var checkExist = setInterval(function() {
        var object = $("#menuCustomRelatorio");
        if (object.length) {
            setHookSubmitMenu(object);
            clearInterval(checkExist);
        }
    }, 100);
});
