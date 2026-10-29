@extends('layouts.app')

@section('title', \App\Support\ProgramTranslator::translate($program, 'title') ?: 'Program Details')

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
    $coverImg = $majorCovers[$code ?? ''] ?? 'images/banner-programs.png';
@endphp

<style>
    .program-header {
        background:
            linear-gradient(125deg, rgba(15, 23, 42, 0.88) 0%, rgba(49, 46, 129, 0.78) 50%, rgba(131, 24, 67, 0.75) 100%),
            url('{{ asset($coverImg) }}');
        background-size: cover;
        background-position: center;
        padding: 80px 0 68px;
        border-bottom-left-radius: 32px;
        border-bottom-right-radius: 32px;
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.14);
        margin-bottom: 40px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .program-header h1 {
        font-size: clamp(1.85rem, 3.3vw, 2.6rem);
        font-weight: 800;
        color: #fff;
        margin-bottom: 8px;
        text-shadow: 0 4px 18px rgba(0, 0, 0, 0.35);
    }

    .program-header p {
        font-size: 1.08rem;
        color: #c7d2fe;
        font-weight: 600;
        margin: 0;
    }

    .details-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(12px);
        border-radius: 26px;
        padding: 42px;
        box-shadow: 0 18px 44px -12px rgba(79, 70, 229, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.16);
        margin-bottom: 40px;
    }

    /* Major Visual Showcase + Program Info */
    .program-info {
        display: grid;
        grid-template-columns: 330px 1fr;
        gap: 34px;
        margin-bottom: 40px;
        padding-bottom: 36px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.14);
        align-items: center;
    }

    .program-visual-showcase {
        position: relative;
        height: 215px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 14px 32px rgba(79, 70, 229, 0.2);
        border: 2px solid rgba(99, 102, 241, 0.2);
    }

    .program-visual-showcase img.major-photo {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .program-visual-showcase:hover img.major-photo {
        transform: scale(1.08);
    }

    .program-logo {
        position: absolute;
        bottom: 12px;
        right: 12px;
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.96);
        padding: 8px;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.25);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .program-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .program-details h3 {
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.06em;
        margin-bottom: 8px;
    }

    .program-details p {
        font-size: 1.08rem;
        color: #4f46e5;
        margin: 0;
        font-weight: 700;
    }

    .degree-badge {
        display: inline-block;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        color: white;
        padding: 8px 20px;
        border-radius: 999px;
        font-size: 0.88rem;
        font-weight: 700;
        margin-top: 4px;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.3);
    }

    /* Plans */
    .plans-title {
        font-size: 1.45rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 55%, #db2777 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
        margin-bottom: 24px;
    }

    .plan-card {
        background: #f8fafc;
        border: 1px solid rgba(99, 102, 241, 0.16);
        border-left: 5px solid #6366f1;
        border-radius: 18px;
        padding: 26px;
        margin-bottom: 22px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .plan-card:hover {
        background: #ffffff;
        transform: translateY(-4px);
        box-shadow: 0 16px 34px rgba(99, 102, 241, 0.12);
    }

    .plan-title {
        font-size: 1.16rem;
        font-weight: 800;
        color: #4f46e5;
        margin-bottom: 4px;
    }

    .plan-subtitle {
        font-size: 0.92rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .plan-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    @media (max-width: 768px) {
        .plan-grid {
            grid-template-columns: 1fr;
        }

        .program-info {
            grid-template-columns: 1fr;
        }

        .details-card {
            padding: 22px;
        }
    }

    .plan-item {
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid rgba(99, 102, 241, 0.1);
    }

    .plan-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .plan-label {
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #4f46e5;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .plan-value {
        font-size: 0.95rem;
        color: #0f172a;
        line-height: 1.65;
    }

    .plan-value ul {
        margin: 0;
        padding-left: 20px;
    }

    .plan-value li {
        margin-bottom: 4px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        background: white;
        color: #4f46e5;
        border: 1.5px solid rgba(99, 102, 241, 0.35);
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.92rem;
        transition: all 0.25s ease;
    }

    .back-btn:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        border-color: transparent;
        color: white;
        transform: translateX(-4px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }
</style>

<!-- Header -->
<div class="program-header">
    <div class="container">
        <h1>{{ \App\Support\ProgramTranslator::translate($program, 'title') }}</h1>
        <p>{{ \App\Support\ProgramTranslator::translate($program, 'major') }}</p>
    </div>
</div>

<!-- Details -->
<div class="container">
    <div class="details-card">

        <!-- Program Info with Major Cover Photo + Logo -->
        <div class="program-info">
            <div class="program-visual-showcase">
                <img src="{{ asset($coverImg) }}" class="major-photo" alt="{{ \App\Support\ProgramTranslator::translate($program, 'title') }}">
                <div class="program-logo">
                    @if (!empty($program['img']))
                        <img src="{{ asset($program['img']) }}" alt="{{ \App\Support\ProgramTranslator::translate($program, 'title') }}">
                    @else
                        <i class="bi bi-mortarboard" style="font-size: 2rem; color: #4f46e5;"></i>
                    @endif
                </div>
            </div>

            <div class="program-details">
                <div>
                    <h3>{{ __('site.details_degree') }}</h3>
                    <span class="degree-badge">{{ \App\Support\ProgramTranslator::translate($program, 'degree') }}</span>
                </div>

                <div style="margin-top: 20px;">
                    <h3>{{ __('site.details_contact') }}</h3>
                    <p>{{ \App\Support\ProgramTranslator::translate($program, 'contact') ?: '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Study Plans -->
        <h2 class="plans-title">{{ __('site.details_plans') }}</h2>

        @if (!empty($program['plans']))
            @foreach ($program['plans'] as $plan)
                <div class="plan-card fx-card">
                    <div class="plan-title">
                        {{ \App\Support\ProgramTranslator::translate($plan, 'plan_name') }}
                    </div>
                    <div class="plan-subtitle">
                        {{ \App\Support\ProgramTranslator::translate($plan, 'study_type') }}
                    </div>

                    <div class="plan-grid">
                        <!-- Left -->
                        <div>
                            <div class="plan-item">
                                <div class="plan-label">{{ __('site.details_credits') }}</div>
                                <div class="plan-value">
                                    {!! \App\Support\ProgramTranslator::translate($plan, 'credit') !!}
                                </div>
                            </div>

                            <div class="plan-item">
                                <div class="plan-label">{{ __('site.details_duration') }}</div>
                                <div class="plan-value">
                                    {{ \App\Support\ProgramTranslator::translate($plan, 'duration') }}
                                </div>
                            </div>

                            <div class="plan-item">
                                <div class="plan-label">{{ __('site.details_study_days') }}</div>
                                <div class="plan-value">
                                    {{ \App\Support\ProgramTranslator::translate($plan, 'date_study') }}
                                </div>
                            </div>
                        </div>

                        <!-- Right -->
                        <div>
                            <div class="plan-item">
                                <div class="plan-label">{{ __('site.details_fee') }}</div>
                                <div class="plan-value">
                                    {!! \App\Support\ProgramTranslator::translate($plan, 'fee') !!}
                                </div>
                            </div>

                            <div class="plan-item">
                                <div class="plan-label">{{ __('site.details_qualifications') }}</div>
                                <div class="plan-value">
                                    {!! \App\Support\ProgramTranslator::translate($plan, 'qualification') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>{{ __('site.details_not_found') }}</p>
        @endif

        <!-- Back Button -->
        <div style="margin-top: 32px;">
            <a href="{{ route('programs.index') }}" class="back-btn">
                ← {{ __('site.details_back') }}
            </a>
        </div>

    </div>
</div>

@endsection
