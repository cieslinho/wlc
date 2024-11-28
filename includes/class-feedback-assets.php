<?php

namespace CustomFeedback;

class FeedbackAssets {
    public static function init() {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_assets']);
        add_action('admin_enqueue_scripts', [self::class, 'enqueue_assets']);
    }

    public static function enqueue_assets() {
        // css
        wp_enqueue_style(
            'feedback-shared-style',
            plugin_dir_url(__FILE__) . '../assets/css/main.css',
            [],
            '1.0.0'
        );

        // js 
        wp_enqueue_script(
            'feedback-shared-script',
            plugin_dir_url(__FILE__) . '../assets/js/main.js',
            [],
            '1.0.0',
            true
        );

        // js dynamic data
        wp_localize_script('feedback-script', 'FeedbackData', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('feedback_nonce'),
        ]);
    }
}
