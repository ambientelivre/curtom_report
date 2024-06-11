$(document).ready(function() {
    console.log('Initiated customRelatorio!');
    
   $("#menu").append('<li id=\'menu7\' class=\'\' onmouseover="javascript:menuAff(\'menu7\',\'menu\');"><a href="#" id="customRelatorioMenu" class=\'itemP\'>Relatório Suporte</a><ul class=\'ssmenu\'><li class=\'\'><a href="#" id="customRelatorio">Relatório Cliente</a></li><li class=\'\'><a href="#" id="customRelatorioTech">Relatório Técnico</a></li></ul></li>');
    
    function createFormPage(){
        return $("#page").html('<div class="center horizontal ui-tabs ui-widget ui-widget-content ui-corner-all ui-corner-left"><div class="loadingindicator">Carregando...</div></div>');
    }
    
    $("#customRelatorioMenu").click(function(){
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
    
    $("#customRelatorioTech").click(function(){
        var objectPage = createFormPage().children();
        
        $.ajax({
            url:        '../plugins/customreport/techforms/getCustomRelatorio.php',
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
                    $("#imprimir").off(click);
                }
            });
        });
        object.off(submit);
    }

    function setHookSubmitMenuTech(object){
        object.submit(function(){
            $.ajax({
                url:        '../plugins/customreport/techforms/getCustomRelatorio.php?opt=getTechTasks',
                type:       'GET',
                dataType:   'html',
                data:       {
                                query: $(this).serialize()
                            },
                success: function(data){
                    $("#report_tech").html(data);
                    $("#imprimir_tech").click(function(){
                        var conteudo = data.replace('border="0"', 'border="1"');
                        print = window.open('about:blank');
                        print.document.write(conteudo);
                        print.window.print();
                        print.window.close();
                    });
                    $("#imprimir_tech").off(click);
                }
            });
        });
        object.off(submit);
    }

    var checkExistCustom = setInterval(function() {
        var object = $("#menuCustomRelatorio");
        if (object.length) {
            setHookSubmitMenu(object);
            clearInterval(checkExistCustom);
        }
    }, 100);    
    
    var checkExistTech = setInterval(function() {
        var object = $("#menuTechRelatorio");
        if (object.length) {
            setHookSubmitMenuTech(object);
            clearInterval(checkExistTech);
        }
    }, 100);
    
});
