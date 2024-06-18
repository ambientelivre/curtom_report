$(document).ready(function() {
    console.log('Initiated customRelatorio!');
    
    $("#menu").append('<li id=\'menu8\' class=\'\' onmouseover="javascript:menuAff(\'menu8\',\'menu\');"><a href="#" id="customRelatorioMenu" class=\'itemP\'>Relatório Suporte</a><ul class=\'ssmenu\'><li class=\'\'><a href="#" id="customRelatorio">Relatório Cliente</a></li><li class=\'\'><a href="#" id="customRelatorioTech">Relatório Técnico</a></li></ul></li>');
    
    function createFormPage() {
        return $("#page").html('<div class="center horizontal ui-tabs ui-widget ui-widget-content ui-corner-all ui-corner-left"><div class="loadingindicator">Carregando...</div></div>');
    }

    function loadForm(url, callback) {
        var objectPage = createFormPage().children();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'html',
            success: function(data) {
                objectPage.html(data);
                if (callback) callback();
            }
        });
    }

    $("#customRelatorioMenu, #customRelatorio, #customRelatorioTech").click(function(event) {
        event.preventDefault();
        var url = '';
        switch (this.id) {
            case 'customRelatorioMenu':
            case 'customRelatorio':
                url = '../plugins/customreport/getCustomRelatorio.php';
                break;
            case 'customRelatorioTech':
                url = '../plugins/customreport/techforms/getCustomRelatorio.php';
                break;
        }
        loadForm(url, function() {
            if (this.id === 'customRelatorioMenu' || this.id === 'customRelatorio') {
                setHookSubmitMenu($("#menuCustomRelatorio"));
            } else if (this.id === 'customRelatorioTech') {
                setHookSubmitMenuTech($("#menuTechRelatorio"));
            }
        }.bind(this));
    });

    function setHookSubmitMenu(object) {
        object.off('submit').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '../plugins/customreport/getCustomRelatorio.php?opt=getTasks',
                type: 'GET',
                dataType: 'html',
                data: {
                    query: $(this).serialize()
                },
                success: function(data) {
                    $("#report").html(data);
                    $("#imprimir").off('click').on('click', function() {
                        var conteudo = data.replace('border="0"', 'border="1"');
                        var printWindow = window.open('about:blank');
                        printWindow.document.write(conteudo);
                        printWindow.window.print();
                        printWindow.window.close();
                    });
                }
            });
        });
    }

    function setHookSubmitMenuTech(object) {
        object.off('submit').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '../plugins/customreport/techforms/getCustomRelatorio.php?opt=getTechTasks',
                type: 'GET',
                dataType: 'html',
                data: {
                    query: $(this).serialize()
                },
                success: function(data) {
                    $("#report_tech").html(data);
                    $("#imprimir_tech").off('click').on('click', function() {
                        var conteudo = data.replace('border="0"', 'border="1"');
                        var printWindow = window.open('about:blank');
                        printWindow.document.write(conteudo);
                        printWindow.window.print();
                        printWindow.window.close();
                    });
                }
            });
        });
    }
});

