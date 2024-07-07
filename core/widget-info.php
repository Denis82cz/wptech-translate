<?php
/**
 * Register the dashboard widget.
 */
function wptech_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'wptech_info_widget',   // Widget slug.
        'WPTech podpora šablon a pluginů', // Title.
        'wptech_display_dashboard_widget' // Display function.
    );
}
add_action('wp_dashboard_setup', 'wptech_add_dashboard_widget' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function wptech_display_dashboard_widget() {
    $json_file_path = WPTECH_PLUGIN_DIR . 'assets/json/translated-items.json';

    if (!file_exists($json_file_path)) {
        echo '<p>Soubor s přeloženými položkami nebyl nalezen.</p>';
        return;
    }

    $translated_items = json_decode(file_get_contents($json_file_path), true);

    if ($translated_items === null) {
        echo '<p>Chyba při načítání dat z JSON souboru.</p>';
        return;
    }

    echo '<style>
        .supported {
            color: #28a745; /* Green */
        }
        .not-supported {
            text-decoration: line-through;
        }
        .not-supported-text {
            color: #dc3545; /* Red */
        }
        .checkbox-container {
            margin-bottom: 20px;
        }
        .checkbox-label {
            display: inline-block;
            margin-right: 15px;
        }
    </style>';

    echo '<div class="checkbox-container">
        <label class="checkbox-label"><input type="checkbox" name="option" value="2" onclick="toggleCheckbox(this)" checked> Zobrazit podporované</label>
        <label class="checkbox-label"><input type="checkbox" name="option" value="3" onclick="toggleCheckbox(this)"> Zobrazit nepodporované</label>
        <label class="checkbox-label"><input type="checkbox" name="option" value="1" onclick="toggleCheckbox(this)"> Zobrazit vše</label>
    </div>';

    echo '<h3>Podporované pluginy a šablony</h3>';
    $available_translations = wptech_get_available_translations();
    $installed_plugins = get_plugins();
    $installed_themes = wp_get_themes();

    echo '<ul id="plugin-theme-list">';

    if (isset($translated_items['plugins'])) {
        foreach ($installed_plugins as $plugin_file => $plugin_data) {
            $text_domain = $plugin_data['TextDomain'];
            $tested_version = 'Unknown';

            foreach ($translated_items['plugins'] as $plugin) {
                if ($plugin['text_domain'] === $text_domain) {
                    $tested_version = $plugin['tested_version'];
                    break;
                }
            }

            if (in_array($text_domain, $available_translations)) {
                echo '<li class="plugin supported-item">' . esc_html($plugin_data['Name']) . ' (Plugin) <span class="supported">(Podporováno) - Testováno až do verze: ' . esc_html($tested_version) . '</span></li>';
            } else {
                echo '<li class="plugin not-supported-item" style="display: none;">' . esc_html($plugin_data['Name']) . ' (Plugin) <span class="not-supported-text">(Nepodporováno)</span></li>';
            }
        }
    } else {
        echo '<p>Žádné přeložené pluginy nebyly nalezeny.</p>';
    }

    if (isset($translated_items['themes'])) {
        foreach ($installed_themes as $theme_slug => $theme_data) {
            $text_domain = $theme_data->get('TextDomain');
            $tested_version = 'Unknown';

            foreach ($translated_items['themes'] as $theme) {
                if ($theme['text_domain'] === $text_domain) {
                    $tested_version = $theme['tested_version'];
                    break;
                }
            }

            if (in_array($text_domain, $available_translations)) {
                echo '<li class="theme supported-item">' . esc_html($theme_data->get('Name')) . ' (Šablona) <span class="supported">(Podporováno) - Testováno až do verze: ' . esc_html($tested_version) . '</span></li>';
            } else {
                echo '<li class="theme not-supported-item" style="display: none;">' . esc_html($theme_data->get('Name')) . ' (Šablona) <span class="not-supported-text">(Nepodporováno)</span></li>';
            }
        }
    } else {
        echo '<p>Žádné přeložené šablony nebyly nalezeny.</p>';
    }

    echo '</ul>';

    // JavaScript function to ensure only one checkbox is checked at a time and to filter the list
    echo '<script>
        function toggleCheckbox(element) {
            var checkboxes = document.querySelectorAll("input[name=\'option\']");
            checkboxes.forEach((checkbox) => {
                if (checkbox !== element) {
                    checkbox.checked = false;
                }
            });

            var value = element.value;
            var items = document.querySelectorAll("#plugin-theme-list li");

            items.forEach((item) => {
                if (value == "1") {
                    item.style.display = "list-item";
                } else if (value == "2") {
                    if (item.classList.contains("supported-item")) {
                        item.style.display = "list-item";
                    } else {
                        item.style.display = "none";
                    }
                } else if (value == "3") {
                    if (item.classList.contains("not-supported-item")) {
                        item.style.display = "list-item";
                    } else {
                        item.style.display = "none";
                    }
                }
            });
        }

        // Initial display to show only supported items
        document.addEventListener("DOMContentLoaded", function() {
            var items = document.querySelectorAll("#plugin-theme-list li");
            items.forEach((item) => {
                if (!item.classList.contains("supported-item")) {
                    item.style.display = "none";
                }
            });
        });
    </script>';
}

/**
 * Get available translations from the translates directory.
 */
function wptech_get_available_translations() {
    $translation_files = glob(WPTECH_PLUGIN_DIR . 'translates/cz/*.mo');
    $text_domains = array();

    foreach ($translation_files as $file) {
        $file_name = basename($file, '.mo');
        $text_domains[] = str_replace('-cs_CZ', '', $file_name);
    }

    return $text_domains;
}
?>
