@extends('layouts.app')

@section('content')
@php $th = app()->getLocale() === 'th'; @endphp

<style>
    /* ================= 1. MULTI-BANNER HERO CAROUSEL ================= */
    .hero-showcase-wrap {
        padding: 24px 0 16px;
    }

    .hero-carousel {
        position: relative;
        border-radius: 32px;
        overflow: hidden;
        box-shadow: 0 28px 65px -15px rgba(79, 70, 229, 0.28);
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: #0f172a;
    }

    .hero-slide {
        position: relative;
        min-height: 520px;
        display: flex;
        align-items: center;
        padding: 72px 64px 96px;
        color: #fff;
        overflow: hidden;
    }

    .hero-slide-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        transition: transform 8s ease;
        transform: scale(1.02);
        z-index: 0;
    }

    .carousel-item.active .hero-slide-bg {
        transform: scale(1.09);
    }

    .hero-slide-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            110deg,
            rgba(15, 23, 42, 0.90) 0%,
            rgba(30, 27, 75, 0.72) 48%,
            rgba(79, 70, 229, 0.28) 100%
        );
        z-index: 1;
    }

    .hero-slide-grid {
        position: relative;
        z-index: 2;
        display: grid;
        grid-template-columns: 1.25fr 0.75fr;
        gap: 36px;
        align-items: center;
        width: 100%;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.28);
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #e0e7ff;
        margin-bottom: 18px;
    }

    .hero-badge span.dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #38bdf8;
        box-shadow: 0 0 10px #38bdf8;
    }

    .hero-slide-title {
        font-size: clamp(2.1rem, 4.2vw, 3.5rem);
        font-weight: 800;
        line-height: 1.14;
        letter-spacing: -0.02em;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 65%, #fbcfe8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-slide-desc {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.88);
        max-width: 580px;
        margin-bottom: 28px;
        line-height: 1.65;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
    }

    .btn-hero-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 32px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #ec4899 100%);
        color: #fff;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.98rem;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 12px 28px rgba(99, 102, 241, 0.45);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px) scale(1.02);
        color: #fff;
        box-shadow: 0 16px 36px rgba(236, 72, 153, 0.55);
    }

    .btn-hero-glass {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(12px);
        color: #fff;
        border-radius: 999px;
        font-weight: 700;
        font-size: 0.98rem;
        text-decoration: none;
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .btn-hero-glass:hover {
        background: rgba(255, 255, 255, 0.25);
        color: #fff;
        transform: translateY(-3px);
    }

    /* Visual Floating Preview Card inside Hero Slide */
    .hero-visual-card {
        background: rgba(15, 23, 42, 0.52);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 24px;
        padding: 16px;
        box-shadow: 0 20px 44px rgba(0, 0, 0, 0.35);
        animation: floatSlow 7s ease-in-out infinite;
    }

    .hero-visual-card img {
        width: 100%;
        height: 210px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 14px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-visual-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 4px 6px;
    }

    .hero-visual-meta .meta-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #fff;
    }

    .hero-visual-meta .meta-sub {
        font-size: 0.78rem;
        color: #c7d2fe;
    }

    .hero-visual-pill {
        background: linear-gradient(135deg, #4f46e5, #ec4899);
        color: #fff;
        font-size: 0.78rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 999px;
        white-space: nowrap;
    }

    /* Custom Slide Selector Tabs at bottom of Hero */
    .hero-tabs-bar {
        position: absolute;
        bottom: 18px;
        left: 24px;
        right: 24px;
        z-index: 5;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .hero-tab-btn {
        background: rgba(15, 23, 42, 0.62);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 14px;
        padding: 10px 14px;
        color: rgba(255, 255, 255, 0.78);
        text-align: left;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .hero-tab-btn:hover,
    .hero-tab-btn.active {
        background: rgba(255, 255, 255, 0.95);
        color: #0f172a;
        border-color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.25);
    }

    .hero-tab-btn i {
        font-size: 1.15rem;
        width: 34px;
        height: 34px;
        border-radius: 10px;
        background: rgba(99, 102, 241, 0.25);
        color: #a5b4fc;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .hero-tab-btn.active i,
    .hero-tab-btn:hover i {
        background: linear-gradient(135deg, #4f46e5, #ec4899);
        color: #fff;
    }

    .hero-tab-text {
        font-size: 0.82rem;
        font-weight: 700;
        line-height: 1.25;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* ================= 2. 3-CATEGORY VISUAL BANNER CARDS ================= */
    .portal-section {
        padding: 40px 0 28px;
    }

    .section-head-row {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 26px;
        flex-wrap: wrap;
    }

    .section-kicker {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.1);
        padding: 4px 12px;
        border-radius: 999px;
        margin-bottom: 8px;
    }

    .section-main-title {
        font-size: clamp(1.6rem, 2.8vw, 2.15rem);
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .section-main-sub {
        font-size: 0.96rem;
        color: #64748b;
        margin: 4px 0 0;
    }

    .section-link-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 999px;
        background: #fff;
        color: #4f46e5;
        border: 1.5px solid rgba(99, 102, 241, 0.25);
        font-weight: 700;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .section-link-pill:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #fff;
        border-color: transparent;
        transform: translateX(3px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.28);
    }

    .portal-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .portal-banner-card {
        position: relative;
        height: 320px;
        border-radius: 26px;
        overflow: hidden;
        text-decoration: none;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 28px;
        box-shadow: 0 16px 38px -10px rgba(15, 23, 42, 0.16);
        border: 1px solid rgba(99, 102, 241, 0.18);
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .portal-banner-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 26px 52px -12px rgba(79, 70, 229, 0.32);
        color: #fff;
    }

    .portal-banner-card img.portal-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 0;
    }

    .portal-banner-card:hover img.portal-bg {
        transform: scale(1.1);
    }

    .portal-banner-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(
            180deg,
            rgba(15, 23, 42, 0.12) 0%,
            rgba(30, 27, 75, 0.65) 50%,
            rgba(15, 23, 42, 0.94) 100%
        );
        z-index: 1;
    }

    .portal-card-top {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .portal-stat-badge {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        color: #1e1b4b;
        font-size: 0.78rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 999px;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .portal-icon-circle {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: linear-gradient(135deg, #4f46e5, #ec4899);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        box-shadow: 0 8px 18px rgba(236, 72, 153, 0.4);
    }

    .portal-card-body {
        position: relative;
        z-index: 2;
    }

    .portal-card-body h3 {
        font-size: 1.45rem;
        font-weight: 800;
        margin-bottom: 6px;
        color: #fff;
    }

    .portal-card-body p {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.85);
        margin-bottom: 14px;
        line-height: 1.5;
    }

    .portal-cta-text {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.86rem;
        font-weight: 700;
        color: #a5b4fc;
        transition: gap 0.25s ease, color 0.25s ease;
    }

    .portal-banner-card:hover .portal-cta-text {
        gap: 10px;
        color: #fbcfe8;
    }

    /* ================= 3. PROGRAMS & MAJORS SHOWCASE ================= */
    .majors-section {
        padding: 44px 0 36px;
    }

    .majors-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
    }

    .major-mini-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(99, 102, 241, 0.14);
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 8px 24px -10px rgba(15, 23, 42, 0.06);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
    }

    .major-mini-card:hover {
        transform: translateY(-6px);
        border-color: #6366f1;
        box-shadow: 0 18px 36px -10px rgba(99, 102, 241, 0.22);
        color: inherit;
    }

    .major-mini-thumb {
        position: relative;
        height: 125px;
        overflow: hidden;
        background: #1e1b4b;
    }

    .major-mini-thumb img.cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.55s ease;
    }

    .major-mini-card:hover .major-mini-thumb img.cover {
        transform: scale(1.1);
    }

    .major-mini-thumb::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 30%, rgba(15, 23, 42, 0.65) 100%);
    }

    .major-mini-logo {
        position: absolute;
        bottom: 8px;
        right: 8px;
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.95);
        padding: 4px;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .major-mini-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .major-mini-count {
        position: absolute;
        top: 8px;
        left: 8px;
        z-index: 2;
        background: rgba(15, 23, 42, 0.72);
        backdrop-filter: blur(6px);
        color: #e0e7ff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 9px;
        border-radius: 999px;
    }

    .major-mini-body {
        padding: 14px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .major-mini-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
        transition: color 0.2s;
    }

    .major-mini-card:hover .major-mini-title {
        color: #4f46e5;
    }

    /* ================= 4. RESEARCH & SCHOLARSHIPS SPLIT SHOWCASE ================= */
    .highlights-split-section {
        padding: 32px 0 40px;
    }

    .highlights-split-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 28px;
    }

    .highlight-box {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(99, 102, 241, 0.16);
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 14px 36px -12px rgba(15, 23, 42, 0.07);
        display: flex;
        flex-direction: column;
    }

    .highlight-banner-strip {
        position: relative;
        height: 175px;
        overflow: hidden;
        padding: 24px 28px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        color: #fff;
    }

    .highlight-banner-strip img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
        transition: transform 0.6s ease;
    }

    .highlight-box:hover .highlight-banner-strip img {
        transform: scale(1.06);
    }

    .highlight-banner-strip::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(115deg, rgba(15, 23, 42, 0.88) 0%, rgba(49, 46, 129, 0.72) 55%, rgba(131, 24, 67, 0.68) 100%);
        z-index: 1;
    }

    .highlight-banner-content {
        position: relative;
        z-index: 2;
    }

    .highlight-banner-content .badge-pill {
        display: inline-block;
        background: rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.28);
        color: #e0e7ff;
        font-size: 0.74rem;
        font-weight: 700;
        padding: 3px 12px;
        border-radius: 999px;
        margin-bottom: 6px;
    }

    .highlight-banner-content h3 {
        font-size: 1.4rem;
        font-weight: 800;
        margin: 0;
        color: #fff;
    }

    .highlight-body {
        padding: 26px 28px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .research-tags-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .research-tag-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 999px;
        background: #f8fafc;
        border: 1px solid rgba(99, 102, 241, 0.18);
        color: #1e293b;
        font-size: 0.83rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.22s ease;
    }

    .research-tag-chip i {
        color: #4f46e5;
    }

    .research-tag-chip .cnt {
        background: rgba(99, 102, 241, 0.1);
        color: #4f46e5;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 1px 7px;
        border-radius: 999px;
    }

    .research-tag-chip:hover {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: #fff;
        border-color: transparent;
        transform: translateY(-2px);
    }

    .research-tag-chip:hover i,
    .research-tag-chip:hover .cnt {
        color: #fff;
        background: rgba(255, 255, 255, 0.22);
    }

    .scholarship-quick-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 20px;
    }

    .scholarship-quick-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid rgba(99, 102, 241, 0.15);
        text-decoration: none;
        color: #0f172a;
        transition: all 0.25s ease;
    }

    .scholarship-quick-item:hover {
        background: #fff;
        border-color: #6366f1;
        transform: translateX(4px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.12);
        color: #4f46e5;
    }

    .scholarship-quick-item i.pdf-ic {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(236, 72, 153, 0.12);
        color: #db2777;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
    }

    .scholarship-quick-item .doc-title {
        font-size: 0.86rem;
        font-weight: 700;
        line-height: 1.35;
        flex: 1;
    }

    .scholarship-quick-item .doc-dl {
        font-size: 0.76rem;
        font-weight: 700;
        color: #4f46e5;
        white-space: nowrap;
    }

    /* ================= 5. NEWS & ANNOUNCEMENTS ================= */
    .news-section {
        padding: 36px 0 56px;
    }

    .news-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .news-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 22px 24px;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(99, 102, 241, 0.14);
        border-radius: 22px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 10px 28px -10px rgba(15, 23, 42, 0.06);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .news-item:hover {
        background: #ffffff;
        transform: translateY(-5px);
        border-color: rgba(99, 102, 241, 0.38);
        box-shadow: 0 20px 38px -12px rgba(99, 102, 241, 0.18);
        color: inherit;
    }

    .news-item-icon {
        font-size: 1.4rem;
        color: #4f46e5;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(236, 72, 153, 0.1) 100%);
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.35s ease;
    }

    .news-item:hover .news-item-icon {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        color: #ffffff;
        transform: scale(1.08) rotate(-6deg);
    }

    .news-item-content {
        flex: 1;
    }

    .news-item-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 6px;
    }

    .news-item-category {
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.1);
        padding: 3px 11px;
        border-radius: 999px;
    }

    .news-item-date {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 600;
    }

    .news-item-title {
        font-size: 1.02rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.4;
        margin-bottom: 6px;
        transition: color 0.2s;
    }

    .news-item:hover .news-item-title {
        color: #4f46e5;
    }

    .news-item-excerpt {
        font-size: 0.86rem;
        color: #64748b;
        line-height: 1.55;
        margin: 0;
    }

    @media (max-width: 991px) {
        .hero-slide-grid {
            grid-template-columns: 1fr;
        }
        .hero-visual-card {
            display: none;
        }
        .hero-tabs-bar {
            grid-template-columns: repeat(2, 1fr);
            position: relative;
            bottom: auto;
            left: auto;
            right: auto;
            padding: 14px;
            background: #0f172a;
        }
        .portal-grid {
            grid-template-columns: 1fr;
        }
        .majors-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .highlights-split-grid,
        .news-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .hero-slide {
            padding: 44px 24px 36px;
            min-height: 380px;
        }
        .hero-tabs-bar {
            grid-template-columns: 1fr;
        }
        .majors-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- ================= 1. MULTI-BANNER HERO CAROUSEL ================= -->
<div class="hero-showcase-wrap">
    <div class="container">
        <div id="homeHeroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-interval="5500">

            <div class="carousel-inner">

                <!-- Banner Slide 1: Main Graduate Admissions -->
                <div class="carousel-item active">
                    <div class="hero-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ asset('images/hero-grad-campus.png') }}');"></div>
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-grid">
                            <div>
                                <div class="hero-badge">
                                    <span class="dot"></span>
                                    <span>{{ __('site.hero_label') }}</span>
                                </div>
                                <h1 class="hero-slide-title">{{ __('site.hero_title') }}</h1>
                                <p class="hero-slide-desc">
                                    {{ $th
                                        ? 'ศูนย์รวมข้อมูลหลักสูตรปริญญาโท-เอก งานวิจัยวิทยานิพนธ์ และทุนการศึกษา คณะวิศวกรรมศาสตร์ มหาวิทยาลัยเชียงใหม่'
                                        : 'Explore Master\'s & Doctoral programs, thesis research repository, and scholarships at the Faculty of Engineering, Chiang Mai University.' }}
                                </p>
                                <div class="hero-actions">
                                    <a href="{{ route('programs.index') }}" class="btn-hero-primary">
                                        <span>{{ __('site.home_find_program') }}</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                    <a href="{{ route('scholarships.index') }}" class="btn-hero-glass">
                                        <i class="bi bi-award-fill"></i>
                                        <span>{{ $th ? 'ดูทุนการศึกษา 2569' : 'Scholarships 2026' }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="hero-visual-card">
                                <img src="{{ asset('images/hero-grad-campus.png') }}" alt="CMU Engineering Graduate Studies">
                                <div class="hero-visual-meta">
                                    <div>
                                        <div class="meta-title">{{ $th ? 'คณะวิศวกรรมศาสตร์ มช.' : 'Faculty of Engineering, CMU' }}</div>
                                        <div class="meta-sub">{{ count($programs) }} {{ $th ? 'หลักสูตร • 10 สาขาวิชา' : 'Programs • 10 Disciplines' }}</div>
                                    </div>
                                    <span class="hero-visual-pill">ADMISSIONS 2026</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banner Slide 2: Graduate Programs Banner -->
                <div class="carousel-item">
                    <div class="hero-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ asset('images/banner-programs.png') }}');"></div>
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-grid">
                            <div>
                                <div class="hero-badge">
                                    <span class="dot"></span>
                                    <span>{{ $th ? 'หมวดหลักสูตรบัณฑิตศึกษา' : 'GRADUATE PROGRAMS' }}</span>
                                </div>
                                <h2 class="hero-slide-title">
                                    {{ $th ? '23 หลักสูตร ป.โท และ ป.เอก ครอบคลุม 10 สาขาวิชา' : '23 Master\'s & Doctoral Programs Across 10 Majors' }}
                                </h2>
                                <p class="hero-slide-desc">
                                    {{ $th
                                        ? 'เลือกเรียนได้ทั้งแผนปกติ (จันทร์–ศุกร์) และแผนพิเศษ (เสาร์–อาทิตย์) พร้อมหลักสูตรนานาชาติและสหวิทยาการที่ตอบโจทย์อนาคต'
                                        : 'Flexible Regular (Weekday) and Weekend study plans designed for researchers, innovators, and working professionals.' }}
                                </p>
                                <div class="hero-actions">
                                    <a href="{{ route('programs.index') }}" class="btn-hero-primary">
                                        <span>{{ $th ? 'ดูหลักสูตรทั้งหมด' : 'Browse All Programs' }}</span>
                                        <i class="bi bi-grid-fill"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="hero-visual-card">
                                <img src="{{ asset('images/banner-programs.png') }}" alt="Graduate Programs Banner">
                                <div class="hero-visual-meta">
                                    <div>
                                        <div class="meta-title">{{ $th ? 'ปริญญาโท & ปริญญาเอก' : 'Master\'s & Ph.D. Degrees' }}</div>
                                        <div class="meta-sub">{{ $th ? 'วิศวกรรมศาสตร์และเทคโนโลยีขั้นสูง' : 'Advanced Engineering & Tech' }}</div>
                                    </div>
                                    <span class="hero-visual-pill">{{ count($programs) }} {{ $th ? 'หลักสูตร' : 'Programs' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banner Slide 3: Research & Theses Banner -->
                <div class="carousel-item">
                    <div class="hero-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ asset('images/banner-research.png') }}');"></div>
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-grid">
                            <div>
                                <div class="hero-badge">
                                    <span class="dot"></span>
                                    <span>{{ $th ? 'หมวดงานวิจัยและวิทยานิพนธ์' : 'RESEARCH & THESES' }}</span>
                                </div>
                                <h2 class="hero-slide-title">
                                    {{ $th ? 'คลังงานวิจัยและวิทยานิพนธ์กว่า ' . number_format($totalTheses) . ' เรื่อง' : 'Explore ' . number_format($totalTheses) . '+ Graduate Research & Theses' }}
                                </h2>
                                <p class="hero-slide-desc">
                                    {{ $th
                                        ? 'ค้นหาหัวข้อวิทยานิพนธ์และอาจารย์ที่ปรึกษาด้วยระบบจัดหมวดหมู่คำสำคัญ 2 ระดับ ครอบคลุม AI, พลังงานสะอาด, โยธา, หุ่นยนต์ และสิ่งแวดล้อม'
                                        : 'Discover thesis topics and academic advisors through our 2-level keyword classification across AI, Clean Energy, Civil, and Robotics.' }}
                                </p>
                                <div class="hero-actions">
                                    <a href="{{ route('research.index') }}" class="btn-hero-primary">
                                        <span>{{ $th ? 'สืบค้นงานวิจัยและวิทยานิพนธ์' : 'Explore Research Database' }}</span>
                                        <i class="bi bi-search"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="hero-visual-card">
                                <img src="{{ asset('images/banner-research.png') }}" alt="Research Banner">
                                <div class="hero-visual-meta">
                                    <div>
                                        <div class="meta-title">{{ $th ? 'ฐานข้อมูลวิทยานิพนธ์' : 'Thesis Repository' }}</div>
                                        <div class="meta-sub">{{ count($categories) }} {{ $th ? 'หมวดคำสำคัญหลัก' : 'Main Research Clusters' }}</div>
                                    </div>
                                    <span class="hero-visual-pill">{{ number_format($totalTheses) }} {{ $th ? 'ผลงาน' : 'Works' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Banner Slide 4: Scholarships Banner -->
                <div class="carousel-item">
                    <div class="hero-slide">
                        <div class="hero-slide-bg" style="background-image: url('{{ asset('images/banner-scholarships.png') }}');"></div>
                        <div class="hero-slide-overlay"></div>
                        <div class="hero-slide-grid">
                            <div>
                                <div class="hero-badge">
                                    <span class="dot"></span>
                                    <span>{{ $th ? 'หมวดทุนการศึกษา' : 'SCHOLARSHIPS & FUNDING' }}</span>
                                </div>
                                <h2 class="hero-slide-title">
                                    {{ $th ? 'ทุนบัณฑิตศึกษา มช. & ทุนผู้ช่วยสอน/วิจัย (TA/RA)' : 'CMU Graduate Scholarships & TA/RA Assistantships' }}
                                </h2>
                                <p class="hero-slide-desc">
                                    {{ $th
                                        ? 'สนับสนุนค่าธรรมเนียมการศึกษาและค่าครองชีพรายเดือนสำหรับนักศึกษาปริญญาโทและปริญญาเอก พร้อมดาวน์โหลดประกาศทุนปีการศึกษา 2569'
                                        : 'Full tuition waivers, monthly living stipends, and Teaching/Research Assistantships for qualified graduate students.' }}
                                </p>
                                <div class="hero-actions">
                                    <a href="{{ route('scholarships.index') }}" class="btn-hero-primary">
                                        <span>{{ $th ? 'ดูรายละเอียดทุนและดาวน์โหลดประกาศ' : 'View Scholarships & PDFs' }}</span>
                                        <i class="bi bi-file-earmark-arrow-down-fill"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="hero-visual-card">
                                <img src="{{ asset('images/banner-scholarships.png') }}" alt="Scholarships Banner">
                                <div class="hero-visual-meta">
                                    <div>
                                        <div class="meta-title">{{ $th ? 'ทุนการศึกษาปี 2569' : '2026 Scholarships' }}</div>
                                        <div class="meta-sub">CMUGS • TA/RA • Research Grants</div>
                                    </div>
                                    <span class="hero-visual-pill">4 PDF {{ $th ? 'เอกสาร' : 'Docs' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Interactive Banner Tab Switcher -->
            <div class="hero-tabs-bar">
                <button type="button" class="hero-tab-btn active" data-bs-target="#homeHeroCarousel" data-bs-slide-to="0">
                    <i class="bi bi-stars"></i>
                    <span class="hero-tab-text">{{ $th ? 'การเข้าศึกษาต่อ ป.โท-เอก' : 'Graduate Admissions' }}</span>
                </button>
                <button type="button" class="hero-tab-btn" data-bs-target="#homeHeroCarousel" data-bs-slide-to="1">
                    <i class="bi bi-mortarboard-fill"></i>
                    <span class="hero-tab-text">{{ $th ? '23 หลักสูตร 10 สาขาวิชา' : '23 Programs & 10 Majors' }}</span>
                </button>
                <button type="button" class="hero-tab-btn" data-bs-target="#homeHeroCarousel" data-bs-slide-to="2">
                    <i class="bi bi-journal-code"></i>
                    <span class="hero-tab-text">{{ $th ? 'งานวิจัยและวิทยานิพนธ์' : 'Research & Theses' }}</span>
                </button>
                <button type="button" class="hero-tab-btn" data-bs-target="#homeHeroCarousel" data-bs-slide-to="3">
                    <i class="bi bi-award-fill"></i>
                    <span class="hero-tab-text">{{ $th ? 'ทุนการศึกษา CMUGS & TA/RA' : 'Scholarships & TA/RA' }}</span>
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ================= 2. 3-CATEGORY BANNER OVERVIEW (รวมทุกหมวดหลักของเว็บพร้อมรูป Banner) ================= -->
<section class="portal-section">
    <div class="container">
        <div class="section-head-row">
            <div>
                <span class="section-kicker"><i class="bi bi-compass-fill"></i> {{ $th ? 'สำรวจหมวดหมู่ทั้งหมด' : 'EXPLORE SECTIONS' }}</span>
                <h2 class="section-main-title">{{ $th ? 'รวมข้อมูลสำคัญสำหรับนักศึกษาบัณฑิตศึกษา' : 'Everything You Need for Graduate Studies' }}</h2>
                <p class="section-main-sub">{{ $th ? 'สรุปเนื้อหาทั้ง 3 หมวดหลักของเว็บไซต์ เลือกคลิกเข้าดูรายละเอียดในแต่ละด้านได้ทันที' : 'Quick overview of our programs, research repository, and scholarship opportunities' }}</p>
            </div>
        </div>

        <div class="portal-grid">
            <!-- Category Banner 1: Programs -->
            <a href="{{ route('programs.index') }}" class="portal-banner-card fx-card">
                <img src="{{ asset('images/banner-programs.png') }}" alt="Programs" class="portal-bg">
                <div class="portal-card-top">
                    <span class="portal-stat-badge">{{ count($programs) }} {{ $th ? 'หลักสูตร • 10 สาขา' : 'Programs • 10 Majors' }}</span>
                    <div class="portal-icon-circle"><i class="bi bi-mortarboard-fill"></i></div>
                </div>
                <div class="portal-card-body">
                    <h3>{{ __('site.nav_programs') }}</h3>
                    <p>{{ $th ? 'หลักสูตรปริญญาโทและปริญญาเอก แผน ก/ข แผนปกติและแผนพิเศษ พร้อมข้อมูลหน่วยกิตและค่าธรรมเนียมครบถ้วน' : 'Master\'s and Doctoral degree programs with full curriculum, credit, study day, and tuition details.' }}</p>
                    <span class="portal-cta-text">
                        {{ $th ? 'ค้นหาหลักสูตรที่ใช่' : 'Explore Programs' }} <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </a>

            <!-- Category Banner 2: Research -->
            <a href="{{ route('research.index') }}" class="portal-banner-card fx-card">
                <img src="{{ asset('images/banner-research.png') }}" alt="Research" class="portal-bg">
                <div class="portal-card-top">
                    <span class="portal-stat-badge">{{ number_format($totalTheses) }} {{ $th ? 'ผลงานวิจัย' : 'Theses' }}</span>
                    <div class="portal-icon-circle"><i class="bi bi-cpu-fill"></i></div>
                </div>
                <div class="portal-card-body">
                    <h3>{{ __('site.nav_research') }}</h3>
                    <p>{{ $th ? 'คลังข้อมูลวิทยานิพนธ์และงานวิจัยแยกตาม 10 หมวดคำสำคัญหลัก ค้นหาหัวข้อและอาจารย์ที่ปรึกษาได้สะดวกรวดเร็ว' : 'Searchable thesis database categorized into 10 research clusters with advisor profiles.' }}</p>
                    <span class="portal-cta-text">
                        {{ $th ? 'สำรวจฐานข้อมูลงานวิจัย' : 'Explore Research' }} <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </a>

            <!-- Category Banner 3: Scholarships -->
            <a href="{{ route('scholarships.index') }}" class="portal-banner-card fx-card">
                <img src="{{ asset('images/banner-scholarships.png') }}" alt="Scholarships" class="portal-bg">
                <div class="portal-card-top">
                    <span class="portal-stat-badge">{{ $th ? 'ทุน CMUGS & TA/RA 2569' : 'CMUGS & TA/RA 2026' }}</span>
                    <div class="portal-icon-circle"><i class="bi bi-award-fill"></i></div>
                </div>
                <div class="portal-card-body">
                    <h3>{{ __('site.nav_scholarships') }}</h3>
                    <p>{{ $th ? 'ทุนบัณฑิตศึกษา มช. ทุนผู้ช่วยสอน/ผู้ช่วยวิจัย (TA/RA) ทุนคณะวิศวกรรมศาสตร์ และดาวน์โหลดประกาศทุนฉบับจริง' : 'CMU Graduate Scholarships, TA/RA assistantships, eligibility criteria, and official PDF announcements.' }}</p>
                    <span class="portal-cta-text">
                        {{ $th ? 'ดูรายละเอียดทุนและเอกสาร' : 'View Scholarships' }} <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- ================= 3. SUMMARY OF 10 ENGINEERING DISCIPLINES ================= -->
<section class="majors-section">
    <div class="container">
        <div class="section-head-row">
            <div>
                <span class="section-kicker"><i class="bi bi-grid-1x2-fill"></i> {{ $th ? 'สรุปสาขาวิชาที่เปิดสอน' : 'ACADEMIC DISCIPLINES' }}</span>
                <h2 class="section-main-title">{{ $th ? '10 สาขาวิชาวิศวกรรมศาสตร์และสหวิทยาการ' : '10 Engineering & Interdisciplinary Majors' }}</h2>
                <p class="section-main-sub">{{ $th ? 'คลิกที่สาขาวิชาเพื่อดูรายละเอียดแผนการเรียน ค่าธรรมเนียม และคุณสมบัติผู้สมัคร' : 'Click any discipline to view degree plans, study schedules, tuition fees, and admission criteria' }}</p>
            </div>
            <a href="{{ route('programs.index') }}" class="section-link-pill">
                <span>{{ $th ? 'ดูทั้ง ' . count($programs) . ' หลักสูตร' : 'View All ' . count($programs) . ' Programs' }}</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="majors-grid">
            @foreach ($departmentCards as $dept)
                <a href="{{ route('programs.show', $dept['code']) }}" class="major-mini-card fx-card">
                    <div class="major-mini-thumb">
                        <img src="{{ asset($dept['cover']) }}" alt="{{ $dept['major'] }}" class="cover">
                        <span class="major-mini-count">{{ $dept['count'] }} {{ $th ? 'หลักสูตร' : 'Programs' }}</span>
                        @if (!empty($dept['logo']))
                            <div class="major-mini-logo">
                                <img src="{{ asset($dept['logo']) }}" alt="{{ $dept['major'] }}">
                            </div>
                        @endif
                    </div>
                    <div class="major-mini-body">
                        <div class="major-mini-title">
                            {{ $th ? $dept['major'] : $dept['major_en'] }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ================= 4. RESEARCH CLUSTERS & SCHOLARSHIP PDFS SUMMARY ================= -->
<section class="highlights-split-section">
    <div class="container">
        <div class="highlights-split-grid">

            <!-- Left Box: Research Categories Summary -->
            <div class="highlight-box fx-card">
                <div class="highlight-banner-strip">
                    <img src="{{ asset('images/banner-research.png') }}" alt="Research Highlights">
                    <div class="highlight-banner-content">
                        <span class="badge-pill"><i class="bi bi-tags-fill"></i> {{ number_format($totalTheses) }} {{ __('site.research_total_theses') }}</span>
                        <h3>{{ $th ? 'หมวดงานวิจัยและวิทยานิพนธ์' : 'Research & Thesis Clusters' }}</h3>
                    </div>
                </div>
                <div class="highlight-body">
                    <div>
                        <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 14px;">
                            {{ $th ? 'สำรวจหัวข้อวิทยานิพนธ์แยกตามกลุ่มความเชี่ยวชาญหลักของคณะวิศวกรรมศาสตร์:' : 'Browse graduate theses grouped by core engineering research areas:' }}
                        </p>
                        <div class="research-tags-cloud">
                            @foreach (array_slice($categories, 0, 8) as $cat)
                                <a href="{{ route('research.index') }}" class="research-tag-chip">
                                    <i class="bi {{ $cat['icon'] ?? 'bi-Journal-text' }}"></i>
                                    <span>{{ $th ? ($cat['name_th'] ?? '') : ($cat['name_en'] ?? '') }}</span>
                                    <span class="cnt">{{ $cat['count'] ?? 0 }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('research.index') }}" class="section-link-pill">
                            <span>{{ $th ? 'ค้นหางานวิจัยทั้งหมด' : 'Search All Theses' }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Box: Scholarships & Direct PDF Downloads Summary -->
            <div class="highlight-box fx-card">
                <div class="highlight-banner-strip">
                    <img src="{{ asset('images/banner-scholarships.png') }}" alt="Scholarships Highlights">
                    <div class="highlight-banner-content">
                        <span class="badge-pill"><i class="bi bi-file-earmark-pdf-fill"></i> {{ $th ? 'ทุนการศึกษา' : 'Scholarships' }}</span>
                        <h3>{{ $th ? 'เอกสารดาวน์โหลด' : 'Documents' }}</h3>
                    </div>
                </div>
                <div class="highlight-body">
                    <div>
                        <div class="scholarship-quick-list">
                            <a href="{{ asset('docs/scholarships/CMUGS_2569_th.pdf') }}" target="_blank" rel="noopener" class="scholarship-quick-item">
                                <i class="bi bi-file-earmark-pdf-fill pdf-ic"></i>
                                <span class="doc-title">{{ $th ? 'ประกาศทุนบัณฑิตศึกษามหาวิทยาลัยเชียงใหม่ ปีการศึกษา 2569 (TH)' : 'CMU Graduate Scholarship Announcement 2026 (Thai PDF)' }}</span>
                                <span class="doc-dl"><i class="bi bi-download"></i> PDF</span>
                            </a>
                            <a href="{{ asset('docs/scholarships/Announcement_2026_en.pdf') }}" target="_blank" rel="noopener" class="scholarship-quick-item">
                                <i class="bi bi-file-earmark-pdf-fill pdf-ic"></i>
                                <span class="doc-title">{{ $th ? 'ประกาศทุนบัณฑิตศึกษา มช. ปีการศึกษา 2569 (EN - CMU Graduate Scholarship)' : 'CMU Graduate Scholarship Announcement 2026 (English PDF)' }}</span>
                                <span class="doc-dl"><i class="bi bi-download"></i> PDF</span>
                            </a>
                            <a href="{{ asset('docs/scholarships/69_tara_th.pdf') }}" target="_blank" rel="noopener" class="scholarship-quick-item">
                                <i class="bi bi-file-earmark-pdf-fill pdf-ic"></i>
                                <span class="doc-title">{{ $th ? 'ประกาศทุนผู้ช่วยสอนและทุนผู้ช่วยวิจัย (TA/RA) ปีการศึกษา 2569 (TH)' : 'TA/RA Scholarships Academic Year 2026 (Thai PDF)' }}</span>
                                <span class="doc-dl"><i class="bi bi-download"></i> PDF</span>
                            </a>
                            <a href="{{ asset('docs/scholarships/69_tara_en.pdf') }}" target="_blank" rel="noopener" class="scholarship-quick-item">
                                <i class="bi bi-file-earmark-pdf-fill pdf-ic"></i>
                                <span class="doc-title">{{ $th ? 'ประกาศทุนผู้ช่วยสอนและทุนผู้ช่วยวิจัย (TA/RA) ปีการศึกษา 2569 (EN)' : 'TA/RA Scholarships Academic Year 2026 (English PDF)' }}</span>
                                <span class="doc-dl"><i class="bi bi-download"></i> PDF</span>
                            </a>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('scholarships.index') }}" class="section-link-pill">
                            <span>{{ $th ? 'ดูเอกสารดาวน์โหลดทั้งหมด' : 'View All Documents' }}</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ================= 5. NEWS & ANNOUNCEMENTS SECTION (Hidden) =================
<section class="news-section">
    <div class="container">
        <div class="section-head-row">
            <div>
                <span class="section-kicker"><i class="bi bi-megaphone-fill"></i> {{ $th ? 'อัปเดตล่าสุด' : 'LATEST UPDATES' }}</span>
                <h2 class="section-main-title">{{ __('site.menu_news') }}</h2>
                <p class="section-main-sub">{{ __('site.menu_news_desc') }}</p>
            </div>
        </div>

        <div class="news-grid">
            @forelse ($news as $item)
                <a href="{{ ($item['category'] ?? '') === 'ทุนการศึกษา' ? route('scholarships.index') : route('programs.index') }}" class="news-item fx-card">
                    <div class="news-item-icon">
                        <i class="bi {{ $item['icon'] }}"></i>
                    </div>
                    <div class="news-item-content">
                        <div class="news-item-top">
                            <span class="news-item-category">
                                {{ $th ? $item['category'] : $item['category_en'] }}
                            </span>
                            <span class="news-item-date">
                                <i class="bi bi-calendar3"></i> {{ $th ? $item['date'] : $item['date_en'] }}
                            </span>
                        </div>
                        <div class="news-item-title">
                            {{ $th ? $item['title'] : $item['title_en'] }}
                        </div>
                        @if (!empty($item['excerpt']))
                            <p class="news-item-excerpt">
                                {{ $th ? $item['excerpt'] : ($item['excerpt_en'] ?? $item['excerpt']) }}
                            </p>
                        @endif
                    </div>
                </a>
            @empty
                <p style="text-align: center; color: #999; padding: 20px;">
                    {{ __('site.news_not_available') }}
                </p>
            @endforelse
        </div>
    </div>
</section>
--}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const heroCarousel = document.getElementById('homeHeroCarousel');
    const tabBtns = document.querySelectorAll('.hero-tab-btn');
    if (heroCarousel && tabBtns.length) {
        heroCarousel.addEventListener('slide.bs.carousel', function (e) {
            tabBtns.forEach((btn, idx) => {
                btn.classList.toggle('active', idx === e.to);
            });
        });
    }
});
</script>
@endpush

@endsection
