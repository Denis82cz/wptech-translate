<?php
/**
 * Main WPTech Translate Class for Czech Support
 *
 * @package WPTECH
 * @since 1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Wptech_Translate_CZ' ) ) :

    /**
     * Main Wptech_Translate_CZ Class.
     *
     * @package     WPTECH
     * @subpackage  Classes/Wptech_Translate_CZ
     * @since       1.0
     * @author      WPTech
     */
    final class Wptech_Translate_CZ {

        /**
         * The single instance of the class.
         *
         * @var Wptech_Translate_CZ
         * @since 1.0
         */
        protected static $_instance = null;

        /**
         * Main Wptech_Translate_CZ Instance.
         *
         * Ensures only one instance of Wptech_Translate_CZ is loaded or can be loaded.
         *
         * @since 1.0
         * @static
         * @see WPTECH_CZ()
         * @return Wptech_Translate_CZ - Main instance.
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        /**
         * Wptech_Translate_CZ Constructor.
         * @since 1.0
         */
        public function __construct() {
            $this->init_hooks();
        }

        /**
         * Hook into actions and filters.
         *
         * @since 1.0
         */
        private function init_hooks() {
            add_action( 'plugins_loaded', array( $this, 'load_textdomains' ) );
        }

        /**
         * Load plugin textdomains for supported plugins.
         *
         * @since 1.0
         */
        public function load_textdomains() {
            $plugin_dir = WPTECH_PLUGIN_DIR . 'translates/cz/';
            $locale = 'cs_CZ';

            // Seznam pluginů a jejich text domains
            $plugins = array(
                'gravityforms' => 'gravityforms',
                'fs-poster' => 'fs-poster',
                'pretty-link' => 'pretty-link',
                'advanced-database-cleaner' => 'advanced-database-cleaner',
                'supportcandy' => 'supportcandy',
                'elementor' => 'elementor',
                'deblocker' => 'deblocker'
            );

            foreach ( $plugins as $slug => $text_domain ) {
                $mofile = $plugin_dir . $text_domain . '-' . $locale . '.mo';

                // Debug: Ověření existence souboru
                if ( file_exists( $mofile ) ) {
                    load_textdomain( $text_domain, $mofile );
                } else {
                    error_log( 'WPTech Translate CZ: File not found ' . $mofile );
                }
            }

            // Načítání textových domén pro šablony
            $themes = array(
                'vikinger' => 'vikinger',
                'monstroid2' => 'monstroid2',
                'muvipro' => 'muvipro'
            );

            foreach ( $themes as $text_domain ) {
                $mofile = $plugin_dir . $text_domain . '-' . $locale . '.mo';

                // Debug: Ověření existence souboru
                error_log( 'WPTech Translate CZ: Checking for file ' . $mofile );

                if ( file_exists( $mofile ) ) {
                    load_textdomain( $text_domain, $mofile );
                    error_log( 'WPTech Translate CZ: Loaded ' . $mofile );
                } else {
                    error_log( 'WPTech Translate CZ: File not found ' . $mofile );
                }
            }

            error_log( 'WPTech Translate CZ: Finished loading textdomains.' ); // Debug log
        }
    }

endif; // End if class_exists check.
?>
