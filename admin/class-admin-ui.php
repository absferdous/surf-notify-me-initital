<?php
class SSN_Admin_UI {
    private $debug;

    public function __construct($debugger) {
        $this->debug = $debugger;
    }

    public function register_hooks() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
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

    public function enqueue_admin_assets() {
        wp_enqueue_style('ssn-admin-css', SSN_URL . 'assets/css/admin.css', [], SSN_VERSION);
    }

    public function render_admin_page() {
        ?>
        <div class="wrap ssn-wrap">
            <h1>Surf Smart Notify - Dashboard</h1>
            <div class="card">
                <h2>✅ Recent Sales Popup</h2>
                <p>This module is active and showing notifications on the frontend.</p>
            </div>
        </div>
        <?php
        $this->debug->log("Admin page rendered.");
    }
}