<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('site.nav_title'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #8b5cf6;
            --accent-pink: #ec4899;
            --accent-cyan: #06b6d4;
            --accent-amber: #f59e0b;
            --grad-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
            --grad-cool: linear-gradient(135deg, #6366f1 0%, #8b5cf6 60%, #06b6d4 100%);
            --grad-soft: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 50%, rgba(236, 72, 153, 0.08) 100%);
            --primary-soft: rgba(99, 102, 241, 0.09);
            --primary-border: rgba(99, 102, 241, 0.22);
            --primary-glow: rgba(99, 102, 241, 0.32);
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Noto Sans Thai', 'Sarabun', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: var(--bg-page);
            background-image:
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.08) 0px, transparent 45%),
                radial-gradient(at 100% 15%, rgba(236, 72, 153, 0.07) 0px, transparent 45%),
                radial-gradient(at 50% 90%, rgba(6, 182, 212, 0.06) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--text-dark);
            line-height: 1.65;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
        }

        a {
            color: var(--primary-dark);
            transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        }

        a:hover {
            color: var(--accent-pink);
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        /* ================= GLOBAL ANIMATIONS & EFFECTS ================= */
        @keyframes heroZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.07); }
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(2deg); }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 10px 28px rgba(99, 102, 241, 0.4), 0 0 0 0 rgba(139, 92, 246, 0.4); }
            50% { box-shadow: 0 14px 34px rgba(236, 72, 153, 0.45), 0 0 0 10px rgba(139, 92, 246, 0); }
        }

        @keyframes shimmerSweep {
            0% { transform: translateX(-130%) skewX(-18deg); }
            100% { transform: translateX(230%) skewX(-18deg); }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Scroll Reveal Utility Classes */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1),
                        transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Interactive Card Shine Effect */
        .fx-card {
            position: relative;
            overflow: hidden;
            transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                        box-shadow 0.35s cubic-bezier(0.16, 1, 0.3, 1),
                        border-color 0.35s ease;
        }

        .fx-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 45%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.45), transparent);
            transform: translateX(-140%) skewX(-18deg);
            pointer-events: none;
        }

        .fx-card:hover::after {
            animation: shimmerSweep 0.85s ease forwards;
        }
    </style>

    @stack('styles')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- Navigation -->
@include('partials.navbar')

<!-- Main Content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
@include('partials.footer')

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Scroll Reveal & Navbar Scroll Effects -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const animatedSelectors = [
        '.hero-carousel',
        '.portal-banner-card',
        '.major-mini-card',
        '.highlight-box',
        '.hero-content',
        '.news-header',
        '.news-item',
        '.search-section',
        '.filter-section',
        '.program-card',
        '.details-card',
        '.plan-card',
        '.content-card',
        '.scholarship-card',
        '.step-item',
        '.document-item',
        '.keyword-panel',
        '.auto-note'
    ];

    const elements = document.querySelectorAll(animatedSelectors.join(','));
    elements.forEach((el, index) => {
        el.classList.add('reveal-on-scroll');
        el.style.transitionDelay = `${Math.min((index % 6) * 60, 300)}ms`;
    });

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });

        elements.forEach(el => observer.observe(el));
    } else {
        elements.forEach(el => el.classList.add('is-visible'));
    }

    // Navbar scroll elevation effect
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        }, { passive: true });
    }
});
</script>

<!-- Floating Chatbot Widget (Vanilla JS) -->
<script src="/js/chatbot.js"></script>

@stack('scripts')

</body>
</html>
