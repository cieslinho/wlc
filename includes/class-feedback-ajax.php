<?php

namespace CustomFeedback;

class FeedbackAjax {
    public static function init() {
        // ajax for specific user roles
        add_action('wp_ajax_submit_feedback', [self::class, 'handle_feedback_submission']);
        add_action('wp_ajax_nopriv_submit_feedback', [self::class, 'handle_feedback_submission']);
    }

    public static function handle_feedback_submission() {
        
        check_ajax_referer('feedback_form_nonce', 'security');

        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_entries';

      // sanitize 
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name  = sanitize_text_field($_POST['last_name']);
        $email      = sanitize_email($_POST['email']);
        $subject    = sanitize_text_field($_POST['subject']);
        $message    = sanitize_textarea_field($_POST['message']);

        // insert to db
        $wpdb->insert($table_name, [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'subject'    => $subject,
            'message'    => $message,
        ]);

        // msg
        wp_send_json_success([
            'message' => __('Thank you for sending us your feedback', 'feedback-form')
        ]);
    }
}
