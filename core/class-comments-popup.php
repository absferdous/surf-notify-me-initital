<?php
require_once SSN_PATH . 'core/class-base-popup.php';

class SSN_Comments_Popup extends SSN_Base_Popup {
    public function output_popup_html() {
        $comments = get_comments([
            'number' => 1,
            'status' => 'approve',
            'orderby' => 'comment_date',
            'order' => 'DESC'
        ]);

        if (empty($comments)) return;

        $comment = $comments[0];
        $commenter_name = $comment->comment_author;
        ?>
        <div id="ssn-comment-popup" class="ssn-popup" <?= $this->get_popup_data_attributes(); ?>>
            💬 <?= esc_html($commenter_name); ?> just left a comment!
        </div>
        <?php
        $this->debug->log("Displayed popup for comment ID " . $comment->comment_ID);
    }
}
