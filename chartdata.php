<?php
/**
 * Terracoin Status Page - Stats
 *
 * @category File
 * @package  TerracoinStatus
 * @author   Craig Watson <craig@cwatson.org>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/thesin-/terracoind-status
 */


if (!isset($_GET['stat'])) {
    die('Need to pass stat');
}

require_once './php/config.php';

switch($_GET['stat']) {
case 'connection':
    $data_file  = $config['stats_file'];
    $min_points = $config['chart_min_data_points'];
    $headers    = array('Date','Connections');
    $prefixes   = array('new Date(','');
    $postfixes  = array('*1000)','');
    break;

case 'peer':
    $data_file  = $config['peercount_file'];
    $min_points = $config['chart_min_data_points'];
    $headers    = array('Date','Other','Core');
    $prefixes   = array('new Date(','','');
    $postfixes  = array('*1000)','','');

    foreach ($config['peercount_extra_nodes'] as $key => $val) {
        $headers[]   = $val;
        $prefixes[]  = '';
        $postfixes[] = '';
    }

    break;

case 'masternode':
    $data_file  = $config['masternodecount_file'];
    $min_points = $config['chart_min_data_points'];
    $headers    = array('Date','Masternodes','Enabled');
    $prefixes   = array('new Date(','','');
    $postfixes  = array('*1000)','','');
    break;

case 'difficulty':
    $data_file  = $config['difficulty_file'];
    $min_points = $config['chart_min_data_points'];
    $headers    = array('Date','Difficulty');
    $prefixes   = array('new Date(','');
    $postfixes  = array('*1000)','');
    break;

case 'load':
    $data_file  = $config['load_file'];
    $min_points = $config['chart_min_data_points'];
    $headers    = array('Date','Load');
    $prefixes   = array('new Date(','');
    $postfixes  = array('*1000)','');
    break;

case 'memory':
    $data_file  = $config['memory_file'];
    $min_points = $config['chart_min_data_points'];
    $headers    = array('Date','Memory','Swap','Total');
    $prefixes   = array('new Date(','','','');
    $postfixes  = array('*1000)','','','');
    break;

default:
    die('Invalid value passed to stat');
}

// Check for existing data
if (is_file($data_file)) {
    $data = json_decode(file_get_contents($data_file), true);
} else {
    $data = array();
}

// Start output
echo "var " . $_GET['stat'] . "ChartData = [\n";

// Output headers
$headernum = 0; echo "\t[";
foreach ($headers as $header) {
    $headernum++;
    echo "'$header'";
    if ($headernum != count($headers)) {
        echo ",";
    }
}
echo "],\n";

// Output data rows
$rownum = 0;
foreach ($data as $row) {
    $rownum++;
    echo "\t[";
    $cellnum = 0;
    foreach ($row as $cell) {
        echo $prefixes[$cellnum] . $cell . $postfixes[$cellnum];
        $cellnum++;
        if ($cellnum != count($row)) {
            echo ",";
        }
    }
    echo "]";
    if ($rownum != count($data)) {
        echo ",";
    }
    echo "\n";
}

// Finish output
echo "]";
?>
