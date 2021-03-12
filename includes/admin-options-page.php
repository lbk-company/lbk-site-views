<div id="lbkcv" class="wrap">
    <h1><?php _e('LBK Count View Site', 'lbk-cv'); ?></h1>

    <div class="lbk card user-manual">
        <h2><?php _e( 'User manual', 'lbk-cv'); ?></h2>
        <p>Copy and paste the shortcode in the location where you want it displayed.</p>
        <p><span>[lbk_today_views]</span> : show views for today</p>
        <p><span>[lbk_total_views]</span> : show total views</p>
    </div>

    <form method="post" id="lbk-cv__options-form" action="options.php">
        <div class="lbk card">
            <h2><?php _e( 'Style List', 'lbk-cv' ); ?></h2>
            <label for="cv_style-default">
                <img src="<?php echo LBK_CV_URL.'images/style-default.jpg'; ?>" class="cv-style-img">
                <input type="radio" name="cv_style" id="style-default" value="default" <?php if (get_option('cv_style') == 'default') echo 'checked';?> >
                <span>Default</span>
            </label>
            <?php if(false) : ?>
            <?php foreach(range(1,2) as $i) : ?>
                <label for="cv_style<?php echo $i ?>">
                    <img src="<?php echo LBK_CV_URL.'images/style-'.$i.'.jpg'; ?>" alt="<?php echo 'style-'.$i; ?>" class="cv-style-img">
                    <input type="radio" name="cv_style" id="style-<?php echo $i; ?>" value="<?php echo $i; ?>" <?php if (get_option('cv_style') == $i) echo 'checked';?> >
                    <span><?php echo $i; ?></span>
                </label>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <?php settings_fields( 'lbk_cv_settings' ) ?>
        <?php do_settings_sections( 'lbk_cv_settings' ); ?>
        <?php submit_button( __( 'Save Changes', 'lbk-cv' ) ); ?>
    </form>
</div>