<?

namespace CustomFeedback;

class FeedbackAssets {
    public static function init() {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
    }

    public static function enqueue_assets() {
        // custom css
        wp_enqueue_style(
            'custom-css',
            plugin_dir_url(__DIR__) . 'assets/css/main.css',
            [],
            '1.0.0'
        );

        // custom js
        wp_enqueue_script(
            'custom-js',
            plugin_dir_url(__DIR__) . 'assets/js/script-min.js',
            [],
            '1.0.0',
            true
        );

        // variables for js
        wp_localize_script('custom-js', 'feedbackFormData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('feedback_form_nonce'),
            'labels' => [
                'first_name' => __('First Name', 'feedback-form'),
                'last_name' => __('Last Name', 'feedback-form'),
                'email' => __('Email', 'feedback-form'),
                'subject' => __('Subject', 'feedback-form'),
                'message' => __('Message', 'feedback-form'),
            ],
        ]);        
    }
}

FeedbackAssets::init();
