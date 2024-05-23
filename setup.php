<?php
// setup.php

define('PLUGIN_CUSTOMREPORT_VERSION', '2.0.0');

function plugin_version_customreport() {
    return [
        'name'           => "Custom Report",
        'version'        => PLUGIN_CUSTOMREPORT_VERSION,
        'author'         => 'Miguel',
        'license'        => 'GPLv2+',
        'homepage' 	 => 'https://ambientelivre.com.br',
        'minGlpiVersion' => '9.1'
    ];
}

function plugin_customreport_check_prerequisites() {
    if (version_compare(GLPI_VERSION, '9.1', 'lt')) {
        echo "This plugin requires GLPI >= 9.1";
        return false;
    }
    return true;
}

function plugin_customreport_check_config() {
    return true;
}
?>

