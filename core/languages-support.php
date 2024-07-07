<?php
/**
 * Languages Support
 *
 * @package WPTECH
 */

// Načtení překladových souborů pro různé pluginy
function wptech_load_external_textdomains() {
    if ( version_compare( PHP_VERSION, '7.2', '<' ) ) {
        add_action( 'admin_notices', 'wptech_translate_php_version_error' );
        return;
    }

    global $wp_version;
    if ( version_compare( $wp_version, '5.0', '<' ) ) {
        add_action( 'admin_notices', 'wptech_translate_wp_version_error' );
        return;
    }

    $plugin_dir = plugin_dir_path( __FILE__ ) . '../translates/';
    $locale = wptech_translate_determine_locale();

    // Seznam pluginů a jejich text domains
    $plugins = array(
        'gravityforms' => 'gravityforms',
        'fs-poster' => 'fs-poster',
        'pretty-link' => 'pretty-link',
        'advanced-database-cleaner' => 'advanced-database-cleaner',
        'supportcandy' => 'supportcandy'
    );

    foreach ( $plugins as $slug => $text_domain ) {
        $mofile = $plugin_dir . $locale . '/' . $text_domain . '-' . $locale . '.mo';

        // Debug: Ověření existence souboru
        if ( file_exists( $mofile ) ) {
            load_textdomain( $text_domain, $mofile );
        } else {
            error_log( 'WPTech Translate: ' . sprintf( __( 'File not found: %s', 'wptech-translate' ), $mofile ) );
        }
    }
}
add_action( 'plugins_loaded', 'wptech_load_external_textdomains' );

/**
 * Determines the locale to use for loading text domains.
 *
 * @return string The locale string.
 */
function wptech_translate_determine_locale() {
    // Get the site locale
    $locale = get_locale();
    
    // Support for both Czech and Slovak languages
    if ( in_array( $locale, array( 'cs_CZ', 'sk_SK' ) ) ) {
        return $locale;
    }
    
    // Default to empty string if locale is not specifically supported
    return '';
}

function wptech_translate_php_version_error() {
    echo '<div class="notice notice-error"><p>';
    _e( 'Plugin WPTech Translate requires PHP version 7.2 or higher.', 'wptech-translate' );
    echo '</p></div>';
}

function wptech_translate_wp_version_error() {
    echo '<div class="notice notice-error"><p>';
    _e( 'Plugin WPTech Translate requires WordPress version 5.0 or higher.', 'wptech-translate' );
    echo '</p></div>';
}
?>
