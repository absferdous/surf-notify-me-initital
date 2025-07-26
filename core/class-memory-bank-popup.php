<?php
require_once SSN_PATH . 'core/class-base-popup.php';

class SSN_Memory_Bank_Popup extends SSN_Base_Popup {
    private $memories = [
        "A beautiful memory is a treasure that you can keep forever.",
        "The best things in life are the people we love, the places we've been, and the memories we've made along the way.",
        "Memory is a way of holding onto the things you love, the things you are, the things you never want to lose.",
        "Sometimes you will never know the true value of a moment until it becomes a memory.",
        "Good times become good memories and bad times become good lessons."
    ];

    public function output_popup_html() {
        $memory = $this->memories[array_rand($this->memories)];
        ?>
        <div id="ssn-memory-bank-popup" class="ssn-popup" <?= $this->get_popup_data_attributes(); ?>>
            🧠 <?= esc_html($memory); ?>
        </div>
        <?php
        $this->debug->log("Displayed memory bank popup.");
    }
}
