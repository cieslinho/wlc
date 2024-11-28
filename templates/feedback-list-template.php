<?php
if (current_user_can('manage_options')) : ?>
<section class="feedback">
    <div class="container">
        <div class="feedback__list" id="feedback-list">
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'feedback_entries';

            // current page number
            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
            $offset = ($page - 1) * 10; // max feedback per page 

            // get feedback from db
            $feedbacks = $wpdb->get_results("SELECT * FROM {$table_name} LIMIT 10 OFFSET {$offset}");

            foreach ($feedbacks as $feedback) :
            ?>
            <div class="feedback__entry">
                <p class="feedback__name">
                    <?php echo esc_html($feedback->first_name . ' ' . $feedback->last_name); ?>
                </p>
                <p class="feedback__subject">
                
                    <?php echo esc_html($feedback->subject); ?>
                
                </p>
                
                    <button class="feedback__btn view-feedback" data-id="<?php echo $feedback->id; ?>">
                        <?php _e('View Details', 'feedback-form'); ?>
                    </button>
                
            </div>
            <?php endforeach; ?>
        </div>

        <div class="feedback__pagination">
            <?php
            // all feedbacks
            $total_feedbacks = $wpdb->get_var("SELECT COUNT(*) FROM {$table_name}");
            $total_pages = ceil($total_feedbacks / 10); // 10 feedbacks per page

            // pagination
            if ($page > 1) {
                echo '<button class="pagination__prev" data-page="' . ($page - 1) . '">Previous</button>';
            }

            if ($page < $total_pages) {
                echo '<button class="pagination__next" data-page="' . ($page + 1) . '">Next</button>';
            }
            ?>
        </div>

        
        <div class="feedback__details" id="feedback-details" style="display:none;">
            <h3><?php _e('Feedback Details', 'feedback-form'); ?></h3>
            <div class="feedback__details-content" id="feedback-details-content"></div>
        </div>
    </div>
</section>

<?php else : ?>
<p>
    <?php _e('You are not authorized to view the content of this page.', 'feedback-form'); ?>
</p>
<?php endif; ?>
