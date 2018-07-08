<?php
/**
 * Terracoin Status Page - System Stats
 *
 * @category File
 * @package  TerracoinStatus
 * @author   TheSin <thesin@southofheaven.org>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/thesin-/terracoind-status
 */

 // Get config
 require_once './php/config.php';

// Clear data if variable present
if (isset($_GET['clear']) & is_file($config['load_file'])) {
    unlink($config['load_file']);
}
if (isset($_GET['clear']) & is_file($config['memory_file'])) {
    unlink($config['memory_file']);
}

// Check for existing data
if (is_file($config['load_file'])) {
    $load = json_decode(file_get_contents($config['load_file']), true);
} else {
    $load = array();
}

// Check for existing data
if (is_file($config['memory_file'])) {
    $mem = json_decode(file_get_contents($config['memory_file']), true);
} else {
    $mem = array();
}

// If viewing is enabled, just output and die
if (isset($_GET['view'])) {
    print_r($load);
    print_r($mem);
    die();
}

// Get data
$newload = get_server_cpu_usage();
if (empty($newload))
    $newload = 0;
$newloaddata = array(
    'time'    => time(),
    'load'    => $newload,
);

$newmem = get_server_memory_usage();
$newmemdata = array(
    'time'    => time(),
    'mem'     => $newmem['mem'],
    'swap'    => $newmem['swap'],
    'total'   => $newmem['total'],
);

// Insert data
$load[] = $newloaddata;
$mem[] = $newmemdata;

// Purge old data
for ($i = 0; $i < count($load); $i++) {
    if ($load[$i]['time'] < (time() - $config['load_max_age'])) {
        array_splice($load, $i, 1);
    }
}

for ($i = 0; $i < count($mem); $i++) {
    if ($mem[$i]['time'] < (time() - $config['memory_max_age'])) {
        array_splice($mem, $i, 1);
    }
}

// Save array
if (file_put_contents($config['load_file'], json_encode($load), LOCK_EX) === false) {
    die("Failure storing data");
}

if (file_put_contents($config['memory_file'], json_encode($mem), LOCK_EX) === false) {
    die("Failure storing data");
}

function get_server_cpu_usage() {
    $load = sys_getloadavg();
    return $load[2];
}

function get_server_memory_usage() {
    $free = shell_exec('free');
    $free = (string)trim($free);
    $free_arr = explode("\n", $free);

    $mem = explode(" ", $free_arr[1]);
    $mem = array_filter($mem);
    $mem = array_merge($mem);
    $mem_total = $mem[1];
    $mem_avail = $mem[2];
    if (!empty($mem[6]))
        $mem_avail += $mem[6];
    $memory_usage = $mem_avail / $mem_total * 100;

    $swap_usage = 0;
    if (!empty($free_arr[2])) {
        $swap = explode(" ", $free_arr[2]);
        $swap = array_filter($swap);
        $swap = array_merge($swap);
        $swap_total = $swap[1];
        $swap_avail = $swap[2];
        $swap_usage = $swap_avail / $swap_total * 100;

        $total_usage = ($swap_avail + $mem_avail) / ($swap_total + $mem_total) * 100;
    } else {
        $total_usage = $memory_usage;
    }

    return array(
        'mem' => round($memory_usage, 2),
        'swap' => round($swap_usage, 2),
        'total' => round($total_usage, 2),
    );
}
?>
