<?php if (current_user_can('manage_options')) : ?>
<section class="feedback">
    <div class="container">
        <div class="feedback__list" id="feedback-list">
            <?php
        global $wpdb;
        $table_name = $wpdb->prefix . 'feedback_entries';
        $feedbacks = $wpdb->get_results("SELECT * FROM {$table_name} LIMIT 10");
        
        foreach ($feedbacks as $feedback) :
        ?>
            <div class="feedback__entry">
                <strong>
                    <?php echo esc_html($feedback->first_name . ' ' . $feedback->last_name); ?>
                </strong><br>
                <em>
                    <?php echo esc_html($feedback->subject); ?>
                </em>
                <div>
                    <a href="#" class="view-feedback" data-id="<?php echo $feedback->id; ?>">
                        <?php _e('View Details', 'feedback-form'); ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <p>
            <?php _e('You are not authorized to view the content of this page.', 'feedback-form'); ?>
        </p>
    </div>
</section>

<?php endif; ?>