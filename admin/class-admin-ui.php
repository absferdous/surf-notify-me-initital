<?php
class SSN_Admin_UI {
    private $debug;

    public function __construct($debugger) {
        $this->debug = $debugger;
    }

    public function register_hooks() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function add_admin_menu() {
        add_menu_page(
            'Surf Notify',
            'Smart Notify',
            'manage_options',
            'ssn-dashboard',
            [$this, 'render_admin_page'],
            'dashicons-megaphone',
            55
        );
        $this->debug->log("Admin menu added.");
    }

    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_ssn-dashboard' !== $hook) {
            return;
        }
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_script('ssn-admin-js', SSN_URL . 'assets/js/admin.js', ['jquery', 'wp-color-picker'], SSN_VERSION, true);
        wp_enqueue_style('ssn-admin-css', SSN_URL . 'assets/css/admin.css', [], SSN_VERSION);
    }

    public function register_settings() {
        register_setting('ssn_settings_group', 'ssn_options');
    }

    public function render_admin_page() {
        if (isset($_GET['settings-updated'])) {
            add_settings_error('ssn_messages', 'ssn_message', __('Settings Saved', 'ssn'), 'updated');
        }
        settings_errors('ssn_messages');
        ?>
        <div class="wrap ssn-wrap">
            <h1>Surf Smart Notify - Dashboard</h1>
            <form method="post" action="options.php">
                <?php settings_fields('ssn_settings_group'); ?>
                <?php $options = get_option('ssn_options', []); ?>
                
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Enable Sales Popup</th>
                        <td><input type="checkbox" name="ssn_options[enable_sales_popup]" value="1" <?php checked(1, $options['enable_sales_popup'] ?? 0, true); ?> /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enable Comments Popup</th>
                        <td><input type="checkbox" name="ssn_options[enable_comments_popup]" value="1" <?php checked(1, $options['enable_comments_popup'] ?? 0, true); ?> /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enable Social Proof Popup</th>
                        <td><input type="checkbox" name="ssn_options[enable_social_proof_popup]" value="1" <?php checked(1, $options['enable_social_proof_popup'] ?? 0, true); ?> /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enable Memory Bank Popup</th>
                        <td><input type="checkbox" name="ssn_options[enable_memory_bank_popup]" value="1" <?php checked(1, $options['enable_memory_bank_popup'] ?? 0, true); ?> /></td>
                    </tr>
                </table>

                <h2>Appearance Settings</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Background Color</th>
                        <td><input type="text" name="ssn_options[background_color]" value="<?= esc_attr($options['background_color'] ?? '#ffffff'); ?>" class="ssn-color-picker" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Text Color</th>
                        <td><input type="text" name="ssn_options[text_color]" value="<?= esc_attr($options['text_color'] ?? '#000000'); ?>" class="ssn-color-picker" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Font Size (px)</th>
                        <td><input type="number" name="ssn_options[font_size]" value="<?= esc_attr($options['font_size'] ?? 16); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Border Radius (px)</th>
                        <td><input type="number" name="ssn_options[border_radius]" value="<?= esc_attr($options['border_radius'] ?? 5); ?>" /></td>
                    </tr>
                </table>

                <h2>Sales Popup Settings</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Message Format</th>
                        <td>
                            <input type="text" name="ssn_options[sales_message_format]" value="<?= esc_attr($options['sales_message_format'] ?? '{{name}} just bought {{product}}'); ?>" class="regular-text" />
                            <p class="description">Use placeholders: {{name}}, {{product}}</p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Show Product Image</th>
                        <td><input type="checkbox" name="ssn_options[show_product_image]" value="1" <?php checked(1, $options['show_product_image'] ?? 0, true); ?> /></td>
                    </tr>
                </table>

                <h2>Placement & Animation</h2>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Position</th>
                        <td>
                            <select name="ssn_options[position]">
                                <option value="bottom-left" <?php selected($options['position'] ?? 'bottom-left', 'bottom-left'); ?>>Bottom Left</option>
                                <option value="bottom-right" <?php selected($options['position'] ?? '', 'bottom-right'); ?>>Bottom Right</option>
                                <option value="top-left" <?php selected($options['position'] ?? '', 'top-left'); ?>>Top Left</option>
                                <option value="top-right" <?php selected($options['position'] ?? '', 'top-right'); ?>>Top Right</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Entrance Animation</th>
                        <td>
                            <select name="ssn_options[entrance_animation]">
                                <option value="slide-in" <?php selected($options['entrance_animation'] ?? 'slide-in', 'slide-in'); ?>>Slide In</option>
                                <option value="fade-in" <?php selected($options['entrance_animation'] ?? '', 'fade-in'); ?>>Fade In</option>
                                <option value="zoom-in" <?php selected($options['entrance_animation'] ?? '', 'zoom-in'); ?>>Zoom In</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Exit Animation</th>
                        <td>
                            <select name="ssn_options[exit_animation]">
                                <option value="slide-out" <?php selected($options['exit_animation'] ?? 'slide-out', 'slide-out'); ?>>Slide Out</option>
                                <option value="fade-out" <?php selected($options['exit_animation'] ?? '', 'fade-out'); ?>>Fade Out</option>
                                <option value="zoom-out" <?php selected($options['exit_animation'] ?? '', 'zoom-out'); ?>>Zoom Out</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Offset X (px)</th>
                        <td><input type="number" name="ssn_options[offset_x]" value="<?= esc_attr($options['offset_x'] ?? 20); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Offset Y (px)</th>
                        <td><input type="number" name="ssn_options[offset_y]" value="<?= esc_attr($options['offset_y'] ?? 20); ?>" /></td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
        $this->debug->log("Admin page rendered.");
    }
}
