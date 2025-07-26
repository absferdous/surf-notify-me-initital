<?php
require_once SSN_PATH . 'core/class-base-popup.php';

class SSN_Sales_Popup extends SSN_Base_Popup {
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
        $options = get_option('ssn_options', []);
        $show_image = !empty($options['show_product_image']);
        $message_format = $options['sales_message_format'] ?? '{{name}} just bought {{product}}';

        $name = $order->get_billing_first_name();
        $items = $order->get_items();
        $product_name = 'a product';
        $product_image_html = '';

        if (!empty($items)) {
            $first_item = array_shift($items);
            $product = $first_item->get_product();
            if ($product) {
                $product_name = $product->get_name();
                if ($show_image) {
                    $product_image_html = $product->get_image('thumbnail');
                }
            }
        }

        $message = str_replace(
            ['{{name}}', '{{product}}'],
            [esc_html($name), esc_html($product_name)],
            $message_format
        );
        ?>
        <div id="ssn-popup" class="ssn-popup" <?= $this->get_popup_data_attributes(); ?>>
            <?php if ($show_image && $product_image_html) : ?>
                <div class="ssn-product-image">
                    <?= $product_image_html; ?>
                </div>
            <?php endif; ?>
            <div class="ssn-popup-content">
                🔥 <?= $message; ?>
            </div>
        </div>
        <?php
        $this->debug->log("Displayed popup for order ID " . $order->get_id());
    }
}
