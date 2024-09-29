<?php

/**
 * Plugin Name: Set custom head and body scripts
 * Plugin URI: https://letgrow.pl/wordpress/plugins/letgrow-head-and-body
 * Description: Adds a "Custom Integrations" page to the "Settings" menu, which allows you to set content for the <code>head</code> tag or add content before the <code>body</code> tag.
 * Text Domain: letgrow-head-and-body
 * Domain Path: /languages
 * Version: 1.0.0
 * Requires at least: 6.4.3
 * Requires PHP: 7.4
 * Author: LetGrow
 * Author URI: https://letgrow.pl
 * License: MIT
 */

// don't load directly.
if (!defined('ABSPATH')) {
    die();
}

if (is_admin()) {
    if (!function_exists('letgrow_head_and_body_deactivate')) {
        /**
         * Deactivates the plugin and optionally clears the stored data.
         *
         * This function is triggered when the plugin is deactivated. It checks if the 'clear_on_deactivate' option is set to true.
         * If it is, the function deletes the 'head_tag_content', 'body_tag_content', and 'clear_on_deactivate' options.
         * 
         * @return void
         * 
         * @since 1.0.0
         * 
         * @uses get_option() To retrieve plugin options.
         * @uses delete_option() To delete plugin options.
         */
        function letgrow_head_and_body_deactivate(): void
        {
            if (get_option('clear_on_deactivate', false)) {
                delete_option('head_tag_content');
                delete_option(option: 'body_tag_content');
                delete_option('clear_on_deactivate');
            }
        }
    }

    register_deactivation_hook(__FILE__, 'letgrow_head_and_body_deactivate');

    if (!function_exists('letgrow_head_and_body_page')) {
        /**
         * Displays the Custom Integrations page in the WordPress admin area.
         *
         * This function handles the display of the Custom Integrations page, which allows users to set content for the <code>head</code> tag
         * or add content before the <code>body</code> tag. It also handles form submissions and updates plugin options.
         *
         * @throws Exception If the current page base does not match the expected page base.
         *
         * @return void
         * 
         * @since 1.0.0
         * 
         * @uses get_current_screen() To get the current screen object.
         * @uses get_option() To retrieve plugin options.
         * @uses update_option() To update plugin options.
         */
        function letgrow_head_and_body_page(): void
        {
            $page = get_current_screen();
            $expecte_page_base = 'settings_page_head_and_body';

            if ($page->base !== $expecte_page_base) {
                throw new Exception("Base page is different than expected: \"$expecte_page_base\", current base page: $page->base. This function should not be called directly!");
            }

            /**
             * @var bool $saved Indicates whether the form has been submitted.
             */
            $saved = false;

            /**
             * @var string $head_tag_content Content for the <code>head</code> tag set by the user.
             */
            $head_tag_content = get_option('head_tag_content', '');

            /**
             * @var string $body_tag_content Content for the <code>body</code> tag set by the user.
             */
            $body_tag_content = get_option('body_tag_content', '');

            /**
             * @var string $clear_on_deactivate Checked by the user when the user wants to clear plugin data on deactivate
             */
            $clear_on_deactivate = get_option('clear_on_deactivate', false);

            /**
             * Handle form submission
             */
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Handle clear on deactivate
                $clear_on_deactivate = isset($_POST['clear_on_deactivate']) ? true : false;
                update_option('clear_on_deactivate', $clear_on_deactivate);

                // Handle head content
                if (isset($_POST['head_tag_content'])) {
                    $head_tag_content = $_POST['head_tag_content'];
                    update_option('head_tag_content', $head_tag_content);
                }

                // Handle body content
                if (isset($_POST['body_tag_content'])) {
                    $body_tag_content = $_POST['body_tag_content'];
                    update_option('body_tag_content', $body_tag_content);
                }

                $saved = true;
            }

            include plugin_dir_path(__FILE__) . 'templates/admin-page.php';
        }
    }

    if (!function_exists('letgrow_head_and_body_load_plugin_textdomain')) {
        /**
         * Loads the plugin's translated strings.
         *
         * This function sets up the plugin's text domain and loads the translated strings
         * from the appropriate .mo file. It uses the 'plugin_locale' filter to determine the
         * appropriate locale for the translations.
         *
         * @return void
         * 
         * @since 1.0.0
         * 
         * @uses load_textdomain() To load the translations in admin area.
         * @uses apply_filters() To filter the locale for translations.
         */
        function letgrow_head_and_body_load_plugin_textdomain(): void
        {
            $domain = 'letgrow-head-and-body';
            $locale = apply_filters('plugin_locale', get_locale(), $domain);

            load_textdomain(
                $domain,
                trailingslashit(WP_LANG_DIR) . $domain . '/' . $domain . '-' . $locale . '.mo'
            );

            load_plugin_textdomain(
                $domain,
                FALSE,
                basename(dirname(__FILE__)) . '/languages/'
            );
        }
    }

    if (!has_action('init', 'letgrow_head_and_body_load_plugin_textdomain')) {
        add_action('init', 'letgrow_head_and_body_load_plugin_textdomain');
    }

    if (!function_exists('letgrow_head_and_body_add_submenu')) {
        /**
         * Adds a submenu page under the 'Settings' menu in the WordPress admin area.
         *
         * This function registers a new submenu page under the 'Settings' menu.
         * The submenu page is associated with the 'options-general.php' parent page. It uses the
         * 'letgrow_head_and_body_page' function as its callback to display the content of the page.
         *
         * @return void
         * 
         * @since 1.0.0
         * 
         * @uses add_submenu_page() To register the submenu page.
         */
        function letgrow_head_and_body_add_submenu()
        {
            add_submenu_page(
                'options-general.php',
                __('Custom integrations', 'letgrow-head-and-body'),
                __('Custom integrations', 'letgrow-head-and-body'),
                'administrator',
                'head_and_body',
                'letgrow_head_and_body_page',
                null
            );
        }
    }

    if (!has_action('admin_menu', 'letgrow_head_and_body_add_submenu')) {
        add_action('admin_menu', 'letgrow_head_and_body_add_submenu');
    }
} else {
    /**
     * Prints the content set for the <code>head</code> tag in the WordPress header.
     *
     * This function retrieves the content set for the <code>head</code> tag in the WordPress admin area
     * and prints it in the header of the website. If no content is set, it does nothing.
     *
     * @return void
     *
     * @since 1.0.0
     *
     * @uses get_option() To retrieve the content set for the <code>head</code> tag.
     * @uses strlen() To check if the content is not empty.
     * @uses echo To print the content in the header.
     */
    function letgrow_head_and_body_hook_head(): void
    {
        $head_tag_content = get_option('head_tag_content', '');

        if (strlen($head_tag_content) > 0) {
            echo $head_tag_content;
        }
    }

    /**
     * Prints the content set for the <code>body</code> tag in the WordPress body.
     *
     * This function retrieves the content set for the <code>body</code> tag in the WordPress admin area
     * and prints it in the bodyer of the website. If no content is set, it does nothing.
     *
     * @return void
     *
     * @since 1.0.0
     *
     * @uses get_option() To retrieve the content set for the <code>body</code> tag.
     * @uses strlen() To check if the content is not empty.
     * @uses echo To print the content in the body.
     */
    function letgrow_head_and_body_hook_body(): void
    {
        $body_tag_content = get_option('body_tag_content', '');

        if (strlen($body_tag_content) > 0) {
            echo $body_tag_content;
        }
    }

    if (!has_action('wp_head', 'letgrow_head_and_body_hook_head')) {
        add_action('wp_head', 'letgrow_head_and_body_hook_head');
    }

    if (!has_action('wp_footer', 'letgrow_head_and_body_hook_body')) {
        add_action('wp_footer', 'letgrow_head_and_body_hook_body');
    }
}