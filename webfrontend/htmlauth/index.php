<?php
require_once "loxberry_system.php";
require_once "loxberry_web.php";

$L           = LBWeb::readlanguage("language.ini");
$file_config = $lbpconfigdir . '/config.json';
$file_log  = $lbplogdir . '/goodwe.log';

$scan_result = "";

if (isset($_POST['save'])) {
    
    $config = json_decode(file_get_contents($file_config), true);
    $config['InverterIP'] = $_POST['InverterIP'];
    $config['TimeAmount'] = $_POST['TimeAmount'];
    $config['TimeUnit'] = $_POST['TimeUnit'];
    file_put_contents($file_config, json_encode($config));

    copy("$lbhomedir/system/cron/cron.d/$lbpplugindir", "/tmp/$lbpplugindir");
    $cron = file_get_contents("/tmp/$lbpplugindir");
    $cron = explode("# ---TEMPLATE---", $cron)[0] . "# ---TEMPLATE---";
    
    if($config['TimeUnit'] == 0)
    {        
        $turns = 60 / $config['TimeAmount'];

        for($i = 1; $i <= $turns; $i++)
        {
            $cron .= "\n* * * * * loxberry sleep " . (($i*$config['TimeAmount']) - $config['TimeAmount']) . "; timeout {$config['TimeAmount']}s php $lbpbindir/importData.php";
        }
    }
    else
    {
        $cron .= "\n*/{$config['TimeAmount']} * * * * loxberry timeout 60s php $lbpbindir/importData.php";        
    }

    file_put_contents("/tmp/$lbpplugindir", $cron);

    exec("sudo $lbhomedir/sbin/installcrontab.sh $lbpplugindir /tmp/$lbpplugindir", $output, $result_code);

    @unlink("/tmp/$lbpplugindir");

    $saveSuccessfully = true;
}
else if(isset($_POST['scanInverter']))
{
    exec("python3 $lbpbindir/scanForLocalInverters.py", $output, $result_code);

    if($result_code == 0)
    {
        $config = json_decode(file_get_contents($file_config), true);
        $scan = json_decode($output[0]);
        $config['InverterIP'] = $scan[0];
        file_put_contents($file_config, json_encode($config));
        $scan_result = $L['MAIN.SCAN_SUCCESS'];
    }
    else
    {
        $scan_result = $L['MAIN.SCAN_ERROR'];
    }
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
?>
<script>
    $( document ).ready(function()
    {
        validate_enable('#InverterIP');
        validate_enable('#TimeAmount');
    });
</script>
<p><?=$L['MAIN.INTRO']?></p>
<form action="index.php" method="post">
    <div class="ui-body ui-body-a ui-corner-all" >
        
        <div class="ui-grid-b">
            <div class="ui-block-a">
                <label for="InverterIP" style="text-align:left;"><?= $L['MAIN.IP'] ?></label>
                <input data-inline="true" data-mini="true" name="InverterIP" id="InverterIP" value="<?= $config['InverterIP'] ?>" type="text" data-validation-rule="special:ipaddr">
            </div>
            <div class="ui-block-b" style="margin-top: 10pt; text-align:right">
                <button type="submit" name="scanInverter" class="ui-btn ui-btn-inline ui-icon-search ui-btn-icon-left"><?= $L['MAIN.SEARCH_INVERTER'] ?></button>
            </div>
            <div class="ui-block-c" style="margin-top: 25pt; padding-left:5pt">
                <?= $scan_result ?>
            </div>
        </div>
        <br/>
        <label for="TimeAmount" style="text-align:left;"><?= $L['MAIN.TIME'] ?></label>
        <input data-inline="true" data-mini="true" name="TimeAmount" id="TimeAmount" value="<?= $config['TimeAmount'] ?>" type="text" data-validation-rule="special:number-min-max-digits:1:60">
        <fieldset data-role="controlgroup" data-type="horizontal">
            <legend><?= $L['MAIN.TIME_UNIT'] ?>:</legend>
            <input type="radio" name="TimeUnit" id="TimeUnit-Seconds" value="0" <?php if($config['TimeUnit'] == 0): ?> checked="checked" <?php endif; ?>>
            <label for="TimeUnit-Seconds"><?= $L['MAIN.SECONDS'] ?></label>
            <input type="radio" name="TimeUnit" id="TimeUnit-Minutes" value="1" <?php if($config['TimeUnit'] == 1): ?> checked="checked" <?php endif; ?>>
            <label for="TimeUnit-Minutes"><?= $L['MAIN.MINUTES'] ?></label>
        </fieldset>
    </div>
    <p>
        <center>
            <input data-role="button" data-inline="true" data-mini="true" type="submit" name="save" data-icon="check" value="<?=$L['MAIN.SAVE']?>">
            <?php if(isset($saveSuccessfully)): ?>
                <p style="color: green; font-weight: bold; font-size: 120%"><?= $L['MAIN.SAVE_SUCCESS'] ?></p>
            <?php endif; ?>
        </center>
    </p>
</form>

<?php LBWeb::lbfooter(); ?>