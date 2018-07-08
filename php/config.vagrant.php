<?php
/**
 * Terracoin Status Page
 *
 * @category File
 * @package  TerracoinStatus
 * @author   Craig Watson <craig@cwatson.org>
 * @license  https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link     https://github.com/thesin-/terracoind-status
 */

$config = array(
  // RPC
  'rpc_user'                  => 'status',
  'rpc_pass'                  => 'statustest',
  'rpc_host'                  => 'localhost',
  'rpc_port'                  => '13332',
  'rpc_ssl'                   => false,
  'rpc_ssl_ca'                => null,

  // Donations
  'display_donation_text'     => true,
  'donation_address'          => 'not_set',
  'donation_amount'           => '0.001',

  // Peers
  'display_peer_info'         => true,
  'display_peer_port'         => false,
  'hide_dark_peers'           => true,
  'ignore_unknown_ping'       => true,
  'peers_to_ignore'           => array(),

  // Cache
  'cache_geo_data'            => true,
  'geo_cache_file'            => '/var/tmp/terracoind-geolocation.cache',
  'geo_cache_time'            => 7 * 24 * 60 * 60, // 1 week
  'use_cache'                 => false,
  'cache_file'                => '/var/tmp/terracoind-status.cache',
  'max_cache_time'            => 300,
  'nocache_whitelist'         => array('127.0.0.1'),

  // Geolocation
  'geolocate_peer_ip'         => true,
  'display_ip_location'       => true,

  // UI
  'display_ip'                => true,
  'display_free_disk_space'   => true,
  'display_testnet'           => false,
  'display_masternode_status' => false,
  'display_version'           => true,
  'display_github_ribbon'     => false,
  'use_terracoind_ip'         => false,
  'intro_text'                => 'not_set',
  'display_chart'             => false,
  'chart_min_data_points'     => 5,
  'display_peer_chart'        => false,
  'display_masternode_chart'  => false,
  'display_difficulty_chart'  => false,
  'display_load_chart'        => false,
  'display_memory_chart'      => false,
  'node_links'                => array(),

  // Stats
  'stats_whitelist'           => array('127.0.0.1'),
  'stats_file'                => '/var/tmp/terracoind-status.data',
  'stats_max_age'             => 2 * 24 * 60 * 60, // 2 days

  // Node Count
  'peercount_whitelist'       => array('127.0.0.1'),
  'peercount_file'            => '/var/tmp/terracoind-peers.data',
  'peercount_max_age'         => 2 * 24 * 60 * 60, // 2 days
  'peercount_extra_nodes'     => array(),

  // Masternode Count
  'masternodecount_file'      => '/tmp/terracoind-mns.data',
  'masternodecount_max_age'   => 2 * 24 * 60 * 60, // 2 days

  // Difficulty
  'difficulty_file'           => '/tmp/terracoind-difficulty.data',
  'difficulty_max_age'        => 2 * 24 * 60 * 60, // 2 days

  // System Load
  'load_file'                 => '/tmp/terracoind-sysload.data',
  'load_max_age'              => 2 * 24 * 60 * 60, // 2 days

  // System Memory
  'memory_file'               => '/tmp/terracoind-sysmem.data',
  'memory_max_age'            => 2 * 24 * 60 * 60, // 2 days

  // Uptime
  'display_terracoind_uptime' => false,
  'terracoind_process_name'   => 'terracoind',

  // System
  'date_format'               => 'H:i:s T, j F Y ',
  'disk_space_mount_point'    => '.',
  'timezone'                  => null,
  'stylesheet'                => 'v2-light.css',
  'debug'                     => false,
  'admin_email'               => 'me@example.com',
);
?>
