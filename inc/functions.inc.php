<?php
define('GLPI_ROOT', dirname(__FILE__).'/../../..');
include (GLPI_ROOT . "/inc/includes.php");
$DB = new DB();

function getGroups(){
    global $DB;
    $query = "SELECT * FROM glpi_groups";
    $list = array();
    if($result = $DB->query($query)){
        while($row = $DB->fetch_assoc($result)){
            $list[] = $row;
        }
    }
    return $list;
}

function format_time($t,$f=':') {
  return sprintf("%02d%s%02d", floor($t/3600), $f, ($t/60)%60);
}

function getTasks($data){
    global $DB;
    $query  = " SELECT  glpi_tickettasks.tickets_id,
                CONCAT(glpi_users.firstname, ' ', glpi_users.realname)  as requisitante,
                CONCAT(tech_users.firstname, ' ', tech_users.realname)  as tech,
                        glpi_tickets.name                               as sumario,
                        glpi_tickettasks.content                        as descricao,
                        glpi_taskcategories.completename                as categoria,
                        DATE_FORMAT(glpi_tickettasks.date, '%H:%i')  	as horainicio,
                        DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(glpi_tickettasks.date) + glpi_tickettasks.actiontime), '%H:%i') as horafim,
                        DATE_FORMAT(glpi_tickettasks.date, '%d/%m/%Y')  as data,
                        glpi_tickettasks.actiontime
                FROM glpi_tickettasks 
                INNER JOIN glpi_tickets         ON glpi_tickets.id                  = glpi_tickettasks.tickets_id 
                INNER JOIN glpi_tickets_users   ON glpi_tickets_users.tickets_id    = glpi_tickettasks.tickets_id 
                INNER JOIN glpi_groups_users    ON glpi_groups_users.users_id       = glpi_tickets_users.users_id 
                INNER JOIN glpi_users           ON glpi_users.id                    = glpi_tickets_users.users_id 
                LEFT JOIN glpi_users as tech_users ON tech_users.id = glpi_tickettasks.users_id_tech
                LEFT JOIN glpi_taskcategories   ON glpi_taskcategories.id           = glpi_tickettasks.taskcategories_id
                WHERE glpi_tickets_users.type = 1 
                AND glpi_groups_users.groups_id = ". addslashes($data['idgroup']) ."
                AND glpi_tickettasks.date BETWEEN '". addslashes($data['_date1']) ." 00:00' AND '". addslashes($data['_date2']) ." 23:59'";
    if(!$data['garantia']){
        $query .= " AND glpi_tickettasks.taskcategories_id != 2"; //ID da Categoria Garantia
    }
    if(!$data['projeto']){
        $query .= " AND glpi_tickettasks.taskcategories_id != 4"; //ID da Categoria Projeto
    }
    $query .= " ORDER BY glpi_tickettasks.date ASC";
    $list   = array();
    if($result = $DB->query($query)){
        while($row = $DB->fetch_assoc($result)){
	    $row['duracao'] = format_time($row['actiontime']);
            $list[] = $row;
        }
    }
    return $list;
}

function getTotalHoras($tasks){
    $total = 0;
    $totalSemGarantia = 0;
    foreach($tasks as $task){
        $total += $task['actiontime'];
        if($task['categoria'] != 'Garantia'){
            $totalSemGarantia += $task['actiontime'];
        }
    }
    return array('total' => format_time($total), 'semgarantia' => format_time($totalSemGarantia));
}

function isMyGroup($group){
    foreach($_SESSION['glpigroups'] as $userGroupID) {
        if($group['id'] == $userGroupID){
            return true;
        }
    }
    return false;
}

function isValidProfile(){
    $arrayProfileId = array(3, 4); //ID dos perfis que podem ver todos os grupos
    foreach($arrayProfileId as $profileID){
        if($_SESSION['glpiactiveprofile']['id'] == $profileID){
            return true;
        }
    }
    return false;
}
