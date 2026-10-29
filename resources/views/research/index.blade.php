@extends('layouts.app')

@section('title', __('site.research_title'))

@section('content')

<style>
    /* ---------- Header (Modern Youthful Theme + Banner Image) ---------- */
    .research-hero {
        background:
            linear-gradient(125deg, rgba(15, 23, 42, 0.88) 0%, rgba(49, 46, 129, 0.80) 50%, rgba(131, 24, 67, 0.76) 100%),
            url('{{ asset("images/banner-research.png") }}');
        background-size: cover;
        background-position: center;
        padding: 76px 0 64px;
        color: #fff;
        text-align: center;
        border-bottom-left-radius: 32px;
        border-bottom-right-radius: 32px;
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.14);
        position: relative;
        overflow: hidden;
    }

    .research-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 60%, #fbcfe8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 4px 18px rgba(0, 0, 0, 0.3));
    }

    .research-hero p {
        font-size: 1.05rem;
        color: #e0e7ff;
        opacity: 0.95;
        margin-bottom: 24px;
    }

    .hero-stats {
        display: inline-flex;
        justify-content: center;
        gap: 40px;
        flex-wrap: wrap;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.24);
        padding: 14px 36px;
        border-radius: 20px;
    }

    .hero-stat .num {
        font-size: 1.8rem;
        font-weight: 800;
        color: #a5b4fc;
        display: block;
    }

    .hero-stat .label {
        font-size: 0.82rem;
        opacity: 0.9;
    }

    .breadcrumb {
        background: transparent;
        padding: 0 0 14px;
        margin: 0;
        font-size: 0.85rem;
    }

    .breadcrumb-item, .breadcrumb-item.active {
        color: rgba(255,255,255,0.75);
    }

    .breadcrumb-item a {
        color: #fff;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
    }

    /* ---------- Note box ---------- */
    .auto-note {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(99, 102, 241, 0.16);
        border-left: 4px solid #6366f1;
        border-radius: 14px;
        padding: 14px 18px;
        margin: 24px 0 20px;
        font-size: 0.86rem;
        color: #475569;
        line-height: 1.6;
        display: flex;
        gap: 10px;
        align-items: flex-start;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);
    }

    .auto-note i {
        color: #4f46e5;
        margin-top: 2px;
    }

    /* ---------- 2-Level Keyword Panel ---------- */
    .keyword-panel {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.16);
        border-radius: 22px;
        padding: 24px 26px;
        margin-bottom: 24px;
        box-shadow: 0 12px 32px -10px rgba(15, 23, 42, 0.06);
    }

    .keyword-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .keyword-title {
        font-size: 1.1rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 55%, #db2777 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .keyword-title i {
        color: #4f46e5;
        -webkit-text-fill-color: #4f46e5;
    }

    .kw-level-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Level 1 keyword buttons */
    .kw-level1-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .kw-pill-l1 {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        border-radius: 999px;
        border: 1.5px solid rgba(99, 102, 241, 0.18);
        background: #fff;
        color: #0f172a;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
        white-space: nowrap;
    }

    .kw-pill-l1 i {
        color: #4f46e5;
        font-size: 1rem;
        transition: color 0.18s ease;
    }

    .kw-pill-l1 .kw-count {
        font-size: 0.76rem;
        font-weight: 700;
        background: rgba(99, 102, 241, 0.1);
        color: #4f46e5;
        padding: 2px 8px;
        border-radius: 999px;
        transition: all 0.18s ease;
    }

    .kw-pill-l1:hover {
        border-color: #6366f1;
        color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.16);
    }

    .kw-pill-l1.active {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.32);
    }

    .kw-pill-l1.active i {
        color: #fff;
    }

    .kw-pill-l1.active .kw-count {
        background: rgba(255, 255, 255, 0.24);
        color: #fff;
    }

    /* Level 2 sub-keyword bar */
    .kw-level2-wrap {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px dashed rgba(99, 102, 241, 0.22);
    }

    .kw-level2-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .kw-pill-l2 {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 999px;
        border: 1px solid rgba(99, 102, 241, 0.22);
        background: #fff;
        color: #475569;
        font-size: 0.84rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.18s ease;
        white-space: nowrap;
    }

    .kw-pill-l2 .kw-sub-count {
        font-size: 0.74rem;
        color: #94a3b8;
        font-weight: 600;
    }

    .kw-pill-l2:hover {
        border-color: #6366f1;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.06);
    }

    .kw-pill-l2.active {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }

    .kw-pill-l2.active .kw-sub-count {
        color: rgba(255, 255, 255, 0.85);
    }

    /* ---------- Active Filter Header & Toolbar ---------- */
    .active-filter-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .section-title .sub-arrow {
        color: #94a3b8;
        font-weight: 400;
    }

    .section-title .sub-highlight {
        color: #4f46e5;
    }

    .clear-kw-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 16px;
        background: #fff;
        color: #4f46e5;
        border: 1px solid rgba(99, 102, 241, 0.25);
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.82rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .clear-kw-btn:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #fff;
        border-color: transparent;
    }

    .research-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.14);
    }

    .search-box-inline {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        border: 1.5px solid rgba(99, 102, 241, 0.22);
        border-radius: 999px;
        padding: 9px 18px;
        flex: 1;
        min-width: 220px;
        max-width: 420px;
        transition: all 0.2s;
    }

    .search-box-inline:focus-within {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.12);
    }

    .search-box-inline i {
        color: #4f46e5;
    }

    .search-box-inline input {
        border: none;
        background: transparent;
        flex: 1;
        font-size: 0.9rem;
        outline: none;
        color: #0f172a;
    }

    .toolbar-right {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .sort-select {
        padding: 8px 16px;
        border: 1px solid rgba(99, 102, 241, 0.22);
        border-radius: 999px;
        font-size: 0.85rem;
        color: #334155;
        background: #fff;
    }

    .result-count-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #4f46e5;
        white-space: nowrap;
    }

    /* ---------- Thesis list ---------- */
    .thesis-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 28px;
    }

    .thesis-row {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(99, 102, 241, 0.14);
        border-left: 4px solid #6366f1;
        border-radius: 16px;
        padding: 18px 22px;
        cursor: pointer;
        transition: all 0.28s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.03);
    }

    .thesis-row:hover {
        background: #fff;
        border-color: #6366f1;
        transform: translateY(-3px) translateX(3px);
        box-shadow: 0 14px 30px -6px rgba(99, 102, 241, 0.15);
    }

    .thesis-row .thesis-th {
        font-weight: 700;
        color: #0f172a;
        font-size: 1rem;
        margin-bottom: 4px;
        line-height: 1.5;
    }

    .thesis-row .thesis-en {
        color: #64748b;
        font-size: 0.88rem;
        font-style: italic;
        line-height: 1.5;
    }

    .thesis-row .kw-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
    }

    .thesis-row .main-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        color: #fff;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        padding: 3px 11px;
        border-radius: 999px;
        font-weight: 600;
    }

    .thesis-row .sub-tag {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.75rem;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.1);
        padding: 3px 11px;
        border-radius: 999px;
        font-weight: 600;
    }

    mark {
        background: #fef08a;
        color: inherit;
        padding: 0 2px;
        border-radius: 3px;
    }

    /* ---------- Pagination ---------- */
    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
        margin: 32px 0 48px;
    }

    .page-btn {
        min-width: 38px;
        height: 38px;
        padding: 0 12px;
        border: 1px solid rgba(99, 102, 241, 0.22);
        background: #fff;
        color: #475569;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .page-btn:hover:not(:disabled) {
        border-color: #6366f1;
        color: #4f46e5;
    }

    .page-btn.active {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .page-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .page-ellipsis {
        color: #94a3b8;
        padding: 0 4px;
    }

    /* ---------- Empty state ---------- */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 16px;
        display: block;
    }

    /* ---------- Modal ---------- */
    .thesis-modal .modal-content {
        border-radius: 22px;
        border: 1px solid rgba(99, 102, 241, 0.18);
        box-shadow: 0 24px 60px rgba(15, 23, 42, 0.22);
    }

    .thesis-modal .modal-header {
        border-bottom: 1px solid #f1f5f9;
        padding: 20px 24px;
    }

    .thesis-modal .modal-body {
        padding: 24px;
    }

    .thesis-modal .modal-footer {
        border-top: 1px solid #f1f5f9;
        padding: 16px 24px;
    }

    .modal-cat-badge {
        display: inline-block;
        background: rgba(99, 102, 241, 0.12);
        color: #4f46e5;
        padding: 5px 14px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .modal-field-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #64748b;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .modal-field-value {
        font-size: 1rem;
        color: #0f172a;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .modal-field-value.en {
        font-style: italic;
        color: #475569;
    }

    .modal-advisors {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .advisor-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        color: #334155;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .advisor-chip i {
        color: #4f46e5;
        font-size: 0.8rem;
    }

    .thesis-row .advisor-line {
        margin-top: 6px;
        font-size: 0.8rem;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .thesis-row .advisor-line i {
        color: #4f46e5;
    }

    /* ---------- Loading ---------- */
    .loading-box {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .spinner-border-sm-custom {
        width: 2rem;
        height: 2rem;
        color: #4f46e5;
    }

    @media (max-width: 576px) {
        .research-hero h1 {
            font-size: 1.65rem;
        }
        .research-toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        .search-box-inline {
            max-width: none;
        }
        .toolbar-right {
            justify-content: space-between;
        }
    }
</style>

<!-- Hero -->
<div class="research-hero">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center" id="research-breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>
                <li class="breadcrumb-item active">{{ __('site.nav_research') }}</li>
            </ol>
        </nav>
        <h1>{{ __('site.research_title') }}</h1>
        <p>{{ __('site.research_subtitle') }}</p>
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="num">{{ number_format($totalCount) }}</span>
                <span class="label">{{ __('site.research_total_theses') }}</span>
            </div>
            <div class="hero-stat">
                <span class="num">{{ count($categories) }}</span>
                <span class="label">{{ __('site.research_categories') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="auto-note">
        <i class="bi bi-info-circle"></i>
        <span>{{ __('site.research_note_auto') }}</span>
    </div>

    <!-- ============ MAIN CONTENT (2-Level Keywords + Immediate Thesis List) ============ -->
    <div id="view-main" style="display:none;">

        <!-- 2-Level Keyword Box -->
        <div class="keyword-panel">
            <div class="keyword-header">
                <h3 class="keyword-title">
                    <i class="bi bi-tags-fill"></i>
                    <span>{{ __('site.research_trending_title') }}</span>
                </h3>
                <button type="button" class="clear-kw-btn" id="btn-clear-keywords" style="display:none;">
                    <i class="bi bi-x-circle"></i> {{ __('site.research_back_to_categories') }}
                </button>
            </div>

            <!-- Level 1: Main Keywords -->
            <div class="kw-level-label">
                <i class="bi bi-1-circle-fill" style="color:#4f46e5;"></i>
                <span>{{ __('site.research_level1_label') }}</span>
            </div>
            <div class="kw-level1-bar" id="kw-level1-bar"></div>

            <!-- Level 2: Sub-Keywords (shown when a Level 1 keyword is selected) -->
            <div class="kw-level2-wrap" id="kw-level2-wrap" style="display:none;">
                <div class="kw-level-label">
                    <i class="bi bi-2-circle-fill" style="color:#4f46e5;"></i>
                    <span>{{ __('site.research_level2_label') }}</span>
                </div>
                <div class="kw-level2-bar" id="kw-level2-bar"></div>
            </div>
        </div>

        <!-- Active Filter Title + Search/Sort Toolbar -->
        <div class="active-filter-bar">
            <h2 class="section-title" id="current-cat-title"></h2>
        </div>

        <div class="research-toolbar">
            <div class="search-box-inline">
                <i class="bi bi-search"></i>
                <input type="text" id="thesis-search" placeholder="{{ __('site.research_search_placeholder') }}">
            </div>
            <div class="toolbar-right">
                <span class="result-count-label" id="result-count-label"></span>
                <select class="sort-select" id="sort-select">
                    <option value="th_asc">{{ __('site.research_sort_th_asc') }}</option>
                    <option value="th_desc">{{ __('site.research_sort_th_desc') }}</option>
                    <option value="en_asc">{{ __('site.research_sort_en_asc') }}</option>
                    <option value="en_desc">{{ __('site.research_sort_en_desc') }}</option>
                </select>
            </div>
        </div>

        <!-- Thesis List -->
        <div class="thesis-list" id="thesis-list"></div>

        <div id="empty-state" class="empty-state" style="display:none;">
            <i class="bi bi-search"></i>
            <p>{{ __('site.research_no_results') }}</p>
        </div>

        <div class="pagination-bar" id="pagination-bar"></div>

    </div>

    <!-- ============ Loading ============ -->
    <div id="view-loading" class="loading-box">
        <div class="spinner-border spinner-border-sm-custom" role="status"></div>
        <p class="mt-3">Loading...</p>
    </div>

</div>

<!-- ============ Modal: Thesis Detail ============ -->
<div class="modal fade thesis-modal" id="thesisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <span class="modal-cat-badge" id="modal-cat-badge"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="modal-field-label">{{ __('site.research_modal_title_th') }}</div>
                <div class="modal-field-value" id="modal-title-th"></div>

                <div class="modal-field-label">{{ __('site.research_modal_title_en') }}</div>
                <div class="modal-field-value en" id="modal-title-en"></div>

                <div class="modal-field-label">{{ __('site.research_modal_advisor') }}</div>
                <div class="modal-field-value">
                    <div class="modal-advisors" id="modal-advisors"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="back-link btn" id="modal-back-btn" style="border:1px solid #4f46e5; color:#4f46e5; background:#fff; border-radius:999px;">
                    <i class="bi bi-funnel"></i> {{ __('site.research_modal_back') }}
                </button>
                <button type="button" class="btn btn-secondary" style="background:linear-gradient(135deg, #4f46e5, #ec4899); border:none; border-radius:999px;" data-bs-dismiss="modal">{{ __('site.research_modal_close') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    'use strict';

    const LOCALE = @json(app()->getLocale());
    const I18N = {
        allCat: @json(__('site.research_all_categories')),
        allSub: @json(__('site.research_all_subcategories')),
        resultsUnit: @json(__('site.research_results_count')),
        pageInfo: @json(__('site.research_page_info')),
        pageOf: @json(__('site.research_page_of')),
    };

    const PAGE_SIZE = 20;

    let CATEGORIES = [];
    let THESES = [];
    let TEACHERS = {};
    let currentCat = null;
    let currentSub = null;
    let currentPage = 1;
    let currentSort = 'th_asc';
    let currentSearch = '';
    let selectedThesis = null;

    const elLoading = document.getElementById('view-loading');
    const elViewMain = document.getElementById('view-main');
    const elKwLevel1Bar = document.getElementById('kw-level1-bar');
    const elKwLevel2Wrap = document.getElementById('kw-level2-wrap');
    const elKwLevel2Bar = document.getElementById('kw-level2-bar');
    const elBtnClearKeywords = document.getElementById('btn-clear-keywords');
    const elCurrentCatTitle = document.getElementById('current-cat-title');
    const elThesisList = document.getElementById('thesis-list');
    const elEmptyState = document.getElementById('empty-state');
    const elPaginationBar = document.getElementById('pagination-bar');
    const elSearch = document.getElementById('thesis-search');
    const elSort = document.getElementById('sort-select');
    const elResultCount = document.getElementById('result-count-label');
    const elBreadcrumb = document.getElementById('research-breadcrumb');

    const DEFAULT_ICONS = [
        'bi-robot', 'bi-lightning-charge', 'bi-sun', 'bi-cpu',
        'bi-building', 'bi-gear-wide-connected', 'bi-diagram-3',
        'bi-tree', 'bi-gem', 'bi-flower1', 'bi-heart-pulse'
    ];

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str || '';
        return div.innerHTML;
    }

    function highlight(text, query) {
        if (!text) return '';
        const safe = escapeHtml(text);
        if (!query) return safe;
        const q = query.trim();
        if (!q) return safe;
        try {
            const escaped = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            const re = new RegExp('(' + escaped + ')', 'gi');
            return safe.replace(re, '<mark>$1</mark>');
        } catch (e) {
            return safe;
        }
    }

    async function loadData() {
        try {
            const [catRes, thesesRes, teachersRes] = await Promise.all([
                fetch('/data/categories.json'),
                fetch('/data/theses.json'),
                fetch('/data/teachers.json')
            ]);
            CATEGORIES = await catRes.json();
            THESES = await thesesRes.json();
            TEACHERS = teachersRes.ok ? await teachersRes.json() : {};
            elLoading.style.display = 'none';
            elViewMain.style.display = '';
            renderAll();
        } catch (e) {
            elLoading.innerHTML = '<p class="text-danger">Failed to load research data.</p>';
            console.error(e);
        }
    }

    function resolveAdvisors(advisorCodes) {
        if (!advisorCodes || advisorCodes.length === 0) return [];
        return advisorCodes.map(code => {
            const info = TEACHERS[code];
            if (!info) {
                return { name: code, major: null, majorId: null };
            }
            const majorName = LOCALE === 'th'
                ? (info.major || info.major_en)
                : (info.major_en || info.major);
            return { name: info.name || code, major: majorName || null, majorId: info.major_id ?? null };
        });
    }

    function catName(cat) {
        return LOCALE === 'th' ? (cat.name || cat.name_en) : (cat.name_en || cat.name);
    }
    function subName(sub) {
        return LOCALE === 'th' ? (sub.name || sub.name_en) : (sub.name_en || sub.name);
    }
    function thesisMainCatName(t) {
        return LOCALE === 'th' ? (t.main_cat || t.main_cat_en) : (t.main_cat_en || t.main_cat);
    }
    function thesisSubCatName(t) {
        return LOCALE === 'th' ? (t.sub_cat || t.sub_cat_en) : (t.sub_cat_en || t.sub_cat);
    }

    function renderAll() {
        renderBreadcrumb();
        renderLevel1Bar();
        renderLevel2Bar();
        renderList();
    }

    function renderBreadcrumb() {
        let html = `<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('site.nav_home') }}</a></li>`;
        if (!currentCat) {
            html += `<li class="breadcrumb-item active">{{ __('site.nav_research') }}</li>`;
        } else {
            const cat = CATEGORIES.find(c => c.key === currentCat);
            html += `<li class="breadcrumb-item"><a href="#" id="crumb-research">{{ __('site.nav_research') }}</a></li>`;
            if (!currentSub) {
                html += `<li class="breadcrumb-item active">${escapeHtml(cat ? catName(cat) : '')}</li>`;
            } else {
                const sub = cat ? cat.subcategories.find(s => s.key === currentSub) : null;
                html += `<li class="breadcrumb-item"><a href="#" id="crumb-cat">${escapeHtml(cat ? catName(cat) : '')}</a></li>`;
                html += `<li class="breadcrumb-item active">${escapeHtml(sub ? subName(sub) : '')}</li>`;
            }
        }
        elBreadcrumb.innerHTML = html;

        const crumbResearch = document.getElementById('crumb-research');
        if (crumbResearch) {
            crumbResearch.addEventListener('click', (e) => {
                e.preventDefault();
                selectLevel1(null);
            });
        }
        const crumbCat = document.getElementById('crumb-cat');
        if (crumbCat) {
            crumbCat.addEventListener('click', (e) => {
                e.preventDefault();
                selectLevel2(null);
            });
        }
    }

    function renderLevel1Bar() {
        elKwLevel1Bar.innerHTML = '';

        const totalCount = THESES.length;
        const allBtn = document.createElement('button');
        allBtn.type = 'button';
        allBtn.className = 'kw-pill-l1' + (currentCat === null ? ' active' : '');
        allBtn.innerHTML = `
            <i class="bi bi-grid-fill"></i>
            <span>${escapeHtml(I18N.allCat)}</span>
            <span class="kw-count">${totalCount.toLocaleString()}</span>
        `;
        allBtn.addEventListener('click', () => selectLevel1(null));
        elKwLevel1Bar.appendChild(allBtn);

        CATEGORIES.forEach((cat, idx) => {
            const icon = cat.icon || DEFAULT_ICONS[idx % DEFAULT_ICONS.length];
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'kw-pill-l1' + (currentCat === cat.key ? ' active' : '');
            btn.innerHTML = `
                <i class="bi ${escapeHtml(icon)}"></i>
                <span>${escapeHtml(catName(cat))}</span>
                <span class="kw-count">${cat.count.toLocaleString()}</span>
            `;
            btn.addEventListener('click', () => selectLevel1(cat.key));
            elKwLevel1Bar.appendChild(btn);
        });

        elBtnClearKeywords.style.display = currentCat !== null ? '' : 'none';
    }

    function renderLevel2Bar() {
        if (!currentCat) {
            elKwLevel2Wrap.style.display = 'none';
            elKwLevel2Bar.innerHTML = '';
            return;
        }

        const cat = CATEGORIES.find(c => c.key === currentCat);
        if (!cat || !cat.subcategories || cat.subcategories.length === 0) {
            elKwLevel2Wrap.style.display = 'none';
            elKwLevel2Bar.innerHTML = '';
            return;
        }

        elKwLevel2Wrap.style.display = '';
        elKwLevel2Bar.innerHTML = '';

        const allChip = document.createElement('button');
        allChip.type = 'button';
        allChip.className = 'kw-pill-l2' + (currentSub === null ? ' active' : '');
        allChip.innerHTML = `
            <span>${escapeHtml(I18N.allSub)}</span>
            <span class="kw-sub-count">(${cat.count.toLocaleString()})</span>
        `;
        allChip.addEventListener('click', () => selectLevel2(null));
        elKwLevel2Bar.appendChild(allChip);

        cat.subcategories.forEach(sub => {
            const chip = document.createElement('button');
            chip.type = 'button';
            chip.className = 'kw-pill-l2' + (currentSub === sub.key ? ' active' : '');
            chip.innerHTML = `
                <span>${escapeHtml(subName(sub))}</span>
                <span class="kw-sub-count">(${sub.count.toLocaleString()})</span>
            `;
            chip.addEventListener('click', () => {
                if (currentSub === sub.key) {
                    selectLevel2(null);
                } else {
                    selectLevel2(sub.key);
                }
            });
            elKwLevel2Bar.appendChild(chip);
        });
    }

    function selectLevel1(catKey) {
        if (currentCat === catKey && currentSub === null) {
            currentCat = null;
        } else {
            currentCat = catKey;
        }
        currentSub = null;
        currentPage = 1;
        renderAll();
    }

    function selectLevel2(subKey) {
        currentSub = subKey;
        currentPage = 1;
        renderBreadcrumb();
        renderLevel2Bar();
        renderList();
    }

    function getFilteredTheses() {
        const q = currentSearch.trim().toLowerCase();
        return THESES.filter(t => {
            if (currentCat !== null) {
                const kws = Array.isArray(t.keywords) && t.keywords.length
                    ? t.keywords
                    : [{ main: t.main_cat, sub: t.sub_cat }];
                if (currentSub !== null) {
                    if (!kws.some(k => k.main === currentCat && k.sub === currentSub)) return false;
                } else {
                    if (!kws.some(k => k.main === currentCat)) return false;
                }
            }
            if (q) {
                const th = (t.title_th || '').toLowerCase();
                const en = (t.title_en || '').toLowerCase();
                if (!th.includes(q) && !en.includes(q)) return false;
            }
            return true;
        });
    }

    function sortTheses(list) {
        const sorted = list.slice();
        sorted.sort((a, b) => {
            let av, bv;
            switch (currentSort) {
                case 'th_asc':
                    av = a.title_th || ''; bv = b.title_th || '';
                    return av.localeCompare(bv, 'th');
                case 'th_desc':
                    av = a.title_th || ''; bv = b.title_th || '';
                    return bv.localeCompare(av, 'th');
                case 'en_asc':
                    av = (a.title_en || '').toLowerCase(); bv = (b.title_en || '').toLowerCase();
                    return av.localeCompare(bv);
                case 'en_desc':
                    av = (a.title_en || '').toLowerCase(); bv = (b.title_en || '').toLowerCase();
                    return bv.localeCompare(av);
                default:
                    return 0;
            }
        });
        return sorted;
    }

    function renderActiveTitle() {
        if (!currentCat) {
            elCurrentCatTitle.innerHTML = `<i class="bi bi-journal-text" style="color:#5b171e;"></i> <span>${escapeHtml(I18N.allCat)}</span>`;
            return;
        }
        const cat = CATEGORIES.find(c => c.key === currentCat);
        const mainLabel = cat ? catName(cat) : currentCat;
        if (!currentSub) {
            elCurrentCatTitle.innerHTML = `<i class="bi bi-tag-fill" style="color:#5b171e;"></i> <span>${escapeHtml(mainLabel)}</span>`;
        } else {
            const sub = cat ? cat.subcategories.find(s => s.key === currentSub) : null;
            const subLabel = sub ? subName(sub) : currentSub;
            elCurrentCatTitle.innerHTML = `
                <i class="bi bi-tag-fill" style="color:#5b171e;"></i>
                <span>${escapeHtml(mainLabel)}</span>
                <span class="sub-arrow">›</span>
                <span class="sub-highlight">${escapeHtml(subLabel)}</span>
            `;
        }
    }

    function renderList() {
        renderActiveTitle();

        let list = getFilteredTheses();
        list = sortTheses(list);

        const total = list.length;
        const totalPages = Math.max(1, Math.ceil(total / PAGE_SIZE));
        if (currentPage > totalPages) currentPage = totalPages;
        const start = (currentPage - 1) * PAGE_SIZE;
        const pageItems = list.slice(start, start + PAGE_SIZE);

        elResultCount.textContent = `${total.toLocaleString()} ${I18N.resultsUnit}`;

        elThesisList.innerHTML = '';
        if (pageItems.length === 0) {
            elEmptyState.style.display = '';
        } else {
            elEmptyState.style.display = 'none';
            pageItems.forEach(t => {
                const row = document.createElement('div');
                row.className = 'thesis-row fx-card';
                const thHtml = highlight(t.title_th, currentSearch);
                const enHtml = highlight(t.title_en, currentSearch);
                const advisors = resolveAdvisors(t.advisors);
                const advisorLine = advisors.length
                    ? `<div class="advisor-line"><i class="bi bi-person-badge"></i> ${escapeHtml(
                        advisors.map(a => a.major ? `${a.name} (${a.major})` : a.name).join(', ')
                      )}</div>`
                    : '';
                const kws = Array.isArray(t.keywords) && t.keywords.length
                    ? t.keywords
                    : [{ main: t.main_cat, main_en: t.main_cat_en, sub: t.sub_cat, sub_en: t.sub_cat_en }];
                const uniqueMains = [...new Map(kws.map(k => [k.main, LOCALE === 'th' ? k.main : (k.main_en || k.main)])).values()];
                const uniqueSubs = [...new Map(kws.map(k => [k.sub, LOCALE === 'th' ? k.sub : (k.sub_en || k.sub)])).values()];
                const tagsHtml = uniqueMains.map(m => `<span class="main-tag"><i class="bi bi-tag-fill"></i> ${escapeHtml(m)}</span>`).join('')
                    + uniqueSubs.map(s => `<span class="sub-tag">${escapeHtml(s)}</span>`).join('');
                row.innerHTML = `
                    <div class="thesis-th">${thHtml || '<span class="text-muted">—</span>'}</div>
                    <div class="thesis-en">${enHtml || ''}</div>
                    <div class="kw-tags">${tagsHtml}</div>
                    ${advisorLine}
                `;
                row.addEventListener('click', () => openThesisModal(t));
                elThesisList.appendChild(row);
            });
        }

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        elPaginationBar.innerHTML = '';
        if (totalPages <= 1) return;

        function makeBtn(label, page, opts = {}) {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'page-btn' + (opts.active ? ' active' : '');
            btn.innerHTML = label;
            btn.disabled = !!opts.disabled;
            if (!opts.disabled) {
                btn.addEventListener('click', () => {
                    currentPage = page;
                    renderList();
                    window.scrollTo({ top: elViewMain.offsetTop - 20, behavior: 'smooth' });
                });
            }
            return btn;
        }

        elPaginationBar.appendChild(makeBtn('<i class="bi bi-chevron-left"></i>', currentPage - 1, { disabled: currentPage === 1 }));

        const pagesToShow = new Set();
        pagesToShow.add(1);
        pagesToShow.add(totalPages);
        for (let p = currentPage - 1; p <= currentPage + 1; p++) {
            if (p >= 1 && p <= totalPages) pagesToShow.add(p);
        }
        const sortedPages = [...pagesToShow].sort((a,b) => a-b);

        let prevPage = null;
        sortedPages.forEach(p => {
            if (prevPage !== null && p - prevPage > 1) {
                const span = document.createElement('span');
                span.className = 'page-ellipsis';
                span.textContent = '…';
                elPaginationBar.appendChild(span);
            }
            elPaginationBar.appendChild(makeBtn(String(p), p, { active: p === currentPage }));
            prevPage = p;
        });

        elPaginationBar.appendChild(makeBtn('<i class="bi bi-chevron-right"></i>', currentPage + 1, { disabled: currentPage === totalPages }));
    }

    // ---------- Modal ----------
    const modalEl = document.getElementById('thesisModal');
    const bsModal = new bootstrap.Modal(modalEl);

    function openThesisModal(t) {
        selectedThesis = t;
        document.getElementById('modal-cat-badge').textContent = `${thesisMainCatName(t)} › ${thesisSubCatName(t)}`;
        document.getElementById('modal-title-th').textContent = t.title_th || '—';
        document.getElementById('modal-title-en').textContent = t.title_en || '—';

        const advisors = resolveAdvisors(t.advisors);
        const elAdvisors = document.getElementById('modal-advisors');
        if (advisors.length === 0) {
            elAdvisors.innerHTML = '<span class="text-muted">—</span>';
        } else {
            elAdvisors.innerHTML = advisors.map(a => {
                const label = a.major ? `${a.name} (${a.major})` : a.name;
                return `<span class="advisor-chip"><i class="bi bi-person-badge"></i> ${escapeHtml(label)}</span>`;
            }).join('');
        }

        bsModal.show();
    }

    document.getElementById('modal-back-btn').addEventListener('click', () => {
        bsModal.hide();
        if (selectedThesis) {
            currentCat = selectedThesis.main_cat;
            currentSub = selectedThesis.sub_cat;
            currentPage = 1;
            renderAll();
            window.scrollTo({ top: elViewMain.offsetTop - 20, behavior: 'smooth' });
        }
    });

    // ---------- Events ----------
    elBtnClearKeywords.addEventListener('click', () => {
        selectLevel1(null);
    });

    let searchDebounce;
    elSearch.addEventListener('input', () => {
        clearTimeout(searchDebounce);
        searchDebounce = setTimeout(() => {
            currentSearch = elSearch.value;
            currentPage = 1;
            renderList();
        }, 200);
    });

    elSort.addEventListener('change', () => {
        currentSort = elSort.value;
        currentPage = 1;
        renderList();
    });

    // ---------- Init ----------
    loadData();
})();
</script>
@endpush

@endsection
