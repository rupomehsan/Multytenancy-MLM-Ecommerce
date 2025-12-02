<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>TPmart - Under Maintenance</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Preload critical fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --glass-bg: rgba(255, 255, 255, 0.95);
            --glass-border: rgba(255, 255, 255, 0.2);
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --text-muted: #718096;
            --shadow-soft: 0 10px 40px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 60px rgba(0, 0, 0, 0.15);
            --border-radius: 24px;
            --border-radius-small: 12px;
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 2rem;
            --spacing-xl: 3rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 16px;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--primary-gradient);
            min-height: 100vh;
            min-height: 100dvh; /* For mobile browsers */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            padding: var(--spacing-sm);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Enhanced animated background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            display: block;
            width: clamp(4px, 1vw, 8px);
            height: clamp(4px, 1vw, 8px);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .particle:nth-child(odd) {
            background: rgba(255, 255, 255, 0.05);
        }

        .particle:nth-child(1) { left: 5%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 15%; animation-delay: 1s; animation-duration: 8s; }
        .particle:nth-child(3) { left: 25%; animation-delay: 2s; animation-duration: 7s; }
        .particle:nth-child(4) { left: 35%; animation-delay: 3s; animation-duration: 9s; }
        .particle:nth-child(5) { left: 45%; animation-delay: 4s; animation-duration: 6s; }
        .particle:nth-child(6) { left: 55%; animation-delay: 5s; animation-duration: 8s; }
        .particle:nth-child(7) { left: 65%; animation-delay: 1.5s; animation-duration: 7s; }
        .particle:nth-child(8) { left: 75%; animation-delay: 2.5s; animation-duration: 9s; }
        .particle:nth-child(9) { left: 85%; animation-delay: 3.5s; animation-duration: 6s; }
        .particle:nth-child(10) { left: 95%; animation-delay: 4.5s; animation-duration: 8s; }

        @keyframes float {
            0%, 100% { 
                transform: translateY(100vh) rotate(0deg) scale(0); 
                opacity: 0; 
            }
            10% { 
                opacity: 1; 
                transform: translateY(90vh) rotate(45deg) scale(1); 
            }
            90% { 
                opacity: 0.8; 
                transform: translateY(-10vh) rotate(315deg) scale(1); 
            }
            100% { 
                transform: translateY(-100vh) rotate(360deg) scale(0); 
                opacity: 0; 
            }
        }

        /* Main container with enhanced responsiveness */
        .maintenance-container {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: clamp(var(--spacing-lg), 5vw, var(--spacing-xl));
            text-align: center;
            box-shadow: var(--shadow-soft);
            max-width: min(90vw, 600px);
            width: 100%;
            position: relative;
            z-index: 10;
            border: 1px solid var(--glass-border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .maintenance-container:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        /* Logo with responsive sizing */
        .logo {
            width: clamp(80px, 15vw, 120px);
            height: auto;
            margin: 0 auto var(--spacing-md);
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        /* Maintenance icon with better scaling */
        .maintenance-icon {
            font-size: clamp(3rem, 8vw, 5rem);
            color: #667eea;
            margin-bottom: var(--spacing-md);
            animation: pulse 2s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes pulse {
            0%, 100% { 
                transform: scale(1); 
                filter: drop-shadow(0 0 0 rgba(102, 126, 234, 0.4));
            }
            50% { 
                transform: scale(1.05); 
                filter: drop-shadow(0 0 20px rgba(102, 126, 234, 0.6));
            }
        }

        /* Typography with fluid scaling */
        h1 {
            color: var(--text-primary);
            font-size: clamp(1.75rem, 5vw, 2.5rem);
            font-weight: 700;
            margin-bottom: var(--spacing-sm);
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: clamp(1rem, 3vw, 1.25rem);
            font-weight: 500;
            margin-bottom: var(--spacing-md);
        }

        .description {
            color: var(--text-muted);
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            line-height: 1.6;
            margin-bottom: var(--spacing-lg);
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Enhanced progress bar */
        .progress-container {
            background: #e2e8f0;
            border-radius: 10px;
            height: clamp(6px, 1vw, 10px);
            margin: var(--spacing-md) 0;
            overflow: hidden;
            position: relative;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            background: var(--primary-gradient);
            height: 100%;
            border-radius: 10px;
            animation: progress 3s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s ease-in-out infinite;
        }

        @keyframes progress {
            0% { width: 0%; transform: translateX(0); }
            50% { width: 70%; }
            100% { width: 0%; transform: translateX(100px); }
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* ETA badge with enhanced styling */
        .eta {
            background: var(--primary-gradient);
            color: white;
            padding: var(--spacing-sm) var(--spacing-md);
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-xs);
            margin-top: var(--spacing-md);
            font-weight: 600;
            font-size: clamp(0.85rem, 2vw, 1rem);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .eta:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        /* Contact section with better mobile layout */
        .contact-info {
            margin-top: var(--spacing-lg);
            padding-top: var(--spacing-md);
            border-top: 1px solid #e2e8f0;
        }

        .contact-title {
            color: var(--text-secondary);
            font-size: clamp(0.9rem, 2.5vw, 1rem);
            font-weight: 600;
            margin-bottom: var(--spacing-sm);
        }

        .contact-details {
            display: flex;
            justify-content: center;
            gap: clamp(var(--spacing-sm), 4vw, var(--spacing-lg));
            flex-wrap: wrap;
            margin-bottom: var(--spacing-md);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            padding: var(--spacing-xs) var(--spacing-sm);
            border-radius: var(--border-radius-small);
            transition: all 0.3s ease;
            background: rgba(102, 126, 234, 0.05);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .contact-item:hover {
            color: #764ba2;
            transform: translateY(-2px);
            background: rgba(102, 126, 234, 0.1);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        /* Enhanced social media links */
        .social-links {
            display: flex;
            justify-content: center;
            gap: var(--spacing-sm);
            flex-wrap: wrap;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: clamp(40px, 8vw, 50px);
            height: clamp(40px, 8vw, 50px);
            background: var(--primary-gradient);
            color: white;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            font-size: clamp(1rem, 3vw, 1.2rem);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .social-link:hover {
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
            background: var(--secondary-gradient);
        }

        /* Mobile-first responsive breakpoints */
        @media (max-width: 480px) {
            body {
                padding: var(--spacing-xs);
            }
            
            .maintenance-container {
                border-radius: var(--spacing-md);
                margin: var(--spacing-xs);
            }
            
            .contact-details {
                flex-direction: column;
                gap: var(--spacing-sm);
            }
            
            .social-links {
                gap: var(--spacing-xs);
            }
            
            .eta {
                padding: var(--spacing-xs) var(--spacing-sm);
            }
        }

        @media (max-width: 360px) {
            .maintenance-container {
                padding: var(--spacing-md);
            }
            
            .contact-item {
                font-size: 0.8rem;
                padding: 6px 10px;
            }
        }

        /* Tablet optimizations */
        @media (min-width: 481px) and (max-width: 1024px) {
            .maintenance-container {
                max-width: 80vw;
            }
        }

        /* Desktop enhancements */
        @media (min-width: 1025px) {
            .maintenance-container {
                max-width: 600px;
            }
            
            .contact-details {
                gap: var(--spacing-xl);
            }
        }

        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .maintenance-container {
                border: 2px solid #000;
                background: #fff;
            }
            
            .contact-item {
                border: 2px solid #667eea;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            :root {
                --glass-bg: rgba(45, 55, 72, 0.95);
                --text-primary: #f7fafc;
                --text-secondary: #e2e8f0;
                --text-muted: #cbd5e0;
            }
        }

        /* Print styles */
        @media print {
            .particles,
            .social-links {
                display: none;
            }
            
            .maintenance-container {
                box-shadow: none;
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="particles" aria-hidden="true">
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
        <span class="particle"></span>
    </div>

    <main class="maintenance-container" role="main">
        <img src="{{ asset('logo.jpg') }}" alt="TPmart Logo" class="logo" loading="eager">
        
        <div class="maintenance-icon" aria-hidden="true">
            <i class="fas fa-tools"></i>
        </div>
        
        <h1>We'll Be Back Soon!</h1>
        <p class="subtitle">Site Under Maintenance</p>
        
        <p class="description">
            We're currently performing scheduled maintenance to improve your shopping experience. 
            We'll be back online shortly with exciting new features and improvements!
        </p>
        
        <div class="progress-container" role="progressbar" aria-label="Maintenance progress">
            <div class="progress-bar"></div>
        </div>
        
        <div class="eta">
            <i class="fas fa-clock" aria-hidden="true"></i>
            <span>Estimated completion: 2-4 hours</span>
        </div>
        
        <section class="contact-info">
            <h2 class="contact-title">Need immediate assistance?</h2>
            <div class="contact-details">
                <a href="mailto:support@tpmart.com" class="contact-item" aria-label="Email support">
                    <i class="fas fa-envelope" aria-hidden="true"></i>
                    <span>support@tpmart.com</span>
                </a>
                <a href="tel:+8801234567890" class="contact-item" aria-label="Call support">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    <span>+880 123 456 7890</span>
                </a>
            </div>
            
            <div class="social-links" role="list" aria-label="Social media links">
                <a href="https://facebook.com/tpmart" class="social-link" target="_blank" rel="noopener" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/tpmart" class="social-link" target="_blank" rel="noopener" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://instagram.com/tpmart" class="social-link" target="_blank" rel="noopener" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://linkedin.com/company/tpmart" class="social-link" target="_blank" rel="noopener" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </section>
    </main>

    <script>
        // Enhanced interactivity with performance optimizations
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-refresh with exponential backoff
            const refreshIntervals = [5, 10, 15, 30]; // minutes
            let currentIntervalIndex = 0;
            
            function scheduleRefresh() {
                const interval = refreshIntervals[Math.min(currentIntervalIndex, refreshIntervals.length - 1)];
                setTimeout(function() {
                    window.location.reload();
                }, interval * 60000);
                currentIntervalIndex++;
            }
            
            scheduleRefresh();
            
            // Optimized particle system
            const particles = document.querySelector('.particles');
            let particleCount = 0;
            const maxParticles = window.innerWidth < 768 ? 3 : 5;
            
            function createParticle() {
                if (particleCount >= maxParticles) return;
                
                const particle = document.createElement('span');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = '0s';
                particle.style.animationDuration = (Math.random() * 3 + 4) + 's';
                particles.appendChild(particle);
                particleCount++;
                
                // Remove particle after animation with cleanup
                setTimeout(function() {
                    if (particle.parentNode) {
                        particle.parentNode.removeChild(particle);
                        particleCount--;
                    }
                }, 8000);
            }
            
            // Throttled particle creation
            const particleInterval = window.innerWidth < 768 ? 2000 : 1200;
            setInterval(createParticle, particleInterval);
            
            // Enhanced accessibility
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (reduceMotion) {
                particles.style.display = 'none';
                document.querySelectorAll('.maintenance-icon, .progress-bar').forEach(el => {
                    el.style.animation = 'none';
                });
            }
            
            // Keyboard navigation for social links
            document.querySelectorAll('.social-link').forEach(link => {
                link.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        this.click();
                    }
                });
            });
            
            // Touch feedback for mobile
            if ('ontouchstart' in window) {
                document.querySelectorAll('.contact-item, .social-link').forEach(element => {
                    element.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.95)';
                    });
                    
                    element.addEventListener('touchend', function() {
                        this.style.transform = '';
                    });
                });
            }
            
            // Connection status monitoring
            function updateConnectionStatus() {
                if (!navigator.onLine) {
                    const eta = document.querySelector('.eta span');
                    if (eta) {
                        eta.textContent = 'Offline - Please check your connection';
                    }
                }
            }
            
            window.addEventListener('online', scheduleRefresh);
            window.addEventListener('offline', updateConnectionStatus);
            updateConnectionStatus();
        });
    </script>
</body>
</html>
