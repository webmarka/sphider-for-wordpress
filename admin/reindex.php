<?php
require_once('../wp-content/plugins/sphider/admin/spider.php');

if(!isset($_GET['index_url']))
	die('no URL!');
	$url=$_GET['index_url'];
	$parsed=@parse_url($url);
	if(!is_array($parsed))
	die('bad URL!');
	$domain=$parsed['host'];

$lvl = 1;
if(isset($_GET['lvl']))
	$lvl=$_GET['lvl'];

if(!isset($_GET['site_id']))
	die('no Site ID!');
	$site_id=$_GET['site_id'];
	
$t = microtime();
$a = getenv("REMOTE_ADDR");
$sessid = md5($t.$a);
$query = "select md5sum, indexdate from ".$mysql_table_prefix."links where url='$url'";
$result = mysql_query($query);
$rows = @mysql_num_rows($result);
if(0<$rows)
	{
		$row = mysql_fetch_array($result);
		$md5sum = $row['md5sum'];
		$indexdate = $row['indexdate'];
		index_url($url, $level+1, $site_id, $md5sum, $domain, $indexdate, $sessid, 0, 1);
	}
else
	{
		index_url($url, $lvl+1, $site_id, '', $domain, '', $sessid, 0, 0);
	}
?>