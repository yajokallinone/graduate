@extends('layouts.app')

@section('title', __('site.nav_programs'))

@section('content')
@php
    $majorCovers = [
        'construction_engineering_meng' => 'images/programs/prog-civil.jpg',
        'civil_engineering_meng' => 'images/programs/prog-civil.jpg',
        'civil_engineering_phd' => 'images/programs/prog-civil.jpg',
        'data_science_meng' => 'images/programs/prog-datascience.jpg',
        'data_science_phd' => 'images/programs/prog-datascience.jpg',
        'geo_resource_engineering_meng' => 'images/programs/prog-mining.jpg',
        'electrical_engineering_meng' => 'images/programs/prog-electrical.jpg',
        'electrical_engineering_phd' => 'images/programs/prog-electrical.jpg',
        'industial_engineering_master' => 'images/programs/prog-industrial.jpg',
        'industial_engineering_phd' => 'images/programs/prog-industrial.jpg',
        'logging_engineering_meng' => 'images/programs/prog-industrial.jpg',
        'industial_management_master' => 'images/programs/prog-industrial.jpg',
        'me_master' => 'images/programs/prog-mechanical.jpg',
        'me_phd' => 'images/programs/prog-mechanical.jpg',
        'advanced_computational_engineering_master' => 'images/programs/prog-mechanical.jpg',
        'energy_master' => 'images/programs/prog-energy.jpg',
        'energy_phd' => 'images/programs/prog-energy.jpg',
        'agricultural_engineering_meng' => 'images/programs/prog-energy.jpg',
        'computer_engineering_meng' => 'images/programs/prog-computer.jpg',
        'plasma_microelectromechanical_systems_engineering_meng' => 'images/programs/prog-plasma.jpg',
        'plasma_microelectromechanical_systems_engineering_phd' => 'images/programs/prog-plasma.jpg',
        'env_ms' => 'images/programs/prog-environmental.jpg',
        'env_phd' => 'images/programs/prog-environmental.jpg',
    ];
@endphp

<style>
    /* Hero Banner (Modern Youthful Gradient + Banner Image) */
    .hero-banner {
        background:
            linear-gradient(125deg, rgba(15, 23, 42, 0.88) 0%, rgba(49, 46, 129, 0.80) 50%, rgba(131, 24, 67, 0.76) 100%),
            url('{{ asset("images/banner-programs.png") }}');
        background-size: cover;
        background-position: center;
        padding: 90px 0 74px;
        color: white;
        text-align: center;
        margin-bottom: 40px;
        border-bottom-left-radius: 32px;
        border-bottom-right-radius: 32px;
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.14);
        position: relative;
        overflow: hidden;
    }

    .hero-banner h1 {
        font-size: 2.7rem;
        font-weight: 800;
        margin-bottom: 10px;
        letter-spacing: -0.02em;
        background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 60%, #fbcfe8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 4px 18px rgba(0, 0, 0, 0.3));
    }

    .hero-banner p {
        font-size: 1.1rem;
        color: #e0e7ff;
        opacity: 0.95;
    }

    /* Search Section */
    .search-section {
        background: transparent;
        padding: 12px 0 36px;
        text-align: center;
        margin-bottom: 24px;
    }

    .search-section h2 {
        font-size: 1.9rem;
        font-weight: 800;
        margin-bottom: 18px;
        background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 55%, #db2777 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }

    .search-box {
        display: flex;
        max-width: 560px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 12px 32px rgba(99, 102, 241, 0.12);
        border: 1.5px solid rgba(99, 102, 241, 0.22);
        border-radius: 999px;
        overflow: hidden;
        padding: 6px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .search-box:focus-within {
        border-color: #6366f1;
        box-shadow: 0 16px 38px rgba(99, 102, 241, 0.25);
        transform: translateY(-2px);
    }

    .search-box input {
        flex: 1;
        padding: 10px 22px;
        border: none;
        font-size: 0.96rem;
        color: #0f172a;
        background: transparent;
    }

    .search-box input::placeholder {
        color: #94a3b8;
    }

    .search-box input:focus {
        outline: none;
    }

    .search-box button {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 999px;
        cursor: pointer;
        font-weight: 700;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(99, 102, 241, 0.3);
    }

    .search-box button:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(236, 72, 153, 0.4);
    }

    /* Filter and Results Container */
    .programs-container {
        display: grid;
        grid-template-columns: 275px 1fr;
        gap: 36px;
        margin-bottom: 48px;
        align-items: start;
    }

    @media (max-width: 1024px) {
        .programs-container {
            grid-template-columns: 225px 1fr;
            gap: 28px;
        }
    }

    @media (max-width: 768px) {
        .programs-container {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    /* Sidebar */
    .filter-sidebar {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.14);
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06);
        position: sticky;
        top: 90px;
    }

    .filter-section {
        margin-bottom: 28px;
    }

    .filter-section:last-child {
        margin-bottom: 0;
    }

    .filter-section h6 {
        font-size: 0.84rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #4f46e5;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 2px solid rgba(99, 102, 241, 0.14);
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
        padding: 7px 10px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-group:hover {
        background: rgba(99, 102, 241, 0.08);
    }

    .filter-group input {
        cursor: pointer;
        width: 17px;
        height: 17px;
        accent-color: #4f46e5;
    }

    .filter-group label {
        font-size: 0.88rem;
        color: #334155;
        cursor: pointer;
        margin: 0;
        flex: 1;
        font-weight: 500;
    }

    /* Results Section */
    .results-section {
        padding: 0;
    }

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 14px;
        border-bottom: 2px solid rgba(99, 102, 241, 0.14);
    }

    .results-header h3 {
        font-size: 1.22rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .results-count {
        color: #4f46e5;
        font-size: 0.98rem;
        font-weight: 800;
    }

    .clear-filters {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.2);
        padding: 7px 16px;
        border-radius: 999px;
        text-decoration: none;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .clear-filters:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #fff;
        border-color: transparent;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
    }

    /* Program Cards with Major Cover Image + Logo Emblem */
    .program-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
    }

    .program-card {
        display: grid;
        grid-template-columns: 295px 1fr;
        gap: 26px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.94);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(99, 102, 241, 0.14);
        border-radius: 24px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 10px 30px -12px rgba(15, 23, 42, 0.06);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @media (max-width: 768px) {
        .program-card {
            grid-template-columns: 1fr;
        }
    }

    .program-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 22px 44px -12px rgba(99, 102, 241, 0.22);
        border-color: rgba(99, 102, 241, 0.45);
        background: #ffffff;
    }

    .program-image {
        width: 100%;
        height: 225px;
        border-radius: 18px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #312e81 0%, #4f46e5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .program-image img.major-cover-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .program-card:hover .program-image img.major-cover-img {
        transform: scale(1.09);
    }

    .program-image::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.04) 0%, rgba(30, 27, 75, 0.52) 100%);
        pointer-events: none;
    }

    .program-logo-badge {
        position: absolute;
        bottom: 12px;
        right: 12px;
        width: 54px;
        height: 54px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.96);
        padding: 6px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.28);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        transition: transform 0.3s ease;
    }

    .program-card:hover .program-logo-badge {
        transform: scale(1.1) rotate(-4deg);
    }

    .program-logo-badge img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .program-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .program-info h3 {
        font-size: 1.22rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 6px;
        transition: color 0.25s;
    }

    .program-card:hover .program-info h3 {
        color: #4f46e5;
    }

    .program-meta {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 16px;
        padding: 14px 16px;
        background: #f8fafc;
        border: 1px solid rgba(99, 102, 241, 0.1);
        border-radius: 14px;
        font-size: 0.85rem;
        color: #475569;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-item i {
        color: #6366f1;
        font-size: 0.98rem;
    }

    .program-category {
        display: inline-block;
        width: fit-content;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        color: #ffffff;
        padding: 4px 14px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        margin-bottom: 8px;
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.28);
    }

    .program-major {
        color: #6366f1;
        font-weight: 600;
        font-size: 0.92rem;
        margin-bottom: 14px;
    }

    .program-price {
        font-size: 0.95rem;
        font-weight: 700;
        color: #4f46e5;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .program-price::before {
        content: "\F5C1";
        font-family: "bootstrap-icons";
        font-size: 0.9rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
        background: #fff;
        border-radius: 20px;
        border: 1.5px dashed rgba(99, 102, 241, 0.25);
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    @media (max-width: 576px) {
        .hero-banner h1 {
            font-size: 1.85rem;
        }

        .program-meta {
            grid-template-columns: 1fr;
        }

        .program-card {
            padding: 16px;
        }
    }
</style>

<!-- Hero Banner -->
<div class="hero-banner">
    <div class="container">
        <h1>{{ __('site.nav_programs') }}</h1>
        <p>{{ __('site.programs_title') }}</p>
    </div>
</div>

<!-- Search Section -->
<div class="search-section">
    <div class="container" style="max-width: 800px;">
        <h2>{{ __('site.programs_find_program') }}</h2>

        <div class="search-box">
            <input type="text" id="filter-search" placeholder="{{ __('site.programs_search_placeholder') }}">
            <button type="button" onclick="document.getElementById('filter-search').focus();">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
</div>

<div class="container">

    <!-- Programs Container -->
    <div class="programs-container">

        <!-- Sidebar Filters -->
        <aside class="filter-sidebar">

            <!-- Clear Filters -->
            <a href="#" class="clear-filters" onclick="location.reload(); return false;">
                ✕ {{ __('site.programs_reset_filters') }}
            </a>

            <!-- Degree Filter -->
            <div class="filter-section" style="margin-top: 24px;">
                <h6>{{ __('site.programs_degree_label') }}</h6>
                @foreach ($optDegrees as $d)
                    @php
                        // Find the _en version from programs.php
                        $programs = config('programs');
                        $degreeEn = null;
                        foreach ($programs as $prog) {
                            if (($prog['degree'] ?? null) === $d) {
                                $degreeEn = $prog['degree_en'] ?? $d;
                                break;
                            }
                        }
                        $displayLabel = app()->getLocale() === 'th' ? $d : ($degreeEn ?? $d);
                    @endphp
                    <div class="filter-group">
                        <input type="radio" name="degree" id="degree-{{ $loop->index }}"
                               value="{{ htmlspecialchars($d) }}" class="degree-filter">
                        <label for="degree-{{ $loop->index }}">{{ htmlspecialchars($displayLabel) }}</label>
                    </div>
                @endforeach
            </div>

            <!-- Department Filter -->
            <div class="filter-section">
                <h6>{{ __('site.programs_department_label') }}</h6>
                @foreach ($optDepartments as $d)
                    @php
                        // Find the _en version from programs.php
                        $programs = config('programs');
                        $majorEn = null;
                        foreach ($programs as $prog) {
                            if (($prog['major'] ?? null) === $d) {
                                $majorEn = $prog['major_en'] ?? $d;
                                break;
                            }
                        }
                        $displayLabel = app()->getLocale() === 'th' ? $d : ($majorEn ?? $d);
                    @endphp
                    <div class="filter-group">
                        <input type="radio" name="department" id="dept-{{ $loop->index }}"
                               value="{{ htmlspecialchars($d) }}" class="dept-filter">
                        <label for="dept-{{ $loop->index }}">{{ htmlspecialchars($displayLabel) }}</label>
                    </div>
                @endforeach
            </div>

        </aside>

        <!-- Main Results -->
        <main class="results-section">

            <!-- Results Header -->
            <div class="results-header">
                <h3>
                    {{ __('site.programs_title') }}
                    <span class="results-count" id="result-count">({{ count($programs) }})</span>
                </h3>
            </div>

            <!-- Program List -->
            <div class="program-list" id="cards-container">

                @foreach ($programs as $code => $program)
                    @php
                        $dataSearch = htmlspecialchars(
                            ($program['title'] ?? '') . ' ' .
                            ($program['title_en'] ?? '') . ' ' .
                            ($program['major'] ?? '') . ' ' .
                            ($program['major_en'] ?? '') . ' ' .
                            ($program['degree'] ?? '') . ' ' .
                            ($program['degree_en'] ?? '')
                        );
                        $coverImg = $majorCovers[$code] ?? 'images/banner-programs.png';
                    @endphp

                    <a href="{{ route('programs.show', $code) }}" class="program-card program-item fx-card"
                       data-degree="{{ htmlspecialchars($program['degree'] ?? '') }}"
                       data-department="{{ htmlspecialchars($program['major'] ?? '') }}"
                       data-search="{{ $dataSearch }}">

                        <!-- Major Cover Image + Logo Badge -->
                        <div class="program-image">
                            <img src="{{ asset($coverImg) }}" class="major-cover-img" alt="{{ $program['title'] ?? '' }}">
                            @if (!empty($program['img']))
                                <div class="program-logo-badge">
                                    <img src="{{ asset($program['img']) }}" alt="{{ $program['major'] ?? '' }}">
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="program-info">
                            <div class="program-category">
                                {{ app()->getLocale() === 'th' ? ($program['degree'] ?? '') : ($program['degree_en'] ?? $program['degree'] ?? '') }}
                            </div>
                            <h3>{{ app()->getLocale() === 'th' ? ($program['title'] ?? '') : ($program['title_en'] ?? $program['title'] ?? '') }}</h3>
                            <p class="program-major">
                                {{ app()->getLocale() === 'th' ? ($program['major'] ?? '') : ($program['major_en'] ?? $program['major'] ?? '') }}
                            </p>

                            @if (!empty($program['plans']))
                                @php $plan = $program['plans'][0]; @endphp
                                <div class="program-meta">
                                    <div class="meta-item">
                                        <i class="bi bi-book"></i>
                                        <span>
                                            @if (app()->getLocale() === 'th')
                                                {{ is_array($plan['credit'] ?? null) ? $plan['credit'][0] : ($plan['credit'] ?? '') }}
                                            @else
                                                @if (!empty($plan['credit_en']))
                                                    {{ is_array($plan['credit_en']) ? $plan['credit_en'][0] : $plan['credit_en'] }}
                                                @else
                                                    {{ is_array($plan['credit'] ?? null) ? $plan['credit'][0] : ($plan['credit'] ?? '') }}
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ app()->getLocale() === 'th' ? ($plan['date_study'] ?? '') : ($plan['date_study_en'] ?? $plan['date_study'] ?? '') }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-clock"></i>
                                        <span>{{ app()->getLocale() === 'th' ? ($plan['duration'] ?? '') : ($plan['duration_en'] ?? $plan['duration'] ?? '') }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="bi bi-cash"></i>
                                        <span>
                                            @if (app()->getLocale() === 'th')
                                                {{ is_array($plan['fee'] ?? null) ? $plan['fee'][0] : ($plan['fee'] ?? '') }}
                                            @else
                                                @if (!empty($plan['fee_en']))
                                                    {{ is_array($plan['fee_en']) ? $plan['fee_en'][0] : $plan['fee_en'] }}
                                                @else
                                                    {{ is_array($plan['fee'] ?? null) ? $plan['fee'][0] : ($plan['fee'] ?? '') }}
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <div class="program-price">
                                {{ $program['contact'] ?? '-' }}
                            </div>
                        </div>

                    </a>
                @endforeach

                <!-- No Results -->
                <div id="no-results" class="empty-state" style="display: none; grid-column: 1/-1;">
                    <i class="bi bi-search"></i>
                    <p>{{ __('site.programs_no_results') }}</p>
                </div>

            </div>

        </main>

    </div>

</div>

@push('scripts')
<script>
(function () {
    const search = document.getElementById('filter-search');
    const degreeRadios = document.querySelectorAll('.degree-filter');
    const deptRadios = document.querySelectorAll('.dept-filter');
    const noResults = document.getElementById('no-results');
    const count = document.getElementById('result-count');
    const items = document.querySelectorAll('.program-item');

    function filter() {
        const q = search.value.trim().toLowerCase();
        const degree = [...degreeRadios].find(r => r.checked)?.value || '';
        const dept = [...deptRadios].find(r => r.checked)?.value || '';
        let visible = 0;

        items.forEach(el => {
            const match = (!q || el.dataset.search.toLowerCase().includes(q)) &&
                         (!degree || el.dataset.degree === degree) &&
                         (!dept || el.dataset.department === dept);
            el.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        noResults.style.display = visible === 0 ? '' : 'none';
        count.textContent = `(${visible})`;
    }

    search.addEventListener('input', filter);
    degreeRadios.forEach(r => r.addEventListener('change', filter));
    deptRadios.forEach(r => r.addEventListener('change', filter));
})();
</script>
@endpush

@endsection
