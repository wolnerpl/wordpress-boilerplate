<header class="header">
    <div class="container header__container">
        <div class="header__logo">
            <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else { 
            ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home" aria-label="Homepage">
                    <?php echo bloginfo('name'); ?>
                </a>
            <?php } ?>
        </div>
        <?php wp_nav_menu([
            'container' => 'nav',
            'container_class' => 'header__nav',
            'theme_location' => 'primary',
            'depth' => 2,
            ]); 
        ?>
    </div>
</header>