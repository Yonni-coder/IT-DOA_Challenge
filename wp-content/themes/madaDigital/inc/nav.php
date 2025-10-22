<nav class="navbar" id="navbar">
        <div class="navbar-container container">
            <a href="<?php
                echo home_url('/')
            ;?>">
                <img 
                    src="<?php
                        echo get_template_directory_uri()
                    ;?>/assets/img/logo.png" 
                    alt="Mada Digital"
                    class="logo"
                >
            </a>

            <?php
                wp_nav_menu([
                    'theme_location' => 'Menu principal',
                    'items_wrap' => '<ul class="nav-menu">%$6s</ul>'
                ])
            ;?>

            <!-- <ul class="nav-menu">
                <li><a href="index.html" class="nav-link active"><span>Accueil</span></a></li>
                <li><a href="apropos.html" class="nav-link"><span>À propos</span></a></li>
                <li><a href="services.html" class="nav-link"><span>Services</span></a></li>
                <li><a href="realisations.html" class="nav-link"><span>Réalisations</span></a></li>
                <li><a href="evenements.html" class="nav-link"><span>Événements</span></a></li>
                <li><a href="faq.html" class="nav-link"><span>FAQ</span></a></li>
                <li><a href="contact.html" class="nav-link"><span>Contact</span></a></li>
                <li>
                    <button class="theme-toggle" id="themeToggle">
                        <i class="fas fa-moon"></i>
                    </button>
                </li>
            </ul> -->

            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <ul class="mobile-nav-menu">
                <li><a href="index.html" class="mobile-nav-link active">Accueil</a></li>
                <li><a href="apropos.html" class="mobile-nav-link">À propos</a></li>
                <li><a href="services.html" class="mobile-nav-link">Services</a></li>
                <li><a href="realisations.html" class="mobile-nav-link">Réalisations</a></li>
                <li><a href="evenements.html" class="mobile-nav-link">Événements</a></li>
                <li><a href="faq.html" class="mobile-nav-link">FAQ</a></li>
                <li><a href="contact.html" class="mobile-nav-link">Contact</a></li>
                <li>
                    <button class="theme-toggle mobile-theme-toggle" id="mobileThemeToggle" style="margin: 1rem 1.5rem;">
                        <i class="fas fa-moon"></i> Mode sombre
                    </button>
                </li>
            </ul>
        </div>
    </nav>