<nav class="navbar" id="navbar">
        <div class="navbar-container container">
            <a href="<?php echo home_url('/'); ?>">
                <img 
                    src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"
                    data-logo-light="<?= get_template_directory_uri(); ?>/assets/img/logo.png"
                    data-logo-dark="<?= get_template_directory_uri(); ?>/assets/img/logo.dark.mode.png"
                    alt="Mada Digital"
                    class="logo logo-footer"
                >
            </a>

            <?php
                wp_nav_menu([
                    'theme_location' => 'Menu principal',
                    'container' => false,
                    'items_wrap' => '<ul class="nav-menu">%3$s</ul>',
                    'link_before' => '<span>',
                    'link_after' => '</span>'
                ]);
            ?>
            <button class="theme-toggle" id="themeToggle">
                <i class="fas fa-moon"></i>
            </button>
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <?php
                wp_nav_menu([
                    'theme_location' => 'Menu mobile',
                    'container' => false,
                    'items_wrap' => '<ul class="mobile-nav-menu">%3$s</ul>',
                    'fallback_cb' => false
                ]);
            ?>
        </div>
    </nav>