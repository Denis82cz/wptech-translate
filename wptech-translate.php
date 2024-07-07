<?php
ob_start(); // Start output buffering

/**
 * WPTech Translate
 *
 * @package       WPTECH
 * @since         1.0
 * @version       1.0
 *
 * @wordpress-plugin
 * Plugin Name:   WPTech Translate
 * Plugin URI:    https://wpress.tech/produkt/wptech-translate
 * Description:   Plugin, který přeloží podporované pluginy a šablony do češtiny a připraví se pro addon na překlad do slovenštiny.
 * Version:       1.0
 * Author:        WPTech
 * Author URI:    https://www.wpress.tech
 * Text Domain:   wptech-translate
 * Domain Path:   /languages
 * License:       GPLv3
 * License URI:   https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.0
 * Requires PHP: 7.2
 *
 * You should have received a copy of the GNU General Public License
 * along with WPTech Translate. If not, see <https://www.gnu.org/licenses/gpl-3.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

// Definice konstant pro plugin
define( 'WPTECH_NAME', 'WPTech Translate' );
define( 'WPTECH_VERSION', '1.0' );
define( 'WPTECH_PLUGIN_FILE', __FILE__ );
define( 'WPTECH_PLUGIN_BASE', plugin_basename( WPTECH_PLUGIN_FILE ) );
define( 'WPTECH_PLUGIN_DIR', plugin_dir_path( WPTECH_PLUGIN_FILE ) );
define( 'WPTECH_PLUGIN_URL', plugin_dir_url( WPTECH_PLUGIN_FILE ) );

/**
 * Load the correct class based on the site's locale
 */
$locale = get_locale();
if ($locale == 'cs_CZ') {
    require_once WPTECH_PLUGIN_DIR . 'core/class-wptech-translate-cz.php';
}

/**
 * The main function to load the only instance
 * of our master classes.
 */
function WPTECH_CZ() {
    return Wptech_Translate_CZ::instance();
}

if ($locale == 'cs_CZ') {
    WPTECH_CZ();
}

/**
 * Load additional functionalities
 */
require_once WPTECH_PLUGIN_DIR . 'core/create-admin-menu.php';
require_once WPTECH_PLUGIN_DIR . 'core/languages-support.php';
require_once WPTECH_PLUGIN_DIR . 'core/widget-info.php';

/**
 * Add meta links for Discord and Support
 */
add_filter( 'plugin_row_meta', 'wptech_translate_meta_links', 10, 2 );
function wptech_translate_meta_links( $links, $file ) {
    $plugin = plugin_basename(__FILE__);
    
    // Vytvoření odkazů
    if ( $file == $plugin ) {
        return array_merge(
            $links,
            array(
                '<a href="https://denis82cz.eu/pripojit-na-discord" title="Máte problém, nebo chcete další překlad?" target="_blank" style="color:#FF0000 !important; font-weight: bold;" aria-label="Discord">Discord</a>',
                '<a href="https://wpress.tech/podpora" title="Máte problém, nebo chcete další překlad?" target="_blank" style="color:#11D316 !important; font-weight: bold;" aria-label="Podpora">Podpora</a>'
            )
        );
    }
    return $links;
}

/**
 * Check conditional functions at the appropriate time
 */
add_action('wp', 'check_conditions');

function check_conditions() {
    if (is_embed() || is_search()) {
        // Your code here
    }
}
ob_end_flush(); // Flush the output buffer and turn off output buffering
?>