<?php
require_once "loxberry_system.php";
require_once "loxberry_web.php";

$L = LBWeb::readlanguage("language.ini");
set_time_limit(60);

function TestDescription($desc)
{    
    echo date("H:i:s") . ": " . htmlspecialchars($desc) . " ... ";
}

function TestError($output, $error)
{
    global $L, $debug;
    echo "<b style='color: red'>" . htmlspecialchars($L['TEST.FAILED']) . "</b><br/>";

    if($debug)
    {
        echo "<div style='padding-left:40pt'><b>Fehler</b><br/><pre>" . htmlspecialchars($error) . "</pre><br/><b>Ausgabe</b><pre>" . htmlspecialchars($output) . "</pre></div><br/>";
    }
}

function TestOK($output = null)
{
    global $L, $debug;
    echo "<b  style='color: green'>" . htmlspecialchars($L['TEST.OK']) . "</b><br/>";
    if(!empty($output) && $debug)
    {
        echo "<div style='padding-left:40pt'><pre>" . $output . "</pre></div><br/>";
    }
}

function runCmd($command, &$output, &$error)
{
    $descriptorspec = array(
        0 => array("pipe", "r"),
        1 => array("pipe", "w"),
        2 => array("pipe", "w") 
     );
    
    $process = proc_open($command, $descriptorspec, $pipes);
    
    $output = stream_get_contents($pipes[1]);
    $error = stream_get_contents($pipes[2]);
    return proc_close($process);
}

$gotError = false;

TestDescription($L['TEST.CHECK_FOR_IP']);

if(!isset($_POST['ip']))
{
    TestError("", $L['TEST.NO_IP']);
    $gotError = true;
}
else
{
    TestOK();
}

$ip = $_POST['ip'];
$debug = $_POST['debug'] ?? 0;


if(!$gotError)
{
    TestDescription($L['TEST.SCAN']);

    $result_code = runCmd("python3 $lbpbindir/tests/scanTest.py \"$debug\"", $output, $error);

    if($result_code != 0)
    {
        TestError($output, $error);
    }
    else
    {
        TestOK($output);
    }
}

if(!$gotError)
{
    TestDescription($L['TEST.PING']);

    $result_code = runCmd("/bin/ping -c 1 $ip", $output, $error);

    if($result_code != 0)
    {
        TestError($output, $L['TEST.PING_FAILED']);
    }
    else
    {
        TestOK($output);
    }
}

if(!$gotError)
{
    TestDescription($L['TEST.CONNECTION']);

    $result_code = runCmd("python3 $lbpbindir/tests/connectionTest.py \"$ip\" \"$debug\"", $output, $error);

    if($result_code != 0)
    {
        TestError($output, $error);
        $gotError = true;
    }
    else
    {
        TestOK($output);
    }
}

if(!$gotError)
{
    TestDescription($L['TEST.SENSOR']);

    $result_code = runCmd("python3 $lbpbindir/tests/sensorTest.py \"$ip\" \"$debug\"", $output, $error);

    if($result_code != 0)
    {
        TestError($output, $error);
        $gotError = true;
    }
    else
    {
        TestOK($output);
    }
}

if(!$gotError)
{
    TestDescription($L['TEST.DATA']);

    $result_code = runCmd("python3 $lbpbindir/tests/dataTest.py \"$ip\" \"$debug\"", $output, $error);

    if($result_code != 0)
    {
        TestError($output, $error);    
        $gotError = true;
    }
    else
    {
        TestOK($output);
    }
}

echo "<br/>";

if($gotError)
    echo "<p><b style='color:red'>{$L['TEST.RESULT_ERROR']}</b></p>";
else
    echo "<p><b style='color:green'>{$L['TEST.RESULT_OK']}</b></p>";