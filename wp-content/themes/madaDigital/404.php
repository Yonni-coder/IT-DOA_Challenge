<?php
/**
 * Template Name: 404 Page
 * Description: Beautiful 404 error page with animations
 */
get_header();
?>

<div class="error-404-container">
    <div class="error-content">
        <!-- Animated 404 Number -->
        <div class="error-number">
            <span class="number-4 glitch" data-text="4">4</span>
            <span class="number-0 floating">
                <svg viewBox="0 0 200 200" class="floating-circle">
                    <circle cx="100" cy="100" r="80" fill="none" stroke="currentColor" stroke-width="3"/>
                    <circle cx="100" cy="100" r="60" fill="none" stroke="currentColor" stroke-width="2" opacity="0.5"/>
                    <circle cx="100" cy="100" r="40" fill="none" stroke="currentColor" stroke-width="1" opacity="0.3"/>
                </svg>
            </span>
            <span class="number-4 glitch" data-text="4">4</span>
        </div>

        <!-- Floating particles -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <!-- Error message -->
        <h1 class="error-title">
            <span class="title-word">Page</span>
            <span class="title-word">Non</span>
            <span class="title-word">Trouvée</span>
        </h1>
        
        <p class="error-description">
            Oups ! La page que vous recherchez semble s'être perdue dans l'espace digital.
        </p>

        <!-- Action buttons -->
        <div class="error-actions">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
                <span>Retour à l'accueil</span>
            </a>
            <button onclick="window.history.back()" class="btn btn-secondary">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Page précédente</span>
            </button>
        </div>

        <!-- Helpful links -->
        <div class="helpful-links">
            <h3>Liens utiles :</h3>
            <ul>
                <li><a href="<?php echo esc_url(home_url('/services')); ?>">Nos Services</a></li>
                <li><a href="<?php echo esc_url(home_url('/realisations')); ?>">Nos Réalisations</a></li>
                <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Nous Contacter</a></li>
            </ul>
        </div>
    </div>
</div>

<style>
.error-404-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6rem 1rem 4rem;
    position: relative;
    overflow: hidden;
    background: var(--background);
}

.error-404-container::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at center, hsla(25, 95%, 53%, 0.1), transparent 70%);
    animation: pulse-bg 8s ease-in-out infinite;
}

@keyframes pulse-bg {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.1); }
}

.error-content {
    position: relative;
    z-index: 10;
    text-align: center;
    max-width: 800px;
    margin: 0 auto;
}

/* Animated 404 Number */
.error-number {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
    font-size: clamp(6rem, 15vw, 12rem);
    font-weight: 900;
    line-height: 1;
}

.number-4 {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: slide-in 1s ease-out;
}

.number-4:first-child {
    animation-delay: 0.2s;
    opacity: 0;
    animation-fill-mode: forwards;
}

.number-4:last-child {
    animation-delay: 0.4s;
    opacity: 0;
    animation-fill-mode: forwards;
}

@keyframes slide-in {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Glitch effect */
.glitch {
    position: relative;
}

.glitch::before,
.glitch::after {
    content: attr(data-text);
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    opacity: 0.8;
}

.glitch::before {
    animation: glitch-1 2.5s infinite;
    clip-path: polygon(0 0, 100% 0, 100% 45%, 0 45%);
    transform: translateX(-3px);
    filter: hue-rotate(-20deg);
}

.glitch::after {
    animation: glitch-2 2.5s infinite;
    clip-path: polygon(0 55%, 100% 55%, 100% 100%, 0 100%);
    transform: translateX(3px);
    filter: hue-rotate(20deg);
}

@keyframes glitch-1 {
    0%, 90%, 100% { transform: translateX(0); }
    91% { transform: translateX(-5px); }
    92% { transform: translateX(5px); }
    93% { transform: translateX(-5px); }
}

@keyframes glitch-2 {
    0%, 90%, 100% { transform: translateX(0); }
    91% { transform: translateX(5px); }
    92% { transform: translateX(-5px); }
    93% { transform: translateX(5px); }
}

/* Floating circle */
.number-0 {
    position: relative;
    display: inline-block;
    animation: float 3s ease-in-out infinite;
    opacity: 0;
    animation-delay: 0.3s;
    animation-fill-mode: forwards;
}

.floating-circle {
    width: clamp(4rem, 10vw, 8rem);
    height: clamp(4rem, 10vw, 8rem);
    color: var(--primary);
}

.floating-circle circle:nth-child(1) {
    animation: rotate 20s linear infinite;
    transform-origin: center;
}

.floating-circle circle:nth-child(2) {
    animation: rotate 15s linear infinite reverse;
    transform-origin: center;
}

.floating-circle circle:nth-child(3) {
    animation: rotate 10s linear infinite;
    transform-origin: center;
}

@keyframes float {
    0% { 
        opacity: 0;
        transform: translateY(20px); 
    }
    100% { 
        opacity: 1;
        transform: translateY(0); 
    }
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Particles */
.particles {
    position: absolute;
    inset: 0;
    pointer-events: none;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: var(--primary);
    border-radius: 50%;
    opacity: 0.6;
    animation: particle-float 4s ease-in-out infinite;
}

.particle:nth-child(1) {
    left: 10%;
    top: 20%;
    animation-delay: 0s;
}

.particle:nth-child(2) {
    left: 80%;
    top: 30%;
    animation-delay: 1s;
}

.particle:nth-child(3) {
    left: 30%;
    top: 70%;
    animation-delay: 2s;
}

.particle:nth-child(4) {
    left: 70%;
    top: 60%;
    animation-delay: 1.5s;
}

.particle:nth-child(5) {
    left: 50%;
    top: 40%;
    animation-delay: 0.5s;
}

.particle:nth-child(6) {
    left: 20%;
    top: 80%;
    animation-delay: 2.5s;
}

@keyframes particle-float {
    0%, 100% {
        transform: translateY(0) scale(1);
        opacity: 0.6;
    }
    50% {
        transform: translateY(-30px) scale(1.5);
        opacity: 1;
    }
}

/* Error title */
.error-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    margin-bottom: 1rem;
    opacity: 0;
    animation: fade-in-up 0.8s ease-out 0.6s forwards;
}

.title-word {
    display: inline-block;
    animation: bounce-in 0.6s ease-out;
}

.title-word:nth-child(1) {
    animation-delay: 0.7s;
    opacity: 0;
    animation-fill-mode: forwards;
}

.title-word:nth-child(2) {
    animation-delay: 0.85s;
    opacity: 0;
    animation-fill-mode: forwards;
}

.title-word:nth-child(3) {
    animation-delay: 1s;
    opacity: 0;
    animation-fill-mode: forwards;
}

@keyframes bounce-in {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Error description */
.error-description {
    font-size: 1.25rem;
    color: var(--muted-foreground);
    margin-bottom: 3rem;
    opacity: 0;
    animation: fade-in-up 0.8s ease-out 1.2s forwards;
}

/* Action buttons */
.error-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 3rem;
    opacity: 0;
    animation: fade-in-up 0.8s ease-out 1.4s forwards;
}

/* Helpful links */
.helpful-links {
    opacity: 0;
    animation: fade-in-up 0.8s ease-out 1.6s forwards;
}

.helpful-links h3 {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    color: var(--muted-foreground);
}

.helpful-links ul {
    list-style: none;
    display: flex;
    gap: 2rem;
    justify-content: center;
    flex-wrap: wrap;
}

.helpful-links a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    position: relative;
    transition: all 0.3s;
}

.helpful-links a::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    transition: width 0.3s;
}

.helpful-links a:hover {
    color: var(--accent);
}

.helpful-links a:hover::after {
    width: 100%;
}

/* Responsive */
@media (max-width: 768px) {
    .error-number {
        gap: 0.5rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .helpful-links ul {
        flex-direction: column;
        gap: 1rem;
    }
}

/* Dark mode adjustments */
.dark .glitch::before,
.dark .glitch::after {
    background: linear-gradient(135deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>

<?php get_footer(); ?>