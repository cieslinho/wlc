<?php

namespace CustomFeedback;

class FeedbackFormBlock {
    public static function register() {
        register_block_type(plugin_dir_path(__FILE__) . '../blocks/feedback-form', [
            'render_callback' => [self::class, 'render_feedback_form'],
        ]);
    }

    public static function render_feedback_form($attributes) {
        ob_start();
        require plugin_dir_path(__FILE__) . '../templates/form-template.php';
        return ob_get_clean();
    }
}

class FeedbackListBlock {
    public static function register() {
        register_block_type(plugin_dir_path(__FILE__) . '../blocks/feedback-list', [
            'render_callback' => [self::class, 'render_feedback_list'],
        ]);
    }

    public static function render_feedback_list($attributes) {
        ob_start();
        require plugin_dir_path(__FILE__) . '../templates/feedback-list-template.php';
        return ob_get_clean();
    }
}
