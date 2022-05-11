<?php
require_once "loxberry_system.php";
require_once "loxberry_web.php";

$L           = LBWeb::readlanguage("language.ini");
$file_config = $lbpconfigdir . '/config.json';
$file_log  = $lbplogdir . '/goodwe.log';

if ($_POST) {
    if ($_POST['system_active1'] == "on") {
        $system_active1 = "1";
    } else {
        $system_active1 = "0";
    }
    if ($_POST['system_active2'] == "on") {
        $system_active2 = "1";
    } else {
        $system_active2 = "0";
    }
    if ($_POST['system_active3'] == "on") {
        $system_active3 = "1";
    } else {
        $system_active3 = "0";
    }
    if ($_POST['system_active4'] == "on") {
        $system_active4 = "1";
    } else {
        $system_active4 = "0";
    }	
    if ($_POST['debug_active'] == "on") {
        $debug_active = "1";
    } else {
        $debug_active = "0";
    }
	
    
    $data = '{
        "system_1": {
            "active": "' . $system_active1 . '",
            "api": "' . $_POST['apikey1'] . '",
            "cap": "' . $_POST['cap1'] . '",
            "tilt": "' . $_POST['tilt1'] . '",
            "azim": "' . $_POST['azim1'] . '",
            "lat": "' . $_POST['lat1'] . '",
            "lon": "' . $_POST['lon1'] . '",
            "loss": "' . $_POST['loss1'] . '",
            "install": "' . $_POST['install1'] . '"
        },
        "system_2": {
            "active": "' . $system_active2 . '",
            "api": "' . $_POST['apikey2'] . '",
            "cap": "' . $_POST['cap2'] . '",
            "tilt": "' . $_POST['tilt2'] . '",
            "azim": "' . $_POST['azim2'] . '",
            "lat": "' . $_POST['lat2'] . '",
            "lon": "' . $_POST['lon2'] . '",
            "loss": "' . $_POST['loss2'] . '",
            "install": "' . $_POST['install2'] . '"
        },
        "system_3": {
            "active": "' . $system_active3 . '",
            "api": "' . $_POST['apikey3'] . '",
            "cap": "' . $_POST['cap3'] . '",
            "tilt": "' . $_POST['tilt3'] . '",
            "azim": "' . $_POST['azim3'] . '",
            "lat": "' . $_POST['lat3'] . '",
            "lon": "' . $_POST['lon3'] . '",
            "loss": "' . $_POST['loss3'] . '",
            "install": "' . $_POST['install3'] . '"
        },
        "system_4": {
            "active": "' . $system_active4 . '",
            "api": "' . $_POST['apikey4'] . '",
            "cap": "' . $_POST['cap4'] . '",
            "tilt": "' . $_POST['tilt4'] . '",
            "azim": "' . $_POST['azim4'] . '",
            "lat": "' . $_POST['lat4'] . '",
            "lon": "' . $_POST['lon4'] . '",
            "loss": "' . $_POST['loss4'] . '",
            "install": "' . $_POST['install4'] . '"
        },		
        "debug": "' . $debug_active . '",
        "timer": ' . json_encode($_POST['timer']) . '
    }';
    
    $handle = fopen($file_config, "w");
    fwrite($handle, $data);
    fclose($handle);
}

$config = json_decode(file_get_contents($file_config), true);

$template_title = "Goodwe 2 MQTT";
$helplink       = $L['LINKS.WIKI'];

$helptemplate = "pluginhelp.html";

$navbar[1]['Name'] = $L['NAVBAR.FIRST'];
$navbar[1]['URL']  = 'index.php';
$navbar[2]['Name'] = $L['NAVBAR.SECOND'];
$navbar[2]['URL']  = 'log.php';

// NAVBAR
$navbar[1]['active'] = True;
LBWeb::lbheader($template_title, $helplink, $helptemplate);
echo '<p>' . $L['MAIN.INTRO1'] . '</p>';
echo '<form action="index.php" method="post">';
echo '
  <div class="ui-body ui-body-a ui-corner-all" >
<table style="width: 100%">
  <tr>
    <th >
    <div class="ui-body ui-body-a ui-corner-all">
    <h4>' . $L['USER.HEAD1'] . '</h4>
';
echo '<select name="system_active1" id="system_active1" data-role="slider" >
    <option value="off"';
if ($config['system_1']['active'] != 1) {
    echo 'selected';
}
echo '>Off</option>
    <option value="on"';
if ($config['system_1']['active'] == 1) {
    echo 'selected';
}
echo '>On</option>
</select>';

echo '<label for="apikey1" style="text-align:left;">' . $L['USER.API'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="apikey1" id="apikey1"  value="' . $config['system_1']['api'] . '" type="text">';
echo '<br><label for="cap1" style="text-align:left;">' . $L['USER.CAP'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="cap1" id="cap1"  value="' . $config['system_1']['cap'] . '" type="text">';
echo '<br><label for="tilt1" style="text-align:left;">' . $L['USER.TILT'] . '</label>';
echo '<input type="range" min="0" max="90" name="tilt1" id="tilt1"  value="' . $config['system_1']['tilt'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="azim1" style="text-align:left;">' . $L['USER.AZIM'] . '<a  class="tooltip ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" href=""><span><img src="compass.gif"></span></a></label>';
echo '<input type="range" min="-180" max="180" name="azim1" id="azim1"  value="' . $config['system_1']['azim'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="lon1" style="text-align:left;">' . $L['USER.LON'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lon1" id="lon1"  value="' . $config['system_1']['lon'] . '" type="text">';
echo '<br><label for="lat1" style="text-align:left;">' . $L['USER.LAT'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lat1" id="lat1"  value="' . $config['system_1']['lat'] . '" type="text">';
echo '<br><label for="loss1" style="text-align:left;">' . $L['USER.LOSS'] . '</label>';
echo '<input type="range" min="0" max="100" name="loss1" id="loss1"  value="' . $config['system_1']['loss'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="install1" style="text-align:left;">' . $L['USER.INSTALL'] . '</label>';
echo '<input type="date" name="install1" id="install1"  value="' . $config['system_1']['install'] . '" type="text">';
echo '
</div></th>
    <th><div class="ui-body ui-body-a ui-corner-all" style="margin-left: 10px; margin-right: 10px;">
    <h4>' . $L['USER.HEAD2'] . '</h4>';
echo '<select name="system_active2" id="system_active2" data-role="slider" >
    <option value="off"';
if ($config['system_2']['active'] != 1) {
    echo 'selected';
}
echo '>Off</option>
    <option value="on"';
if ($config['system_2']['active'] == 1) {
    echo 'selected';
}
echo '>On</option>
</select>';

echo '<label for="apikey2" style="text-align:left;">' . $L['USER.API'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="apikey2" id="apikey2"  value="' . $config['system_2']['api'] . '" type="text">';
echo '<br><label for="cap2" style="text-align:left;">' . $L['USER.CAP'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="cap2" id="cap2"  value="' . $config['system_2']['cap'] . '" type="text">';
echo '<br><label for="tilt2" style="text-align:left;">' . $L['USER.TILT'] . '</label>';
echo '<input type="range" min="0" max="90" name="tilt2" id="tilt2"  value="' . $config['system_2']['tilt'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="azim2" style="text-align:left;">' . $L['USER.AZIM'] . '<a  class="tooltip ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" href=""><span><img src="compass.gif"></span></a></label>';
echo '<input type="range" min="-180" max="180" name="azim2" id="azim2"  value="' . $config['system_2']['azim'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="lon2" style="text-align:left;">' . $L['USER.LON'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lon2" id="lon2"  value="' . $config['system_2']['lon'] . '" type="text">';
echo '<br><label for="lat2" style="text-align:left;">' . $L['USER.LAT'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lat2" id="lat2"  value="' . $config['system_2']['lat'] . '" type="text">';
echo '<br><label for="loss2" style="text-align:left;">' . $L['USER.LOSS'] . '</label>';
echo '<input type="range" min="0" max="100" name="loss2" id="loss2"  value="' . $config['system_2']['loss'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="install2" style="text-align:left;">' . $L['USER.INSTALL'] . '</label>';
echo '<input type="date" name="install2" id="install2"  value="' . $config['system_2']['install'] . '" type="text">';
echo '
</div></th>
    <th><div class="ui-body ui-body-a ui-corner-all" style="margin-left: 10px; margin-right: 10px;">
    <h4>' . $L['USER.HEAD3'] . '</h4>';
echo '<select name="system_active3" id="system_active3" data-role="slider" >
    <option value="off"';
if ($config['system_3']['active'] != 1) {
    echo 'selected';
}
echo '>Off</option>
    <option value="on"';
if ($config['system_3']['active'] == 1) {
    echo 'selected';
}
echo '>On</option>
</select>';
echo '<label for="apikey3" style="text-align:left;">' . $L['USER.API'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="apikey3" id="apikey3"  value="' . $config['system_3']['api'] . '" type="text">';
echo '<br><label for="cap3" style="text-align:left;">' . $L['USER.CAP'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="cap3" id="cap3"  value="' . $config['system_3']['cap'] . '" type="text">';
echo '<br><label for="tilt3" style="text-align:left;">' . $L['USER.TILT'] . '</label>';
echo '<input type="range" min="0" max="90" name="tilt3" id="tilt3"  value="' . $config['system_3']['tilt'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="azim3" style="text-align:left;">' . $L['USER.AZIM'] . '<a  class="tooltip ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" href=""><span><img src="compass.gif"></span></a></label>';
echo '<input type="range" min="-180" max="180" name="azim3" id="azim3"  value="' . $config['system_3']['azim'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="lon3" style="text-align:left;">' . $L['USER.LON'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lon3" id="lon3"  value="' . $config['system_3']['lon'] . '" type="text">';
echo '<br><label for="lat3" style="text-align:left;">' . $L['USER.LAT'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lat3" id="lat3"  value="' . $config['system_3']['lat'] . '" type="text">';
echo '<br><label for="loss3" style="text-align:left;">' . $L['USER.LOSS'] . '</label>';
echo '<input type="range" min="0" max="100" name="loss3" id="loss3"  value="' . $config['system_3']['loss'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="install3" style="text-align:left;">' . $L['USER.INSTALL'] . '</label>';
echo '<input type="date" name="install3" id="install3"  value="' . $config['system_3']['install'] . '" type="text">';
echo '
</div></th>
    <th><div class="ui-body ui-body-a ui-corner-all">
    <h4>' . $L['USER.HEAD4'] . '</h4>';
echo '<select name="system_active4" id="system_active4" data-role="slider" >
    <option value="off"';
if ($config['system_4']['active'] != 1) {
    echo 'selected';
}
echo '>Off</option>
    <option value="on"';
if ($config['system_4']['active'] == 1) {
    echo 'selected';
}
echo '>On</option>
</select>';
echo '<label for="apikey4" style="text-align:left;">' . $L['USER.API'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="apikey4" id="apikey4"  value="' . $config['system_4']['api'] . '" type="text">';
echo '<br><label for="cap4" style="text-align:left;">' . $L['USER.CAP'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="cap4" id="cap4"  value="' . $config['system_4']['cap'] . '" type="text">';
echo '<br><label for="tilt4" style="text-align:left;">' . $L['USER.TILT'] . '</label>';
echo '<input type="range" min="0" max="90" name="tilt4" id="tilt4"  value="' . $config['system_4']['tilt'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="azim4" style="text-align:left;">' . $L['USER.AZIM'] . '<a  class="tooltip ui-alt-icon ui-nodisc-icon ui-btn-inline ui-icon-info ui-btn-icon-notext" href=""><span><img src="compass.gif"></span></a></label>';
echo '<input type="range" min="-180" max="180" name="azim4" id="azim4"  value="' . $config['system_4']['azim'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="lon4" style="text-align:left;">' . $L['USER.LON'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lon4" id="lon4"  value="' . $config['system_4']['lon'] . '" type="text">';
echo '<br><label for="lat4" style="text-align:left;">' . $L['USER.LAT'] . '</label>';
echo '<input data-inline="true" data-mini="true" name="lat4" id="lat4"  value="' . $config['system_4']['lat'] . '" type="text">';
echo '<br><label for="loss4" style="text-align:left;">' . $L['USER.LOSS'] . '</label>';
echo '<input type="range" min="0" max="100" name="loss4" id="loss4"  value="' . $config['system_4']['loss'] . '" type="text" style="font-weight: normal;">';
echo '<br><label for="install4" style="text-align:left;">' . $L['USER.INSTALL'] . '</label>';
echo '<input type="date" name="install4" id="install4"  value="' . $config['system_4']['install'] . '" type="text">';
echo ' </tr>
</table>
</div>
  <div class="ui-body ui-body-a ui-corner-all" >
<label for="timer" class="select">' . $L['SYSTEM.TIMER'] . '</label>
<select name="timer[]" id="timer" multiple="multiple" data-native-menu="false" data-icon="grid" data-iconpos="left">
    <option>Choose a few options:</option>';

for ($x = 4; $x <= 22; $x++) {
    echo '<option value="' . $x . '"';
    if (in_array($x, $config['timer'])) {
        echo " selected";
    }
    echo '>' . $x . ':00</option>';
}
echo '</select>';
echo '</div>
  <div class="ui-body ui-body-a ui-corner-all" >
<label for="debug_active" style="text-align:left;">' . $L['SYSTEM.DEBUG'] . '</label>';
echo '<select name="debug_active" id="debug_active" data-role="slider" >
    <option value="off"';
if ($config['debug'] != 1) {
    echo 'selected';
}
echo '>Off</option>
    <option value="on"';
if ($config['debug'] == 1) {
    echo 'selected';
}
echo '>On</option>
</select>
</div>';
echo '<br><p><center><input data-role="button" data-inline="true" data-mini="true" type="submit" name="save_new" data-icon="check" value=' . $L['MAIN.SAVE'] . '> </center></p>';
echo '</form>';
LBWeb::lbfooter();