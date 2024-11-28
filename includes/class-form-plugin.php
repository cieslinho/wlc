<?php

namespace CustomFeedback;

class FeedbackPlugin {

    // init
    public static function init() {
        add_action('init', [self::class, 'load_textdomain']);
        add_action('init', [self::class, 'register_blocks']);
        add_action('plugins_loaded', [self::class, 'setup_database']);
        FeedbackAjax::init();
    }

    // translation

    public static function load_textdomain() {
        load_plugin_textdomain('feedback-form', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    // register blocks

    public static function register_blocks() {
        FeedbackFormBlock::register();
        FeedbackListBlock::register();
    }


    // db action
    public static function setup_database() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_entries';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table_name} (
            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            date_submitted DATETIME DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";

        dbDelta($sql);
    }
}