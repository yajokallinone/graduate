<?php
$currentLocale = app()->getLocale();
?>

<style>
    /* Navbar (Modern Youthful Glassmorphic Style, exact original content) */
    .navbar {
        background: rgba(255, 255, 255, 0.82);
        backdrop-filter: blur(18px) saturate(180%);
        -webkit-backdrop-filter: blur(18px) saturate(180%);
        box-shadow: 0 4px 24px rgba(15, 23, 42, 0.04);
        padding: 14px 0;
        border-bottom: 1px solid rgba(99, 102, 241, 0.14);
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .navbar::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 2px;
        background: linear-gradient(90deg, #4f46e5 0%, #8b5cf6 50%, #ec4899 100%);
        opacity: 0.85;
    }

    .navbar.navbar-scrolled {
        padding: 10px 0;
        background: rgba(255, 255, 255, 0.94);
        box-shadow: 0 12px 34px rgba(99, 102, 241, 0.12);
    }

    .navbar-brand {
        font-size: 1.15rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 55%, #db2777 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-right: auto;
        letter-spacing: -0.02em;
    }

    .navbar-brand i {
        font-size: 1.3rem;
        color: #fff;
        -webkit-text-fill-color: #fff;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        width: 42px;
        height: 42px;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35);
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.35s ease;
    }

    .navbar-brand:hover i {
        transform: rotate(-8deg) scale(1.08);
        box-shadow: 0 10px 22px rgba(236, 72, 153, 0.4);
    }

    .navbar-nav {
        display: flex;
        gap: 6px;
        margin-left: auto;
        background: rgba(241, 245, 249, 0.75);
        padding: 5px;
        border-radius: 999px;
        border: 1px solid rgba(99, 102, 241, 0.1);
    }

    .nav-link {
        color: #475569 !important;
        font-weight: 600;
        font-size: 0.92rem;
        padding: 8px 18px !important;
        border-radius: 999px;
        position: relative;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .nav-link:hover {
        color: #4f46e5 !important;
        background: rgba(255, 255, 255, 0.85);
    }

    .nav-link.active {
        color: #ffffff !important;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 60%, #ec4899 100%);
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
    }

    /* Right Items */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-left: 18px;
    }

    /* Language Switch */
    .lang-switch {
        display: inline-flex;
        align-items: center;
        background: #f1f5f9;
        padding: 4px;
        border-radius: 999px;
        border: 1px solid rgba(99, 102, 241, 0.14);
    }

    .lang-btn {
        background: none;
        border: none;
        color: #64748b;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .lang-btn:hover {
        color: #4f46e5;
    }

    .lang-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: #fff;
        box-shadow: 0 3px 10px rgba(79, 70, 229, 0.3);
    }

    .lang-divider {
        display: none;
    }

    /* Search Icon */
    .search-icon {
        color: #4f46e5;
        cursor: pointer;
        font-size: 1rem;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(99, 102, 241, 0.1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .search-icon:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #fff;
        transform: scale(1.1) rotate(6deg);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
    }

    @media (max-width: 991px) {
        .navbar-nav {
            margin-left: 0;
            margin-top: 12px;
            border-radius: 16px;
            padding: 8px;
        }

        .navbar-right {
            margin-left: 0;
            margin-top: 12px;
        }
    }

    @media (max-width: 576px) {
        .navbar-brand {
            font-size: 0.95rem;
            gap: 8px;
        }

        .navbar-brand i {
            width: 34px;
            height: 34px;
            font-size: 1.1rem;
            border-radius: 10px;
        }

        .nav-link {
            font-size: 0.88rem;
            padding: 6px 14px !important;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}" title="{{ __('site.nav_title') }}">
            <i class="bi bi-mortarboard-fill"></i>
            <span style="display: none;">{{ __('site.nav_title') }}</span>
            <span>
                {{ app()->getLocale() === 'th' ? 'การเข้าศึกษาต่อระดับบัณฑิตศึกษา' : 'Graduate Admissions' }}
            </span>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="nav">

            <!-- Left Menu -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        {{ __('site.nav_home') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('programs.*') ? 'active' : '' }}" href="{{ route('programs.index') }}">
                        {{ __('site.nav_programs') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('research.*') ? 'active' : '' }}" href="{{ route('research.index') }}">
                        {{ __('site.nav_research') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('scholarships.*') ? 'active' : '' }}" href="{{ route('scholarships.index') }}">
                        {{ __('site.nav_scholarships') }}
                    </a>
                </li>
            </ul>

            <!-- Right Items -->
            <div class="navbar-right">

                <!-- Search Icon -->
                <i class="bi bi-search search-icon" onclick="document.getElementById('global-search').focus();"></i>

                <!-- Language Switch -->
                <div class="lang-switch">
                    <a href="{{ route(request()->route()->getName(), [...request()->route()->parameters(), 'lang' => 'th']) }}"
                       class="lang-btn {{ $currentLocale === 'th' ? 'active' : '' }}">
                        TH
                    </a>
                    <span class="lang-divider">|</span>
                    <a href="{{ route(request()->route()->getName(), [...request()->route()->parameters(), 'lang' => 'en']) }}"
                       class="lang-btn {{ $currentLocale === 'en' ? 'active' : '' }}">
                        EN
                    </a>
                </div>

            </div>

        </div>
    </div>
</nav>

<!-- Hidden Search Input -->
<input type="text" id="global-search" style="display: none;">
