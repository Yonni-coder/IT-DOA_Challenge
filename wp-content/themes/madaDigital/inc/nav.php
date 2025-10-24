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
            <div style="display: flex; align-items: center; gap: 3px; font-size: 1rem; justify-content: center;">
                <?php
                // Compter les annonces actives
                $today = current_time('Y-m-d');
                $annonces_count = new WP_Query([
                    'post_type' => 'annonce',
                    'posts_per_page' => -1,
                    'meta_query' => [
                        [
                            'key' => '_annonce_date_fin',
                            'value' => $today,
                            'compare' => '>=',
                            'type' => 'DATE'
                        ]
                    ],
                    'fields' => 'ids' // Optimisation : ne récupérer que les IDs
                ]);
                $count = $annonces_count->found_posts;
                wp_reset_postdata();
                ?>
                
                <a style="text-decoration: none; position: relative;" class="horn" href="<?= home_url("/nos-annonces/") ?>">
                    <i class="fas fa-bullhorn"></i>
                    <?php if ($count > 0) : ?>
                        <span class="annonce-badge"><?= $count ?></span>
                    <?php endif; ?>
                </a>
                
                <button style="font-size: 1rem;" class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
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

    <style>
        .horn {
            color: var(--foreground);
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            position: relative;
        }

        .horn:hover {
            background-color: var(--muted);
        }

        .annonce-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            min-width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            animation: pulse-badge 2s ease-in-out infinite;
        }

        @keyframes pulse-badge {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.6);
            }
        }

        /* Pour les grands nombres */
        .annonce-badge {
            min-width: 18px;
            padding: 0 5px;
            border-radius: 10px;
        }

        /* Badge responsive */
        @media (max-width: 768px) {
            .annonce-badge {
                font-size: 0.65rem;
                min-width: 16px;
                height: 16px;
                top: -3px;
                right: -3px;
            }
        }
    </style>