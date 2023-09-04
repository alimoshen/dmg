<?php
/**
 * Plugin Name:       DMG Block
 * Description:       DMG Test block & Custom CLI Command.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Ali Moshen
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       DMG Block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

// --------------------------------
// DMG Custom Gutenber Block bit
// --------------------------------
function create_block_dmgblock_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_dmgblock_block_init' );


// --------------------------------
// DMG CLI bit
// --------------------------------
// Include my CLI command
include_once ( __DIR__ .'/dmg-cli.php');

// Add instruction page for my CLI
function dmg_cli_instructions() {
    add_menu_page(
        'DMG CLI Instructions', 
        'DGM CLI', 
        'manage_options',
        'dmg-cli-instructions', 
        'dmg_instructions_page'
    );
}

function dmg_instructions_page() {
	?> 
		<h1>How to use the WP DMG CLI command</h1>
		<h3>Search for posts containing the DMG Gutenberg block.</h3>
     	<h4>CLI Command Options</h4>
		<ol>
			<li>[--date-before=<date-before>] : Filter posts published before this date (DD-MM-YYYY). </li>
			<li>[--date-after=<date-after>] : Filter posts published after this date (DD-MM-YYYY). </li>
			<li>[--results-per-page=<results-per-page>] : Number of results to display per page (default: 10) </li>
			<li>[--page=<page>] : Page number to retrieve (default: 1) </li>
		</ol>
		<h4>CLI Examples</h4>
		<ol>
			<li>wp dmg-alert search --date-before=01-09-2023 --date-after=04-09-2023</li>
			<li>wp dmg-alert search --results-per-page=10 --page=2</li>
		</ol>
	<?php
}
add_action('admin_menu', 'dmg_cli_instructions');

// DMG CLI instructions link to plugin page
function dmg_instructions_link($links) {
    $settings_link = '<a href="admin.php?page=dmg-cli-instructions">DMG CLI Instructions</a>';
    array_push($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'dmg_instructions_link');