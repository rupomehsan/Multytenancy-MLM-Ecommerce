<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>404 - Page Not Found | TPmart</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Preload fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-light: #9ca3af;
            --white: #ffffff;
            --surface: rgba(255, 255, 255, 0.95);
            --border-radius: 20px;
            --shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
            font-family: 'Poppins', sans-serif;
            background: var(--background);
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            padding: 1rem;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Animated background elements */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 60px;
            height: 60px;
            background: var(--accent-color);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape-2 {
            top: 20%;
            right: 15%;
            width: 80px;
            height: 80px;
            background: var(--success-color);
            border-radius: 20px;
            animation-delay: 1s;
            animation-duration: 8s;
        }

        .shape-3 {
            bottom: 20%;
            left: 15%;
            width: 100px;
            height: 100px;
            background: var(--danger-color);
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
            animation-delay: 2s;
            animation-duration: 10s;
        }

        .shape-4 {
            bottom: 15%;
            right: 20%;
            width: 70px;
            height: 70px;
            background: var(--secondary-color);
            border-radius: 50%;
            animation-delay: 3s;
            animation-duration: 7s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        /* Main container */
        .error-container {
            background: var(--surface);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: clamp(2rem, 5vw, 3rem);
            text-align: center;
            box-shadow: var(--shadow);
            max-width: min(90vw, 800px);
            width: 100%;
            position: relative;
            z-index: 10;
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color), var(--accent-color));
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        /* Logo */
        .logo {
            width: clamp(80px, 12vw, 100px);
            height: auto;
            margin: 0 auto 2rem;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
            transition: var(--transition);
        }

        .logo:hover {
            transform: scale(1.05) rotate(5deg);
        }

        /* Animated 404 character */
        .error-animation {
            position: relative;
            margin: 2rem auto;
            width: clamp(250px, 40vw, 400px);
            height: clamp(200px, 30vw, 300px);
        }

        .error-number {
            font-size: clamp(4rem, 15vw, 8rem);
            font-weight: 800;
            color: transparent;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            position: relative;
            display: inline-block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-20px); }
            60% { transform: translateY(-10px); }
        }

        /* Cartoon character */
        .cartoon-character {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 150px;
            height: 150px;
            z-index: 5;
        }

        .character-body {
            width: 80px;
            height: 100px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border-radius: 50px 50px 20px 20px;
            position: relative;
            margin: 0 auto;
            animation: wiggle 3s ease-in-out infinite;
        }

        .character-head {
            width: 60px;
            height: 60px;
            background: #ffeaa7;
            border-radius: 50%;
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            border: 3px solid var(--white);
        }

        .character-eyes {
            position: absolute;
            top: 15px;
            width: 100%;
        }

        .eye {
            width: 12px;
            height: 12px;
            background: var(--text-primary);
            border-radius: 50%;
            position: absolute;
            animation: blink 3s ease-in-out infinite;
        }

        .eye.left { left: 15px; }
        .eye.right { right: 15px; }

        .character-mouth {
            position: absolute;
            top: 35px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 10px;
            border: 2px solid var(--text-primary);
            border-top: none;
            border-radius: 0 0 20px 20px;
            animation: talk 2s ease-in-out infinite;
        }

        .character-arms {
            position: absolute;
            top: 20px;
            width: 100%;
        }

        .arm {
            width: 30px;
            height: 8px;
            background: #ffeaa7;
            border-radius: 10px;
            position: absolute;
            animation: wave 2s ease-in-out infinite;
        }

        .arm.left {
            left: -25px;
            transform-origin: right center;
        }

        .arm.right {
            right: -25px;
            transform-origin: left center;
            animation-delay: 1s;
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(2deg); }
            75% { transform: rotate(-2deg); }
        }

        @keyframes blink {
            0%, 90%, 100% { transform: scaleY(1); }
            95% { transform: scaleY(0.1); }
        }

        @keyframes talk {
            0%, 100% { border-radius: 0 0 20px 20px; }
            50% { border-radius: 0 0 10px 10px; }
        }

        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(-30deg); }
        }

        /* Floating icons around character */
        .floating-icon {
            position: absolute;
            font-size: 2rem;
            color: var(--accent-color);
            animation: floatAround 4s ease-in-out infinite;
            opacity: 0.7;
        }

        .icon-1 {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .icon-2 {
            top: 20%;
            right: 15%;
            animation-delay: 1s;
        }

        .icon-3 {
            bottom: 20%;
            left: 20%;
            animation-delay: 2s;
        }

        .icon-4 {
            bottom: 15%;
            right: 10%;
            animation-delay: 3s;
        }

        @keyframes floatAround {
            0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.7; }
            25% { transform: translateY(-10px) rotate(90deg); opacity: 1; }
            50% { transform: translateY(-5px) rotate(180deg); opacity: 0.8; }
            75% { transform: translateY(-15px) rotate(270deg); opacity: 1; }
        }

        /* Typography */
        .error-title {
            color: var(--text-primary);
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 700;
            margin: 2rem 0 1rem;
            line-height: 1.2;
        }

        .error-subtitle {
            color: var(--text-secondary);
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .error-message {
            color: var(--text-light);
            font-size: clamp(0.9rem, 2vw, 1rem);
            line-height: 1.6;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin: 2rem 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
            font-size: 0.95rem;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--white);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: var(--white);
            transform: translateY(-2px);
        }

        /* Search suggestion */
        .search-suggestion {
            background: rgba(99, 102, 241, 0.1);
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            position: relative;
        }

        .search-input-container {
            position: relative;
            max-width: 400px;
            margin: 0 auto;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid rgba(99, 102, 241, 0.3);
            border-radius: 50px;
            font-size: 1rem;
            background: var(--white);
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.1rem;
        }

        /* Help section */
        .help-section {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .help-title {
            color: var(--text-secondary);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .help-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .help-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            border-radius: 10px;
            background: rgba(99, 102, 241, 0.05);
        }

        .help-link:hover {
            background: rgba(99, 102, 241, 0.1);
            transform: translateY(-2px);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .error-container {
                padding: 1.5rem;
                margin: 1rem;
            }

            .action-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 280px;
                justify-content: center;
            }

            .help-links {
                flex-direction: column;
                gap: 1rem;
            }

            .help-link {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .floating-icon {
                font-size: 1.5rem;
            }

            .cartoon-character {
                width: 120px;
                height: 120px;
            }

            .character-body {
                width: 60px;
                height: 80px;
            }

            .character-head {
                width: 50px;
                height: 50px;
                top: -25px;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --surface: rgba(31, 41, 55, 0.95);
                --text-primary: #f9fafb;
                --text-secondary: #d1d5db;
                --text-light: #9ca3af;
            }
        }
    </style>
</head>
<body>
    <div class="floating-shapes" aria-hidden="true">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <main class="error-container" role="main">
        <img src="{{ asset('logo.jpg') }}" alt="TPmart Logo" class="logo" loading="eager">
        
        <div class="error-animation">
            <div class="error-number">404</div>
            
            <div class="cartoon-character">
                <div class="character-body">
                    <div class="character-head">
                        <div class="character-eyes">
                            <div class="eye left"></div>
                            <div class="eye right"></div>
                        </div>
                        <div class="character-mouth"></div>
                    </div>
                    <div class="character-arms">
                        <div class="arm left"></div>
                        <div class="arm right"></div>
                    </div>
                </div>
                
                <i class="floating-icon icon-1 fas fa-shopping-cart"></i>
                <i class="floating-icon icon-2 fas fa-gift"></i>
                <i class="floating-icon icon-3 fas fa-star"></i>
                <i class="floating-icon icon-4 fas fa-heart"></i>
            </div>
        </div>
        
        <h1 class="error-title">Oops! Page Not Found</h1>
        <p class="error-subtitle">We can't seem to find the page you're looking for</p>
        <p class="error-message">
            Don't worry! Our friendly robot is here to help. The page you're looking for might have been moved, 
            deleted, or you might have typed the wrong URL. Let's get you back on track!
        </p>
        
        <div class="action-buttons">
            <a href="{{ url('/') }}" class="btn btn-primary">
                <i class="fas fa-home"></i>
                Go Home
            </a>
            <button onclick="history.back()" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Go Back
            </button>
        </div>
        
        <div class="search-suggestion">
            <h3 style="margin-bottom: 1rem; color: var(--text-secondary);">
                <i class="fas fa-search" style="margin-right: 0.5rem;"></i>
                Try searching for what you need
            </h3>
            <div class="search-input-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search products, categories..." 
                       onkeypress="handleSearch(event)">
            </div>
        </div>
        
        <div class="help-section">
            <h3 class="help-title">Need help? Try these popular sections:</h3>
            <div class="help-links">
                <a href="{{ url('/products') }}" class="help-link">
                    <i class="fas fa-shopping-bag"></i>
                    All Products
                </a>
                <a href="{{ url('/categories') }}" class="help-link">
                    <i class="fas fa-th-large"></i>
                    Categories
                </a>
                <a href="{{ url('/contact') }}" class="help-link">
                    <i class="fas fa-headset"></i>
                    Contact Support
                </a>
                <a href="{{ url('/about') }}" class="help-link">
                    <i class="fas fa-info-circle"></i>
                    About Us
                </a>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add interactive elements
            const character = document.querySelector('.cartoon-character');
            const eyes = document.querySelectorAll('.eye');
            
            // Make character interactive
            character.addEventListener('click', function() {
                this.style.transform = 'translate(-50%, -50%) scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'translate(-50%, -50%) scale(1)';
                }, 200);
                
                // Make eyes wink
                eyes.forEach(eye => {
                    eye.style.transform = 'scaleY(0.1)';
                    setTimeout(() => {
                        eye.style.transform = 'scaleY(1)';
                    }, 300);
                });
            });
            
            // Add mouse follow effect for eyes
            document.addEventListener('mousemove', function(e) {
                const rect = character.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                
                const angle = Math.atan2(e.clientY - centerY, e.clientX - centerX);
                const distance = Math.min(3, Math.sqrt(Math.pow(e.clientX - centerX, 2) + Math.pow(e.clientY - centerY, 2)) / 20);
                
                const eyeX = Math.cos(angle) * distance;
                const eyeY = Math.sin(angle) * distance;
                
                eyes.forEach(eye => {
                    eye.style.transform = `translate(${eyeX}px, ${eyeY}px)`;
                });
            });
            
            // Auto-suggest search functionality
            const searchInput = document.querySelector('.search-input');
            const suggestions = [
                'Electronics', 'Clothing', 'Home & Garden', 'Sports', 'Books',
                'Beauty', 'Toys', 'Automotive', 'Food', 'Health'
            ];
            
            let currentSuggestion = 0;
            
            function rotatePlaceholder() {
                searchInput.placeholder = `Search ${suggestions[currentSuggestion]}...`;
                currentSuggestion = (currentSuggestion + 1) % suggestions.length;
            }
            
            setInterval(rotatePlaceholder, 3000);
            
            // Add floating animation to icons
            const floatingIcons = document.querySelectorAll('.floating-icon');
            floatingIcons.forEach((icon, index) => {
                icon.addEventListener('mouseenter', function() {
                    this.style.transform = `scale(1.3) rotate(${index * 90}deg)`;
                    this.style.color = getComputedStyle(document.documentElement).getPropertyValue('--danger-color');
                });
                
                icon.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                    this.style.color = getComputedStyle(document.documentElement).getPropertyValue('--accent-color');
                });
            });
            
            // Add particle effect on button hover
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    createParticles(this);
                });
            });
            
            function createParticles(element) {
                for (let i = 0; i < 5; i++) {
                    const particle = document.createElement('div');
                    particle.style.position = 'absolute';
                    particle.style.width = '4px';
                    particle.style.height = '4px';
                    particle.style.background = '#6366f1';
                    particle.style.borderRadius = '50%';
                    particle.style.pointerEvents = 'none';
                    particle.style.zIndex = '1000';
                    
                    const rect = element.getBoundingClientRect();
                    particle.style.left = rect.left + Math.random() * rect.width + 'px';
                    particle.style.top = rect.top + Math.random() * rect.height + 'px';
                    
                    document.body.appendChild(particle);
                    
                    // Animate particle
                    particle.animate([
                        { transform: 'translate(0, 0) scale(1)', opacity: 1 },
                        { transform: `translate(${(Math.random() - 0.5) * 100}px, ${-50 - Math.random() * 50}px) scale(0)`, opacity: 0 }
                    ], {
                        duration: 1000,
                        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                    }).onfinish = () => particle.remove();
                }
            }
        });
        
        // Search functionality
        function handleSearch(event) {
            if (event.key === 'Enter') {
                const query = event.target.value.trim();
                if (query) {
                    // Redirect to search page or handle search
                    window.location.href = `{{ url('/search') }}?q=${encodeURIComponent(query)}`;
                }
            }
        }
        
        // Add keyboard shortcuts
        document.addEventListener('keydown', function(event) {
            // Press 'H' to go home
            if (event.key.toLowerCase() === 'h' && !event.ctrlKey && !event.metaKey) {
                if (document.activeElement.tagName !== 'INPUT') {
                    window.location.href = '{{ url('/') }}';
                }
            }
            
            // Press 'B' to go back
            if (event.key.toLowerCase() === 'b' && !event.ctrlKey && !event.metaKey) {
                if (document.activeElement.tagName !== 'INPUT') {
                    history.back();
                }
            }
            
            // Press '/' to focus search
            if (event.key === '/' && !event.ctrlKey && !event.metaKey) {
                event.preventDefault();
                document.querySelector('.search-input').focus();
            }
        });
    </script>
</body>
</html>
