<?php 
$wp_root_path = '../../../..';
if(!realpath($wp_root_path.'/wp-load.php')){$wp_root_path = '../../..';}
if(!realpath($wp_root_path.'/wp-load.php')){$wp_root_path = '.';}
if(!realpath($wp_root_path.'/wp-blog-header.php')){$wp_root_path = '../';}
require_once(realpath($wp_root_path.'/wp-load.php'));
require_once(realpath($wp_root_path.'/wp-admin/admin.php'));

error_reporting(E_ERROR | E_PARSE);
$settings_dir = "../settings";

global $table_prefix;
$database = DB_NAME;
$mysql_user = DB_USER;
$mysql_password = DB_PASSWORD; 
$mysql_host = DB_HOST;
$mysql_table_prefix = $table_prefix."sph_";
?>