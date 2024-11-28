<?php

namespace CustomFeedback;

class FeedbackAjax {
    public static function init() {
        // ajax for users
        add_action('wp_ajax_submit_feedback', [self::class, 'handle_feedback_submission']);
        add_action('wp_ajax_nopriv_submit_feedback', [self::class, 'handle_feedback_submission']);

        // ajax for pagination
        add_action('wp_ajax_load_feedbacks', [self::class, 'load_feedbacks']);
        add_action('wp_ajax_nopriv_load_feedbacks', [self::class, 'load_feedbacks']);

        // ajax for feedback details
        add_action('wp_ajax_load_feedback_details', [self::class, 'load_feedback_details']);
        add_action('wp_ajax_nopriv_load_feedback_details', 'load_feedback_details_callback');

    }

    public static function handle_feedback_submission() {
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'feedback_form_nonce')) {
            wp_send_json_error(['message' => __('Security check failed', 'feedback-form')]);
        }

        if (empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
            wp_send_json_error(['message' => __('All fields are required.', 'feedback-form')]);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_entries';

        $inserted = $wpdb->insert($table_name, [
            'first_name'     => sanitize_text_field($_POST['first_name']),
            'last_name'      => sanitize_text_field($_POST['last_name']),
            'email'          => sanitize_email($_POST['email']),
            'subject'        => sanitize_text_field($_POST['subject']),
            'message'        => sanitize_textarea_field($_POST['message']),
            'date_submitted' => current_time('mysql'),
        ]);

        if ($inserted === false) {
            error_log('Błąd SQL: ' . $wpdb->last_error);
            wp_send_json_error(['message' => __('There was an error submitting your feedback', 'feedback-form')]);
        }

        wp_send_json_success(['message' => __('Thank you for sending us your feedback', 'feedback-form')]);
    }

    public static function load_feedbacks() {
        if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'feedback_form_nonce')) {
            wp_send_json_error(['message' => __('Security check failed', 'feedback-form')]);
        }

        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_entries';

        $page = isset($_POST['page']) ? max(1, intval($_POST['page'])) : 1; // check if first page
        $items_per_page = 10;
        $offset = ($page - 1) * $items_per_page;

        // Pobieranie feedbacków
        $feedbacks = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$table_name} LIMIT %d OFFSET %d",
            $items_per_page,
            $offset
        ));

        // html output
        $output = '';
        foreach ($feedbacks as $feedback) {
            $output .= '<div class="feedback__entry">
                            <p class="feedback__name">' . esc_html($feedback->first_name . ' ' . $feedback->last_name) . '</p>
                            <p class="feedback__subject">' . esc_html($feedback->subject) . '</p>
                            <button class="feedback__btn view-feedback" data-id="' . esc_attr($feedback->id) . '">' . __('View Details', 'feedback-form') . '</button>
                        </div>';
        }

        // all feedback list
        $total_feedbacks = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
        $total_pages = ceil($total_feedbacks / $items_per_page);

        wp_send_json_success([
            'feedbacks' => $output ?: '<p>' . __('No feedbacks available.', 'feedback-form') . '</p>',
            'pagination' => [
                'total_pages' => $total_pages,
                'current_page' => $page,
                'has_next' => $page < $total_pages,
                'has_prev' => $page > 1,
            ],
        ]);
    }

    function load_feedback_details() {
        // check if feedback id is accurate 
        if (!isset($_POST['feedback_id']) || empty($_POST['feedback_id'])) {
            wp_send_json_error(['message' => 'Invalid feedback ID']);
        }
    
        global $wpdb;
        $feedback_id = intval($_POST['feedback_id']);
    
        // sql inquiry to download data/meta values from wp_feedback_entries
        $feedback = $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}feedback_entries WHERE id = %d", 
            $feedback_id
        ));
    
        // check if data is available
        if ($feedback) {
        
            wp_send_json_success([
                'first_name' => $feedback->first_name,
                'last_name' => $feedback->last_name,
                'email' => $feedback->email,
                'subject' => $feedback->subject,
                'message' => $feedback->message,
            ]);
        } else {
            wp_send_json_error(['message' => 'Feedback not found']);
        }
    }
    
    
}

// init
FeedbackAjax::init();
