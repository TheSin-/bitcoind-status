<?php
/**
 * Terracoin Status Page - Difficulty
 *
 * @category File
 * @package  TerracoinStatus
 * @author   Craig Watson <craig@cwatson.org>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/thesin-/terracoind-status
 */

 // Get config
 require_once './php/config.php';

 // Die if we're not in the whitelist or running on CLI
if (php_sapi_name() != 'cli') {
    if (!in_array($_SERVER['REMOTE_ADDR'], $config['peercount_whitelist'])) {
        die($_SERVER['REMOTE_ADDR'] . " is not in the whitelist");
    }
}

// Clear data if variable present
if (isset($_GET['clear']) & is_file($config['difficulty_file'])) {
    unlink($config['difficulty_file']);
}

// Check for existing data
if (is_file($config['difficulty_file'])) {
    $data = json_decode(file_get_contents($config['difficulty_file']), true);
} else {
    $data = array();
}

// If viewing is enabled, just output and die
if (isset($_GET['view'])) {
    print_r($data);
    die();
}

// Include EasyBitcoin library and set up connection
require_once './php/easybitcoin.php';
$terracoin = new Bitcoin($config['rpc_user'], $config['rpc_pass'], $config['rpc_host'], $config['rpc_port']);

// Setup SSL if configured
if ($config['rpc_ssl'] === true) {
    $terracoin->setSSL($config['rpc_ssl_ca']);
}

// Get data via RPC
$bcinfo = $terracoin->getblockchaininfo();

if (empty($bcinfo['difficulty']))
	$bcinfo['difficulty'] = 0;

// Initialise arrays
$to_insert = array(
    'time'      => time(),
    'difficulty' => $bcinfo['difficulty'],
);

// Insert data
$data[] = $to_insert;

// Purge old data
for ($i = 0; $i < count($data); $i++) {
    if ($data[$i]['time'] < (time() - $config['difficulty_max_age'])) {
        array_splice($data, $i, 1);
    }
}

// Save array
if (file_put_contents($config['difficulty_file'], json_encode($data), LOCK_EX) === false) {
    die("Failure storing data");
}
?>
