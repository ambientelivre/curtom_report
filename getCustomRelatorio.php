<?php
include_once 'inc/functions.inc.php';

switch($_REQUEST['opt']){
    case 'getTasks':
        parse_str($_REQUEST['query'], $data);
        if(!isValidProfile() && !isMyGroup(array('id' => $data['idgroup']))){
            die('Erro! Não foi possível concluir a requisição desejada.');
        }
        include_once 'forms/report.form.php';
        break;
    default:
        include_once 'forms/menu.form.php';
        break;
}
