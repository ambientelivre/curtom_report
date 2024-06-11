<?php
include_once 'inc/functions.inc.php';

if(!isValidProfile()){
	    die('<div class="center horizontal ui-tabs ui-widget ui-widget-content ui-corner-all ui-corner-left"><div class="loadingindicator">Erro! Acesso Negado.<br>Requer Permissão de Administrador</div></div>');
        }

switch($_REQUEST['opt']){
    case 'getTechTasks':
        parse_str($_REQUEST['query'], $data);
        if(!isValidProfile()){
            die('Erro! Acesso Negado.');
        }
        include_once 'forms/report.form.php';
        break;
    default:
        include_once 'forms/menu.form.php';
        break;
}
