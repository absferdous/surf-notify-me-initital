<?php
require_once SSN_PATH . 'core/class-base-popup.php';

class SSN_Social_Proof_Popup extends SSN_Base_Popup {
    public function register_hooks() {
        parent::register_hooks();
        add_action('wp_head', [$this, 'track_product_view']);
    }

    public function track_product_view() {
        if (is_product()) {
            $product_id = get_the_ID();
            $views = get_post_meta($product_id, '_ssn_view_count', true);
            $views = $views ? (int)$views : 0;
            update_post_meta($product_id, '_ssn_view_count', $views + 1);
        }
    }

    public function output_popup_html() {
        if (!is_product()) return;

        $product_id = get_the_ID();
        $views = get_post_meta($product_id, '_ssn_view_count', true);

        if (!$views) return;
        ?>
        <div id="ssn-social-proof-popup" class="ssn-popup" <?= $this->get_popup_data_attributes(); ?>>
            👀 <?= esc_html($views); ?> people are viewing this product!
        </div>
        <?php
        $this->debug->log("Displayed social proof for product ID " . $product_id);
    }
}
