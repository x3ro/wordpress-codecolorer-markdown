<?php

/*
Plugin Name: CodeColorer comaptiblity with "Markdown for WordPress and bbPress"
Plugin URI: http://github.com/x3ro/wordpress-codecolorer-markdown
Description: Automatically highlight markdown code-blocks with CodeColorer
Version: 0.1.1
Author: Lucas Jenss
Author URI: http://github.com/x3ro
License: MIT
*/

// don't load directly
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}


// Some basic plugin initialization
define( 'CODECOLORER_MARKDOWN_DIR', WP_PLUGIN_DIR . '/codecolorer-markdown/' );


// Define the parser class for markdown, which we extend from MarkdownExtra_Parser
// available in the "markdown-for-wordpress-and-bbpress" plugin.
define( 'MARKDOWN_PARSER_CLASS',  'CodeColorer_MarkdownExtra_Parser' );


class CodeColorerMarkdown {

    /**
     * Initializes the plugin by setting all necessary hooks
     *
     * @return void
     */
    public static function init() {

        // We won't load the plugin unless all its dependencies are met
        if(!self::checkDependencies()) {
            add_action('admin_notices',
                array('CodeColorerMarkdown', 'displayDependencyError'));
            return;
        }

        add_action('activated_plugin',
            array('CodeColorerMarkdown', 'activatedPluginHook'));


        add_action('plugins_loaded',
            array('CodeColorerMarkdown', 'loadOverwrittenMarkdownClass'));
    }


    /**
     * Load the extended markdown parser class. This has to be done when all plugins
     * have been loaded, because otherwise the class we want to extend wouldn't exist.
     *
     * @return void
     */
    public static function loadOverwrittenMarkdownClass() {
        include_once(CODECOLORER_MARKDOWN_DIR . 'class.codecolorer_markdownextra_parser.php');
    }


    /**
     * Hook that makes sure that this plugin is installed before its dependencies, because
     * otherwise the MARKDOWN_PARSER_CLASS constant from "markdown-for-wordpress-and-bbpress"
     * would already be defined and we couldn't overwrite it.
     * Taken from http://wordpress.org/support/topic/how-to-change-plugins-load-order
     *
     * @return void
     * @author jsdalton
     */
    function activatedPluginHook() {
        // ensure path to this file is via main wp plugin path
        $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
        $this_plugin = plugin_basename(trim($wp_path_to_this_file));
        $active_plugins = get_option('active_plugins');
        $this_plugin_key = array_search($this_plugin, $active_plugins);
        if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
            array_splice($active_plugins, $this_plugin_key, 1);
            array_unshift($active_plugins, $this_plugin);
            update_option('active_plugins', $active_plugins);
        }
    }


    /**
     * Checks if all the dependencies needed for this plugin to work are active.
     *
     * @return bool TRUE if all dependencies are met, otherwise FALSE
     */
    public static function checkDependencies() {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        return is_plugin_active('codecolorer/codecolorer.php') &&
            is_plugin_active('markdown-for-wordpress-and-bbpress/markdown.php');
    }


    /**
     * Displays an error message that not all dependencies are met
     *
     * @return void
     */
    public static function displayDependencyError() {
        global $current_screen;
        $msg = <<<HTML
            <div class="error">
                <p>
                    Not all dependencies for <b>CodeColorer-Markdown</b> are met. These dependencies are
                    <b>codecolorer</b> and <b>markdown-for-wordpress-and-bbpress</b>.
                </p>
            </div>
HTML;
        echo $msg;
    }

}

CodeColorerMarkdown::init();
