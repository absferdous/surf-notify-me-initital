<?php
abstract class SSN_Base_Popup {
    protected $debug;

    public function __construct($debugger) {
        $this->debug = $debugger;
    }

    public function register_hooks() {
        add_action('wp_footer', [$this, 'output_popup_html']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets() {
        wp_enqueue_script('ssn-popup-js', SSN_URL . 'assets/js/popup.js', [], SSN_VERSION, true);
        wp_enqueue_style('ssn-popup-css', SSN_URL . 'assets/css/admin.css', [], SSN_VERSION);
        $this->add_inline_styles();
    }

    protected function add_inline_styles() {
        $options = get_option('ssn_options', []);
        $bg_color = esc_attr($options['background_color'] ?? '#ffffff');
        $text_color = esc_attr($options['text_color'] ?? '#000000');
        $font_size = esc_attr($options['font_size'] ?? 16);
        $border_radius = esc_attr($options['border_radius'] ?? 5);

        $custom_css = "
            .ssn-popup {
                background-color: {$bg_color};
                color: {$text_color};
                font-size: {$font_size}px;
                border-radius: {$border_radius}px;
            }
        ";
        wp_add_inline_style('ssn-popup-css', $custom_css);
    }

    protected function get_popup_data_attributes() {
        $options = get_option('ssn_options', []);
        $position = esc_attr($options['position'] ?? 'bottom-left');
        $entrance = esc_attr($options['entrance_animation'] ?? 'slide-in');
        $exit = esc_attr($options['exit_animation'] ?? 'slide-out');
        $offset_x = esc_attr($options['offset_x'] ?? 20);
        $offset_y = esc_attr($options['offset_y'] ?? 20);

        return "
            data-position='{$position}'
            data-entrance='{$entrance}'
            data-exit='{$exit}'
            data-offset-x='{$offset_x}'
            data-offset-y='{$offset_y}'
        ";
    }

    abstract public function output_popup_html();
}
