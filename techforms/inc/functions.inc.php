<?php
define('GLPI_ROOT', dirname(__FILE__).'/../../../..');
include (GLPI_ROOT . "/inc/includes.php");
$TECH_DB = new DB();

function getTech(){
    global $TECH_DB;
    $query = "SELECT users_id_tech,
    		CONCAT(glpi_users.firstname,' ',glpi_users.realname) as completename
    		FROM glpi_tickettasks
    		INNER JOIN glpi_users ON glpi_users.id = glpi_tickettasks.users_id_tech
    		WHERE glpi_users.is_active = 1
    		GROUP BY glpi_tickettasks.users_id_tech
    		ORDER BY glpi_users.firstname
";
    $list = array();
    if($result = $TECH_DB->query($query)){
        while($row = $TECH_DB->fetch_assoc($result)){
            $list[] = $row;
        }
    }
    return $list;
}

function format_time($t,$f=':') {
  return sprintf("%02d%s%02d", floor($t/3600), $f, ($t/60)%60);
}

function getTechTasks($data){
    global $TECH_DB;
    $query  = " SELECT  glpi_tickettasks.tickets_id,
    			glpi_users.id 					as tech_id,
          		CONCAT(glpi_users.firstname, ' ', glpi_users.realname) as tech,
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
                LEFT JOIN glpi_users		ON glpi_users.id = glpi_tickettasks.users_id_tech
                LEFT JOIN glpi_taskcategories   ON glpi_taskcategories.id           = glpi_tickettasks.taskcategories_id
                WHERE glpi_tickettasks.users_id_tech = ". addslashes($data['idtech']) ."
                AND glpi_tickettasks.date BETWEEN '". addslashes($data['_date1']) ." 00:00' AND '". addslashes($data['_date2']) ." 23:59'
                GROUP BY glpi_tickettasks.tickets_id, glpi_tickettasks.content, glpi_tickets.name, glpi_taskcategories.completename, glpi_tickettasks.date, glpi_tickettasks.actiontime
";
    if(!$data['garantia']){
        $query .= " AND glpi_tickettasks.taskcategories_id != 2"; //ID da Categoria Garantia
    }
    if(!$data['projeto']){
        $query .= " AND glpi_tickettasks.taskcategories_id != 4"; //ID da Categoria Projeto
    }
    $query .= " ORDER BY glpi_tickettasks.date ASC";
    $list   = array();
    if($result = $TECH_DB->query($query)){
        while($row = $TECH_DB->fetch_assoc($result)){
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

function isValidProfile(){
    $arrayProfileId = array(3, 4); //ID dos perfis que podem ver todos os grupos
    foreach($arrayProfileId as $profileID){
        if($_SESSION['glpiactiveprofile']['id'] == $profileID){
            return true;
        }
    }
    return false;
}
