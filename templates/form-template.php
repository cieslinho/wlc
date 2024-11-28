<section class="form">
    <div class="container">
        <form class="feedback__form form__form" id="feedback-form">
            <div class="form__row">
                <input type="text" name="first_name" placeholder="<?php _e('First Name', 'feedback-form'); ?>" required>
                <input type="text" name="last_name" placeholder="<?php _e('Last Name', 'feedback-form'); ?>" required>
            </div>
            <div class="form__row">
                <input type="email" name="email" placeholder="<?php _e('Email', 'feedback-form'); ?>" required>
                <input type="text" name="subject" placeholder="<?php _e('Subject', 'feedback-form'); ?>" required>
            </div>
            <div class="form__row form__row-last">


                <textarea class="form__textarea" name="message" placeholder="<?php _e('Message', 'feedback-form'); ?>"
                    required></textarea>
                <button class="form__btn" type="submit">
                    <?php _e('Submit', 'feedback-form'); ?>
                </button>
            </div>
            <input type="hidden" name="security" value="<?php echo wp_create_nonce('feedback_form_nonce'); ?>">

        </form>
    </div>
</section>