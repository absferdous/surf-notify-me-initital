<?php
class SSN_Sales_Popup {
    private $debug;

    public function __construct($debugger) {
        $this->debug = $debugger;
    }

    public function register_hooks() {
        add_action('wp_footer', [$this, 'output_popup_html']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function enqueue_assets() {
        wp_enqueue_script('ssn-popup-js', SSN_URL . 'assets/js/popup.js', [], SSN_VERSION, true);
    }

    public function output_popup_html() {
        if (!class_exists('WooCommerce')) {
            $this->debug->log('WooCommerce not active.');
            return;
        }

        $orders = wc_get_orders([
            'limit' => 1,
            'orderby' => 'date_created',
            'order' => 'DESC'
        ]);

        if (empty($orders)) return;

        $order = $orders[0];
        $name = $order->get_billing_first_name();
        ?>
        <div id="ssn-popup" class="ssn-popup">
            🔥 <?= esc_html($name); ?> just made a purchase!
        </div>
        <?php
        $this->debug->log("Displayed popup for order ID " . $order->get_id());
    }
}