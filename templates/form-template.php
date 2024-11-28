<section class="feedback">
    <div class="container">
        <form id="feedback__form">
            <div class="feedback__row">
                <input type="text" name="first_name" placeholder="<?php _e('First Name', 'feedback-form'); ?>" required>
                <input type="text" name="last_name" placeholder="<?php _e('Last Name', 'feedback-form'); ?>" required>
            </div>
            <div class="feedback__row">
                <input type="email" name="email" placeholder="<?php _e('Email', 'feedback-form'); ?>" required>
                <input type="text" name="subject" placeholder="<?php _e('Subject', 'feedback-form'); ?>" required>
            </div>
            <div class="feedback__row feedback__row-last">


                <textarea name="message" placeholder="<?php _e('Message', 'feedback-form'); ?>" required></textarea>
                <button type="submit">
                    <?php _e('Submit', 'feedback-form'); ?>
                </button>
            </div>
            <input type="hidden" name="security" value="<?php echo wp_create_nonce('feedback_form_nonce'); ?>">
        </form>
    </div>
</section>