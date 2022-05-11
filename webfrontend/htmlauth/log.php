<?php
require_once "loxberry_system.php";
require_once "loxberry_web.php";
require_once "Config/Lite.php";

$L = LBWeb::readlanguage("language.ini");

$template_title = "Goodwe 2 MQTT";
$helplink = $L['LINKS.WIKI'];
$helptemplate = "pluginhelp.html";

$navbar[1]['Name'] = $L['NAVBAR.FIRST'];
$navbar[1]['URL'] = 'index.php';

$navbar[2]['Name'] = $L['NAVBAR.SECOND'];
$navbar[2]['URL'] = 'log.php';


// NAVBAR
$navbar[2]['active'] = True;

LBWeb::lbheader($template_title, $helplink, $helptemplate);

//LOGFILES
echo '<p class="wide">'. $L['LOGFILES.HEAD']. '</p>';

if ($handle = opendir($lbplogdir)) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
          echo '<div class="ui-corner-all ui-shadow">';
          echo '<a id="btnlogs" data-role="button" href="/admin/system/tools/logfile.cgi?logfile=plugins/pvsolcast/'. $entry. '&header=html&format=template" target="_blank" data-inline="true" data-mini="true">'.$entry. '</a>';
          echo '</div>';
        }
    }
    closedir($handle);
}

LBWeb::lbfooter();