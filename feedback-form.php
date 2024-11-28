<?php
/**
 * Plugin Name: Feedback form plugin
 * Description: A plugin to submit feedback via a Gutenberg blocks and display it to users with admin privilages.
 * Version: 1.0
 * Author: Szymon Cieśla
 * Text Domain: feedback form plugin
 * Domain Path: /languages
 */

 defined('ABSPATH') || exit;

require_once plugin_dir_path(__FILE__) . 'includes/class-form-plugin.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-feedback-assets.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-feedback-blocks.php';
require_once plugin_dir_path(__FILE__) . 'includes/class-feedback-ajax.php';



use CustomFeedback\FeedbackPlugin;

FeedbackPlugin::init();



