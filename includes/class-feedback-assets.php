<?

namespace CustomFeedback;

class FeedbackAssets {
    public static function init() {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
    }

    public static function enqueue_assets() {
        // custom css
        wp_enqueue_style(
            'custom-css',
            plugin_dir_url(__dir__) . 'assets/css/main.css',
            [], 
            '1.0.0'
        );

        // custom js
        wp_enqueue_script(
            'custom-js',
            plugin_dir_url(__dir__) . 'assets/js/script-min.js', 
            [], 
            '1.0.0',
            true
        );

        // variable to custom js file
        wp_localize_script('custom-js', 'feedbackFormData', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('feedback_form_nonce'),
        ]);
    }
}

FeedbackAssets::init();