<?php
/**
 * Create Admin Menu
 *
 * @package WPTECH
 */

// Přidání hlavní stránky a podstránek do administrace WordPressu
function wptech_add_admin_menu() {
    // Hlavní stránka
    add_menu_page(
        'WPTech - Translate', // Název stránky
        'WPTech - Translate', // Název v menu
        'manage_options', // Schopnosti uživatele, které jsou nutné pro přístup
        'wptech-translate', // Slug stránky
        'wptech_main_page_content', // Callback funkce
        plugin_dir_url(__FILE__) . '../assets/icon.png', // Icon URL
        3 // Pozice v menu, set to 3 to appear right after Dashboard
    );

    // Podstránky
    // Podstránka, která směřuje na externí odkaz
    add_submenu_page(
        'wptech-translate', // Slug hlavní stránky
        'Žádost o překlad', // Název stránky
        '<a href="https://wpress.tech/nase-sluzby/wptech-preklady/poslat-zadost-o-preklad/" target="_blank">Žádost o překlad</a>', // Název v menu a externí odkaz
        'manage_options', // Schopnosti uživatele, které jsou nutné pro přístup
        'wptech-request-translation', // Slug stránky
        '__return_false' // Prázdná callback funkce
    );

    add_submenu_page(
        'wptech-translate', // Slug hlavní stránky
        'Přeložené pluginy a šablony', // Název stránky
        'Přeložené pluginy a šablony', // Název v menu
        'manage_options', // Schopnosti uživatele, které jsou nutné pro přístup
        'wptech-translated-plugins-themes', // Slug stránky
        'wptech_display_translated_plugins_themes' // Callback funkce
    );

    add_submenu_page(
        'wptech-translate', // Slug hlavní stránky
        'Kontakt', // Název stránky
        'Kontakt', // Název v menu
        'manage_options', // Schopnosti uživatele, které jsou nutné pro přístup
        'wptech-contact', // Slug stránky
        'wptech_display_contact' // Callback funkce
    );

    // Podstránka Doplňky
    add_submenu_page(
        'wptech-translate', // Slug hlavní stránky
        'Doplňky', // Název stránky
        'Doplňky', // Název v menu
        'manage_options', // Schopnosti uživatele, které jsou nutné pro přístup
        'addons', // Slug stránky
        'wptech_display_addons' // Callback funkce
    );
}
add_action('admin_menu', 'wptech_add_admin_menu');

// Přidání vlastního CSS pro změnu barvy hlavního menu a animaci ikony
function wptech_admin_menu_styles() {
    echo '
    <style>
        #adminmenu .toplevel_page_wptech-translate .wp-menu-name {
            color: #8EE4CB !important;
        }
        /* Animace pro ikonu */
        @keyframes wptech-pulse {
            0% {
                transform: scale(1);
                filter: hue-rotate(0deg);
            }
            50% {
                transform: scale(1.2);
                filter: hue-rotate(180deg);
            }
            100% {
                transform: scale(1);
                filter: hue-rotate(360deg);
            }
        }
        #adminmenu .toplevel_page_wptech-translate .wp-menu-image img {
            animation: wptech-pulse 1.5s infinite;
        }
    </style>';
}
add_action('admin_head', 'wptech_admin_menu_styles');

// Callback funkce pro obsah hlavní stránky
function wptech_main_page_content() {
    include(plugin_dir_path(__FILE__) . '../admin/pages/main-page.php');
}

// Callback funkce pro obsah stránky Přeložené pluginy a šablony
function wptech_display_translated_plugins_themes() {
    include(plugin_dir_path(__FILE__) . '../admin/pages/translated-plugins-themes.php');
}

// Callback funkce pro obsah stránky Kontakt
function wptech_display_contact() {
    include(plugin_dir_path(__FILE__) . '../admin/pages/contact.php');
}

// Callback funkce pro obsah stránky Doplňky
function wptech_display_addons() {
    include(plugin_dir_path(__FILE__) . '../admin/pages/addons.php');
}
?>
