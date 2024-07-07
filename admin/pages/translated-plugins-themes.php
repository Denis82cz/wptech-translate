<div class="wrap">
    <h1>Přeložené pluginy a šablony</h1>

    <div class="nav-tab-wrapper">
        <a href="#translated-plugins" class="nav-tab nav-tab-active" id="tab-plugins">Přeložené pluginy</a>
        <a href="#translated-themes" class="nav-tab" id="tab-themes">Přeložené šablony</a>
    </div>

    <div id="translated-plugins" class="tab-content active">
        <h2>Přeložené pluginy</h2>
        <div class="translated-plugins">
            <?php
            // Načtení dat z JSON souboru
            $json_file = plugin_dir_path(__FILE__) . '../../assets/json/translated-items.json';
            if (file_exists($json_file)) {
                $json_data = file_get_contents($json_file);
                $translated_items = json_decode($json_data, true);

                if (isset($translated_items['plugins'])) {
                    foreach ($translated_items['plugins'] as $plugin) {
                        echo '<div class="translated-item">';
                        echo '<h3>' . esc_html($plugin['name']) . '</h3>';
                        
                        // Kontrola existence obrázku
                        $image_path = plugin_dir_path(WPTECH_PLUGIN_FILE) . $plugin['image'];
                        if (!file_exists($image_path)) {
                            $image_url = plugin_dir_url(WPTECH_PLUGIN_FILE) . 'assets/trans-images/noimage.png';
                        } else {
                            $image_url = plugin_dir_url(WPTECH_PLUGIN_FILE) . $plugin['image'];
                        }
                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($plugin['name']) . '">';
                        
                        echo '<p>' . esc_html($plugin['description']) . '</p>';
                        echo '<p><strong>Podpora překladu:</strong> ' . esc_html($plugin['translation_support']) . '</p>';
                        echo '<p><strong>Testováno na verzi:</strong> ' . esc_html($plugin['tested_version']) . '</p>';
                        echo '<p><strong>Poslední aktualizace:</strong> ' . esc_html($plugin['last_updated']) . '</p>';
                        if ($plugin['translation_status'] === '100%') {
                            echo '<p><strong>Stav překladu:</strong> <span class="translation-status-100">' . esc_html($plugin['translation_status']) . '</span></p>';
                            echo '<p class="translation-note">Pokud stále máte na šabloně nebo pluginu nepřeložený text a máte stejnou verzi, jako je námi testovaná, napište vývojáři dané šablony nebo pluginu.</p>';
                        } else {
                            echo '<p><strong>Stav překladu:</strong> ' . esc_html($plugin['translation_status']) . '</p>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>Žádné přeložené pluginy nebyly nalezeny.</p>';
                }
            } else {
                echo '<p>Soubor s přeloženými položkami nebyl nalezen.</p>';
            }
            ?>
        </div>
    </div>

    <div id="translated-themes" class="tab-content">
        <h2>Přeložené šablony</h2>
        <div class="translated-themes">
            <?php
            // Načtení dat z JSON souboru
            $json_file = plugin_dir_path(__FILE__) . '../../assets/json/translated-items.json';
            if (file_exists($json_file)) {
                $json_data = file_get_contents($json_file);
                $translated_items = json_decode($json_data, true);

                if (isset($translated_items['themes'])) {
                    foreach ($translated_items['themes'] as $theme) {
                        echo '<div class="translated-item">';
                        echo '<h3>' . esc_html($theme['name']) . '</h3>';
                        
                        // Kontrola existence obrázku
                        $image_path = plugin_dir_path(WPTECH_PLUGIN_FILE) . $theme['image'];
                        if (!file_exists($image_path)) {
                            $image_url = plugin_dir_url(WPTECH_PLUGIN_FILE) . 'assets/trans-images/noimage.png';
                        } else {
                            $image_url = plugin_dir_url(WPTECH_PLUGIN_FILE) . $theme['image'];
                        }
                        echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($theme['name']) . '">';
                        
                        echo '<p>' . esc_html($theme['description']) . '</p>';
                        echo '<p><strong>Podpora překladu:</strong> ' . esc_html($theme['translation_support']) . '</p>';
                        echo '<p><strong>Testováno na verzi:</strong> ' . esc_html($theme['tested_version']) . '</p>';
                        echo '<p><strong>Poslední aktualizace:</strong> ' . esc_html($theme['last_updated']) . '</p>';
                        if ($theme['translation_status'] === '100%') {
                            echo '<p><strong>Stav překladu:</strong> <span class="translation-status-100">' . esc_html($theme['translation_status']) . '</span></p>';
                            echo '<p class="translation-note">Pokud stále máte na šabloně nebo pluginu nepřeložený text a máte nainstalován poslední překlad, napište nám.</p>';
                        } else {
                            echo '<p><strong>Stav překladu:</strong> ' . esc_html($theme['translation_status']) . '</p>';
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>Žádné přeložené šablony nebyly nalezeny.</p>';
                }
            } else {
                echo '<p>Soubor s přeloženými položkami nebyl nalezen.</p>';
            }
            ?>
        </div>
    </div>
</div>

<style>
    .nav-tab-wrapper {
        margin-bottom: 20px;
    }
    .nav-tab {
        display: inline-block;
        padding: 10px 20px;
        cursor: pointer;
        background: #f1f1f1;
        margin-right: 5px;
        text-decoration: none;
        color: #0073aa;
    }
    .nav-tab-active {
        background: #0073aa;
        color: #fff;
    }
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
    }
    .translated-item {
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fff;
        border-radius: 5px;
    }
    .translated-item img {
        max-width: 100%;
        height: auto;
        display: block;
        margin-bottom: 10px;
    }
    .translation-status-100 {
        color: #28a745;
        font-weight: bold;
    }
    .translation-note {
        color: #dc3545;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.nav-tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                tabs.forEach(t => t.classList.remove('nav-tab-active'));
                contents.forEach(c => c.classList.remove('active'));

                tab.classList.add('nav-tab-active');
                document.querySelector(tab.getAttribute('href')).classList.add('active');
            });
        });
    });
</script>
