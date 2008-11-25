<?php 
/*
Plugin Name: Dump Queries
Plugin URI: http://dev.wp-plugins.org/browser/dump_queries/
Description: Dump query and cache stats for debug purposes.
Version: 1.0.1
Author: Ryan Boren
Author URI: http://boren.nu/
*/

/*
The following must be added to wp-config.php for this plugin to be useful.

define('SAVEQUERIES', true);

*/

function dq_dump_queries() {
	global $wpdb;
	$hide = true;

	if ($hide) echo "<!--\n";
		if ( SAVEQUERIES === true ) {
		echo "<p>\n";
		echo "<strong>Total Number of Queries:</strong> {$wpdb->num_queries}<br/>\n";
		echo "<strong>Number of seconds:</strong> "; timer_stop(1); echo "<br/>\n\n";
		echo "<strong>Memory Usage:</strong> " . memory_get_usage() . "<br/>\n\n";
		echo "</p>";

		foreach ($wpdb->queries as $query) {
			echo "<p>\n";
			echo "<strong>Query:</strong> {$query[0]}<br/>\n";
			echo "<strong>Time:</strong> {$query[1]}<br />\n";
			if ( isset($query[2]) )
				echo "<strong>Caller:</strong> {$query[2]}\n";
			echo "</p>\n";
		}
	} else {
		echo "<p>Add the following to wp-config.php to enable query dumps.</p>\n";
		echo "<p><code>define('SAVEQUERIES', true);</code></p>\n";	
	}

	global $wp_object_cache;
	if ( isset($wp_object_cache) )
		$wp_object_cache->stats();

	if ($hide) echo "\n-->\n";
}

add_action('wp_footer', 'dq_dump_queries');
add_action('admin_footer', 'dq_dump_queries');
?>
