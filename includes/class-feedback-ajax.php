<?php

namespace CustomFeedback;

class FeedbackAjax {
    public static function init() {
        // ajax for users
        add_action('wp_ajax_submit_feedback', [self::class, 'handle_feedback_submission']);
        add_action('wp_ajax_nopriv_submit_feedback', [self::class, 'handle_feedback_submission']);
    }

    public static function handle_feedback_submission() {
        // nonce
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'feedback_form_nonce')) {
            wp_send_json_error([
                'message' => __('Security check failed', 'feedback-form')
            ]);
        }

        // if empty
        if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
            wp_send_json_error([
                'message' => __('All fields are required.', 'feedback-form')
            ]);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_entries'; // table name

        // sanitize
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name  = sanitize_text_field($_POST['last_name']);
        $email      = sanitize_email($_POST['email']);
        $subject    = sanitize_text_field($_POST['subject']);
        $message    = sanitize_textarea_field($_POST['message']);

        // insert values to table 
        $inserted = $wpdb->insert($table_name, [
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'email'      => $email,
            'subject'    => $subject,
            'message'    => $message,
            'date_submitted' => current_time('mysql'),
        ]);
        
        if ($inserted === false) {
            // sql error log
            error_log('Błąd SQL: ' . $wpdb->last_error);
            wp_send_json_error([
                'message' => __('There was an error submitting your feedback', 'feedback-form')
            ]);
        }

        
        wp_send_json_success([
            'message' => __('Thank you for sending us your feedback', 'feedback-form')
        ]);


        error_log('Otrzymane dane: ' . print_r($_POST, true));

    }
}

// init
FeedbackAjax::init();
