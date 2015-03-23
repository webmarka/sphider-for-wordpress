<?php
/*
Plugin Name: Sphider for WordPress
Plugin URI: http://www.sphider.eu/
Description: Sphider search indexing integrated with WordPress.
Version: 1.3.4.2
Author: Ando Saabas, and WP integration by Vizion Interactive, Inc
Author URI: http://www.vizioninteractive.com/
*/

/*
///////////////////////////////////////////////////////////////////
// Development Notes //////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

This plugin contains a modified version of Sphider, furthermore
the version of this plugin is based on the version of Sphider
that has been integrated with. Below is a list of the only
differences between this plugin's version of Sphider and the
original version released on http://www.sphider.eu/

Differences between this Plugin and the original Sphider source:

1.	/admin/auth.php does not include /admin/database.php, instead
	the db info is contained within /admin/auth.php
2.	/admin/auth.php has been cleared and now only contains the
	include of the admin-side of WordPress (to prevent the public
	from accessing the Sphider admin), and includes the wp-config.php
	database settings which are passed into the variables for use
	within Sphider.
3.	/admin/auth.php has a table prefix of "sph_" which goes after
	whatever the current $table_prefix is inside wp-config.php;
	For example: "wp_sph_" is the table prefix for Sphider to use
	if the $table_prefix is set to "wp_"
4.	/admin/database.php includes of the admin-side of WordPress
	(to prevent the public from accessing the Sphider admin), and
	includes the wp-config.php database settings which are passed
	into the variables for use within Sphider.
5.	All references to the function list_cats have been changed to
	sphider_list_cats for compatibility with WordPress.
6.	/include/commonfuncs.php has the remove_accents function removed
	in favor of the now included WordPress remove_accents function
	which is actually going to do a much better job :-)
7.	/admin/admin.php has a Sphider bug fix, urlencode before URL is
	output for links. WordPress (or just the server) doesn't like the
	URL without being encoded, or else it will show a 404 error.
8.	All references to the function get_links have been changed to
	sphider_get_links for compatibility with WordPress.
9.	/admin/admin.php has the log out function removed, from both
	the menu and the switch($f)
10.	/include/commonfuncs.php has another included "allowed" include
	directory to allow for search form integration on the site.
11. /settings/conf.php has a new configurable variable, searchFile
	which can be set in the search.php file or wherever you place it
	to point to the url it is *actually* located at.
12.	/templates/ have had all of it's files modified to replace
	search.php with $searchFile for support of the new variable
	mentioned in item #11 of this change list.
13.	New template added, named "wordpress", and set as default in
	/settings/conf.php - this template has the fixes necessary
	to run search through WordPress's theme directory.
14.	/your_search.php has been added for use within the WP Theme
	directory as the new search.php
15. /your_searchform.php has been added for use within the WP
	Theme directory as the new searchform.php
16.	/admin/reindex.php has been added to allow this plugin to
	reindex a URL when a post is saved, added, or deleted from
	within WP.
17.	/admin/spider.php has been modified to NOT run index_site if
	the "index_url" is in the query string; No extra functions will
	run, interupting the index process from item #16 in this change
	list.

///////////////////////////////////////////////////////////////////
*/

$sphider_latest = 134.2;

function sphider_admin_menu ()
	{
		add_management_page('Sphider','Sphider',8,'sphider','sphider_run_frame');
	}
function sphider_run_frame ()
	{
		global $wpdb, $table_prefix, $sphider_latest;
		echo "<h1>Sphider</h1>\n";
		echo "<h2>Search Index Manager</h2>\n";
		$page = "admin/admin.php";
		$clickhere='';
		if ($installed = number_format(get_option('sphider_version'),2))
			{
				if ($installed < $sphider_latest)
					{
						$result = $wpdb->get_results("SHOW TABLES LIKE '{$table_prefix}sph_%'");
						if(0<count($result))
							{
								$clickhere='upgraded to ';
								$page = "upgrade/upgrade.php";
							}
						else
							{
								$clickhere='installed ';
								$page = "admin/install.php";
							}
					}
			}
		else
			{
				$result = $wpdb->get_results("SHOW TABLES LIKE '{$table_prefix}sph_%'");
				if(count($result)<1)
					{
						$clickhere='installed ';
						$page = "admin/install.php";
					}
				delete_option('sphider_version');
				add_option('sphider_version', $sphider_latest);
			}
		if($page=='admin/install.php'||$page=='upgrade/upgrade.php')
			{
				$result = $wpdb->get_results("SHOW TABLES LIKE '{$table_prefix}sph_%'");
				if(0<count($result))
					{
						delete_option('sphider_version');
						add_option('sphider_version', $sphider_latest);
					}
				echo "<div id=\"message\" class=\"updated fade\"><p><span style=\"color:red;font-weight:bold;\">NOTICE:</span> A new version of Sphider has recently been installed. <a href=\"".get_bloginfo('url')."/wp-admin/tools.php?page=sphider\"><strong>Click here</strong></a> to reload this page once you have completely ".$clickhere." the latest version of Sphider using the dialog below.</p></div>\n<div style=\"clear:both;height:10px;\"></div>\n";
			}
?>
<style>
#frame_sphider {overflow:hidden!important; margin:0!important; padding:0!important; border:none!important; outline:none!important; width:95%; height:600px;}
</style>
<script type="text/javascript" language="javascript">
function sphider_sizeIFrame() {
	var theFrame = jQuery("#frame_sphider");
	var innerDoc = (theFrame.get(0).contentDocument) ? theFrame.get(0).contentDocument : theFrame.get(0).contentWindow.document;
	theFrame.height(innerDoc.body.scrollHeight + 45);
	theFrame.width(innerDoc.body.scrollWidth + 45);
}
jQuery(function() {
	jQuery("#frame_sphider").load(sphider_sizeIFrame);
	jQuery("#frame_sphider").location = '../wp-content/plugins/sphider/<?php echo $page; ?>';
});
</script>
<?php
		echo "<iframe id=\"frame_sphider\" src=\"../wp-content/plugins/sphider/".$page."\" scrolling=\"no\"></iframe><noframes>Your browser does not support frames. Please upgrade to a modern browser to use this plugin.</noframes>\n";
?>
<?php
	}

function sphider_reindex($id=0)
	{
		global $wpdb, $table_prefix;
		$post = get_post($id);
		if($post->post_status=='publish')
		if($post->post_type=='post'||$post->post_type=='page')
			{
				$url = get_permalink($id);
				$result = $wpdb->get_results("SELECT site_id FROM {$table_prefix}sph_links WHERE url='".$url."'");
				if(0<count($result))
					{
						$_GET['site_id'] = $result[0]->site_id;
						$_GET['index_url'] = $url;
						include_once "../wp-content/plugins/sphider/admin/reindex.php";
					}
				else
					{
						$parsed=@parse_url($url);
						if(!is_array($parsed)){return;}
						$host=$parsed['host'];
						$scheme=$parsed['scheme'];
						$result = $wpdb->get_results("SELECT site_id FROM {$table_prefix}sph_sites WHERE url LIKE '".$scheme."://".$host."%' ORDER BY url");
						if(0<count($result))
							{
								$_GET['site_id'] = $result[0]->site_id;
								$_GET['index_url'] = $url;
								include_once "../wp-content/plugins/sphider/admin/reindex.php";
							}
					}
			}
	}

function sphider_remove_page($id=0)
	{
		global $wpdb, $table_prefix;
		$post = get_post($id);
		if($post->post_status=='publish')
		if($post->post_type=='post'||$post->post_type=='page')
			{
				$result = $wpdb->get_results("SELECT link_id,site_id FROM {$table_prefix}sph_links WHERE url='".get_permalink($id)."'");
				if(0<count($result))
					{
						$_GET['link_id'] = $result[0]->link_id;
						$_GET['site_id'] = $result[0]->site_id;
						$_GET['f'] = 22;
						$_GET['start'] = 1;
						$_GET['filter'] = '';
						$_GET['per_page'] = 10;
						include_once "../wp-content/plugins/sphider/admin/admin.php";
					}
			}
	}
	
add_action('admin_menu','sphider_admin_menu');
add_action('save_post','sphider_reindex');
add_action('delete_post','sphider_remove_page');
?>