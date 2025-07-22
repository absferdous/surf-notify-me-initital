<?php
class SSN_Debugger {
    public function log($msg) {
        if (defined('WP_DEBUG') && WP_DEBUG === true) {
            error_log('[SSN Debug] ' . $msg);
        }
    }
}