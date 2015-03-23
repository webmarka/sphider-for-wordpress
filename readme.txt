=== Sphider for WordPress ===
Contributors: vizioninteractive, Ando Saabas
Tags: sphider, search, index, engine, spider, suggest
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: 1.3.4.2

Sphider search indexing integrated with WordPress.

== Description ==

This plugin contains a modified version of Sphider, furthermore the version of this plugin is based on the version of Sphider that has been integrated with. For Sphider bugs, please see the [Official Sphider website](http://www.sphider.eu/). If you've determined that it's a WordPress related bug, let us know by posting a question in the [WordPress support forums](http://wordpress.org/tags/sphider?forum_id=10#postform)!

Why did we create this plugin? Vizion Interactive is a [Search Engine Optimization company](http://www.vizioninteractive.com/ "Search Engine Optimization company") and we believe that site-based search is very important. It can provide insight as to which keywords you could target, as well as determine if your visitors are finding what they are looking for as they browse your website.

If you are able to get this plugin to work on WordPress versions earlier than 2.7, let us know by contacting us through our [website](http://www.vizioninteractive.com/contact-us/ "WordPress Plugin help from Vizion Interactive")

= About Sphider =

Sphider is a popular open-source web spider and search engine. It includes an automated crawler, which can follow links found on a site, and an indexer which builds an index of all the search terms found in the pages. It is written in PHP and uses MySQL as its back end database (requires version 4 or above for both).

= Features =

**WordPress Integration** - Only available from *Sphider for WordPress*

* **Automatic Page Reindex:** After Adding, Updating, or Deleting a Page / Post, Sphider will now reindex that page or remove it from the index
* **Unified administration:** Sphider can now be accessed through `Tools >> Sphider`
* **Unified login:** Sphider admin interface now requires you to be logged in as a WordPress administrator
* **Unified database:** Sphider now uses the WordPress database to store the index and settings instead of a separate database
* **Organized tables:** Sphider uses the WordPress table prefix to keep the tables cleanly organized and easy to navigate
* **Installation and Upgrades:** Updates have been streamlined to keep your Sphider installation up to date

**Spidering and Indexing**

* Performs full text indexing.
* Can index both static and dynamic pages.
* Finds links in href, frame, area and meta tags, and can also follow links given in javascript as strings via window.location and window.open.
* Respects robots.txt protocol, and nofollow and noindex tags.
* Follows server side redirections.
* Allows spidering to be limited by depth (ie maximum number of clicks from the starting page), by (sub)domain or by directory.
* Allows spidering only the urls matching (or not matching) certain keywords or regular expressions.
* Supports indexing of pdf and doc files (using external binaries for file conversion).
* Allows resuming paused spidering.
* Possbility to exclude common words from being indexed.

**Searching**

* Supports AND, OR and phrase searches
* Supports excluding words (by putting a '-' in front of a word, any page including the word will be omitted from the results).
* Option to add and group sites into categories
* Possibility to limit searching to a given category and its subcategories.
* Possibility of searcing in a specified domain only.
* "Did you mean" search suggestion on mistyped queries.
* Context-sensitive auto-completion on search terms (a la Google Suggest)
* Word stemming for english (searching for "run" finds "running", "runs" etc)

**Administering**

* Includes a sophisticated web based administration interface
* Supports indexing via a web interface as well as from commandline - easy to set up cron jobs.
* Comprehensive site and search statistics
* Simple template system - easy to integrate into a site

== Installation ==

1. Unpack the entire contents of this plugin zip file into your `wp-content/plugins/` folder locally
1. Upload to your site
1. Navigate to `wp-admin/plugins.php` on your site (your WP plugin page)
1. Activate this plugin
1. Now Sphider will be located under the Tools menu, simply go there and start Sphidering!

OR you can just install it with WordPress by going to Plugins >> Add New >> and type Sphider

== Changes ==

= 02-11-2009 - 1.3.4.2: =

* Clearer Upgrade / Install notes on Sphider screen
* Sphider frame now grows with page to expand as you navigate through Sphider admin screens

= 02-11-2009 - 1.3.4.1: =

* Major bug fix, autosaves were triggering reindex which triggerered errors with the site

= 02-06-2009 - 1.3.4: =

* Initial release coupled with Sphider 1.3.4

== Usage ==

There are two files in the plugin folder for you to use when integrating Sphider with your WordPress installation:

1. your_search.php - Use this to replace your "search.php" in your theme directory. Modify this file to suit your needs and match your template as you wish.
1. your_searchform.php - Use this code wherever you wish to place your search boxes. Notice there are two search forms included in this file. One will search Sphider, and one will search through WordPress. You can easily customize this form to fit your needs.

== Changes to the original Sphider source ==

Differences between this Plugin and the original Sphider source:

1.	/admin/auth.php does not include /admin/database.php, instead
	the db info is contained within /admin/auth.php
1.	/admin/auth.php has been cleared and now only contains the
	include of the admin-side of WordPress (to prevent the public
	from accessing the Sphider admin), and includes the wp-config.php
	database settings which are passed into the variables for use
	within Sphider.
1.	/admin/auth.php has a table prefix of "sph_" which goes after
	whatever the current $table_prefix is inside wp-config.php;
	For example: "wp_sph_" is the table prefix for Sphider to use
	if the $table_prefix is set to "wp_"
1.	/admin/database.php includes of the admin-side of WordPress
	(to prevent the public from accessing the Sphider admin), and
	includes the wp-config.php database settings which are passed
	into the variables for use within Sphider.
1.	All references to the function list_cats have been changed to
	sphider_list_cats for compatibility with WordPress.
1.	/include/commonfuncs.php has the remove_accents function removed
	in favor of the now included WordPress remove_accents function
	which is actually going to do a much better job :-)
1.	/admin/admin.php has a Sphider bug fix, urlencode before URL is
	output for links. WordPress (or just the server) doesn't like the
	URL without being encoded, or else it will show a 404 error.
1.	All references to the function get_links have been changed to
	sphider_get_links for compatibility with WordPress.
1.	/admin/admin.php has the log out function removed, from both
	the menu and the switch($f)
1.	/include/commonfuncs.php has another included "allowed" include
	directory to allow for search form integration on the site.
1. /settings/conf.php has a new configurable variable, searchFile
	which can be set in the search.php file or wherever you place it
	to point to the url it is *actually* located at.
1.	/templates/ have had all of it's files modified to replace
	search.php with $searchFile for support of the new variable
	mentioned in item #11 of this change list.
1.	New template added, named "wordpress", and set as default in
	/settings/conf.php - this template has the fixes necessary
	to run search through WordPress's theme directory.
1.	/your_search.php has been added for use within the WP Theme
	directory as the new search.php
1. /your_searchform.php has been added for use within the WP
	Theme directory as the new searchform.php
1.	/admin/reindex.php has been added to allow this plugin to
	reindex a URL when a post is saved, added, or deleted from
	within WP.
1.	/admin/spider.php has been modified to NOT run index_site if
	the "index_url" is in the query string; No extra functions will
	run, interupting the index process from item #16 in this change
	list.
