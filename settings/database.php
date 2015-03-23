
<?php

  $wp_root_path = '../../../..';
  if(!realpath($wp_root_path.'/wp-blog-header.php')){$wp_root_path = '../../..';}
  if(!realpath($wp_root_path.'/wp-blog-header.php')){$wp_root_path = '.';}
  if(!realpath($wp_root_path.'/wp-blog-header.php')){$wp_root_path = '../../../../..';}
  if(!realpath($wp_root_path.'/wp-blog-header.php')){$wp_root_path = '../';}
  require_once(realpath($wp_root_path.'/wp-blog-header.php'));
	
	global $table_prefix;
	$database = DB_NAME;
	$mysql_user = DB_USER;
	$mysql_password = DB_PASSWORD; 
	$mysql_host = DB_HOST;
	$mysql_table_prefix = $table_prefix."sph_";
	
	
	$success = mysql_connect($mysql_host, $mysql_user, $mysql_password);
	if (!$success)
		die ("<b>Cannot connect to database, check if username, password and host are correct.</b>");
    mysql_select_db($database);
	if (!$success) {
		print "<b>Cannot choose database, check if database name is correct.";
		die();
	}
?>
