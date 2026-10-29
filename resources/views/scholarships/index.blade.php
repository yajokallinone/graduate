@extends('layouts.app')

@section('title', app()->getLocale() === 'th' ? 'ทุนการศึกษา' : 'Scholarships')

@section('content')

<style>
    .page-header {
        background:
            linear-gradient(125deg, rgba(15, 23, 42, 0.88) 0%, rgba(49, 46, 129, 0.80) 50%, rgba(131, 24, 67, 0.76) 100%),
            url('{{ asset("images/banner-scholarships.png") }}');
        background-size: cover;
        background-position: center;
        padding: 84px 0 70px;
        border-bottom-left-radius: 32px;
        border-bottom-right-radius: 32px;
        box-shadow: 0 20px 44px rgba(79, 70, 229, 0.14);
        margin-bottom: 48px;
        text-align: center;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .page-header h1 {
        font-size: 2.6rem;
        font-weight: 800;
        margin: 0;
        background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 60%, #fbcfe8 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 4px 18px rgba(0, 0, 0, 0.3));
    }

    .page-header p {
        font-size: 1.08rem;
        color: #e0e7ff;
        margin-top: 10px;
    }

    .content-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-radius: 24px;
        border: 1px solid rgba(99, 102, 241, 0.15);
        padding: 40px;
        box-shadow: 0 12px 34px -10px rgba(15, 23, 42, 0.06);
        max-width: 940px;
        margin: 0 auto 32px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .content-card:hover {
        box-shadow: 0 18px 42px -10px rgba(99, 102, 241, 0.14);
    }

    .section-title {
        font-size: 1.38rem;
        font-weight: 800;
        background: linear-gradient(135deg, #1e1b4b 0%, #4f46e5 55%, #db2777 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #4f46e5;
        -webkit-text-fill-color: #4f46e5;
        font-size: 1.35rem;
    }

    .section-subtitle {
        font-size: 0.94rem;
        color: #64748b;
        margin-bottom: 20px;
    }

    .placeholder-note {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fef3c7;
        border: 1px solid #fde68a;
        color: #92400e;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 5px 14px;
        border-radius: 999px;
        margin-bottom: 20px;
    }

    /* Scholarship type cards */
    .scholarship-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 8px;
    }

    .scholarship-card {
        border: 1px solid rgba(99, 102, 241, 0.15);
        border-top: 4px solid #6366f1;
        border-radius: 18px;
        padding: 24px;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .scholarship-card:hover {
        background: #fff;
        border-color: #6366f1;
        transform: translateY(-5px);
        box-shadow: 0 18px 36px -10px rgba(99, 102, 241, 0.18);
    }

    .scholarship-card-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 12px;
    }

    .scholarship-card-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;
        border-radius: 14px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.14) 0%, rgba(236, 72, 153, 0.12) 100%);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        transition: all 0.3s ease;
    }

    .scholarship-card:hover .scholarship-card-icon {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        color: #fff;
        transform: scale(1.08) rotate(-5deg);
        box-shadow: 0 8px 18px rgba(99, 102, 241, 0.3);
    }

    .scholarship-card-title {
        font-size: 1.04rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
    }

    .scholarship-card-amount {
        font-size: 0.8rem;
        color: #4f46e5;
        font-weight: 700;
    }

    .scholarship-card-desc {
        font-size: 0.88rem;
        color: #475569;
        line-height: 1.65;
        margin-bottom: 12px;
    }

    .scholarship-card-eligibility {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #4f46e5;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .scholarship-card ul {
        margin: 0;
        padding-left: 18px;
        font-size: 0.85rem;
        color: #475569;
        line-height: 1.7;
    }

    .scholarship-card-links {
        margin-top: auto;
        padding-top: 14px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .scholarship-pdf-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 700;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.1);
        border: 1px solid rgba(99, 102, 241, 0.22);
        padding: 5px 12px;
        border-radius: 999px;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .scholarship-pdf-pill:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #ffffff;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(99, 102, 241, 0.3);
    }

    /* Timeline / steps */
    .steps-list {
        list-style: none;
        margin: 0;
        padding: 0;
        counter-reset: step-counter;
    }

    .step-item {
        display: flex;
        gap: 16px;
        position: relative;
        padding-bottom: 24px;
    }

    .step-item:last-child {
        padding-bottom: 0;
    }

    .step-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 38px;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, rgba(99, 102, 241, 0.35), rgba(236, 72, 153, 0.2));
    }

    .step-number {
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 55%, #ec4899 100%);
        color: white;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
        box-shadow: 0 6px 14px rgba(99, 102, 241, 0.3);
        transition: transform 0.3s ease;
    }

    .step-item:hover .step-number {
        transform: scale(1.12);
    }

    .step-body {
        padding-top: 4px;
    }

    .step-title {
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .step-desc {
        font-size: 0.86rem;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 6px;
    }

    .step-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        font-weight: 600;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.08);
        border: 1px solid rgba(99, 102, 241, 0.2);
        padding: 3px 12px;
        border-radius: 999px;
    }

    /* Documents */
    .document-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .document-item {
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid rgba(99, 102, 241, 0.16);
        border-radius: 16px;
        padding: 16px 20px;
        text-decoration: none;
        background: #f8fafc;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .document-item:hover {
        border-color: #6366f1;
        background: #fff;
        transform: translateX(6px);
        box-shadow: 0 12px 26px -6px rgba(99, 102, 241, 0.16);
    }

    .document-icon {
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        border-radius: 13px;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.12) 0%, rgba(236, 72, 153, 0.12) 100%);
        color: #4f46e5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: all 0.25s ease;
    }

    .document-item:hover .document-icon {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #fff;
        transform: scale(1.06);
    }

    .document-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #0f172a;
    }

    .document-format {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 600;
    }

    .document-download {
        margin-left: auto;
        font-size: 0.84rem;
        font-weight: 700;
        color: #4f46e5;
        background: rgba(99, 102, 241, 0.08);
        padding: 6px 14px;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
        transition: all 0.25s ease;
    }

    .document-item:hover .document-download {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        color: #fff;
    }

    /* Contact (existing) */
    .contact-section {
        background: #f8fafc;
        border-left: 4px solid #6366f1;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 0;
    }

    .contact-label {
        font-size: 0.76rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #4f46e5;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .contact-label i {
        margin-right: 6px;
    }

    .contact-text {
        font-size: 0.95rem;
        color: #1e293b;
        line-height: 1.6;
        margin-bottom: 12px;
    }

    .contact-text strong {
        font-weight: 700;
    }

    .contact-phone {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: #4f46e5;
        font-size: 1.06rem;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid rgba(99, 102, 241, 0.14);
    }

    .contact-phone i {
        font-size: 1.1rem;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        background: white;
        color: #4f46e5;
        border: 1.5px solid rgba(99, 102, 241, 0.35);
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.25s ease;
    }

    .back-link:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
        border-color: transparent;
        color: white;
        transform: translateX(-3px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
    }

    @media (max-width: 768px) {
        .scholarship-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .content-card {
            padding: 20px;
        }

        .page-header h1 {
            font-size: 1.7rem;
        }

        .document-item {
            flex-wrap: wrap;
        }

        .document-download {
            margin-left: 62px;
        }
    }
</style>

{{--
    วิธีแก้ไขเนื้อหา:
    ทุกข้อความเขียนแบบ {{ $th ? 'ข้อความภาษาไทย' : 'English text' }}
    แก้เฉพาะข้อความในเครื่องหมาย '...' ได้เลย (ถ้าข้อความมี ' ให้ใส่ \' แทน)
--}}
@php $th = app()->getLocale() === 'th'; @endphp

<!-- Header -->
<div class="page-header">
    <div class="container">
        <h1>{{ $th ? 'ทุนการศึกษา' : 'Scholarships' }}</h1>
        <p>{{ $th ? 'ข้อมูลทุนการศึกษาสำหรับนักศึกษาระดับบัณฑิตศึกษา คณะวิศวกรรมศาสตร์' : 'Scholarship information for graduate students at the Faculty of Engineering' }}</p>
    </div>
</div>

<div class="container">

    {{-- ประเภททุนการศึกษา และ ขั้นตอนการสมัคร (ซ่อนไว้ แสดงเฉพาะเอกสารดาวน์โหลด)
    <div class="content-card">
        <div class="section-title">
            <i class="bi bi-award"></i>
            {{ $th ? 'ประเภททุนการศึกษา' : 'Scholarship Types' }}
        </div>
        ...
    </div>
    --}}

    <!-- เอกสารดาวน์โหลด (ลิงก์ไปยังไฟล์ PDF ทั้ง 4 ไฟล์) -->
    <div class="content-card">
        <div class="section-title">
            <i class="bi bi-file-earmark-arrow-down"></i>
            {{ $th ? 'เอกสารดาวน์โหลด' : 'Documents' }}
        </div>
        <div class="section-subtitle">{{ $th ? 'แบบฟอร์มและประกาศที่เกี่ยวข้องกับการสมัครทุนการศึกษา' : 'Forms and announcements related to scholarship applications' }}</div>

        <div class="document-list">
            <a href="{{ asset('docs/scholarships/CMUGS_2569_th.pdf') }}" class="document-item fx-card" target="_blank" rel="noopener">
                <div class="document-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="document-name">{{ $th ? 'ประกาศมหาวิทยาลัยเชียงใหม่ เรื่อง ทุนบัณฑิตศึกษามหาวิทยาลัยเชียงใหม่ ปีการศึกษา 2569 (ภาษาไทย)' : 'CMU Graduate Scholarship Announcement Academic Year 2026 (Thai Version)' }}</div>
                    <div class="document-format">PDF • CMUGS_2569_th.pdf</div>
                </div>
                <div class="document-download"><i class="bi bi-download"></i> {{ $th ? 'ดาวน์โหลด' : 'Download' }}</div>
            </a>

            <a href="{{ asset('docs/scholarships/Announcement_2026_en.pdf') }}" class="document-item fx-card" target="_blank" rel="noopener">
                <div class="document-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="document-name">{{ $th ? 'ประกาศทุนบัณฑิตศึกษามหาวิทยาลัยเชียงใหม่ ปีการศึกษา 2569 (ภาษาอังกฤษ - CMU Graduate Scholarship 2026)' : 'Chiang Mai University Announcement: CMU Graduate Scholarship Academic Year 2026 (English Version)' }}</div>
                    <div class="document-format">PDF • Announcement_2026_en.pdf</div>
                </div>
                <div class="document-download"><i class="bi bi-download"></i> {{ $th ? 'ดาวน์โหลด' : 'Download' }}</div>
            </a>

            <a href="{{ asset('docs/scholarships/69_tara_th.pdf') }}" class="document-item fx-card" target="_blank" rel="noopener">
                <div class="document-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="document-name">{{ $th ? 'ประกาศมหาวิทยาลัยเชียงใหม่ เรื่อง ทุนผู้ช่วยสอนและทุนผู้ช่วยวิจัย (TA/RA) ปีการศึกษา 2569 (ภาษาไทย)' : 'Teaching Assistant and Research Assistant Scholarships (TA/RA) Academic Year 2026 (Thai Version)' }}</div>
                    <div class="document-format">PDF • 69_tara_th.pdf</div>
                </div>
                <div class="document-download"><i class="bi bi-download"></i> {{ $th ? 'ดาวน์โหลด' : 'Download' }}</div>
            </a>

            <a href="{{ asset('docs/scholarships/69_tara_en.pdf') }}" class="document-item fx-card" target="_blank" rel="noopener">
                <div class="document-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="document-name">{{ $th ? 'ประกาศทุนผู้ช่วยสอนและทุนผู้ช่วยวิจัย (TA/RA) ปีการศึกษา 2569 (ภาษาอังกฤษ - TA/RA Scholarships 2026)' : 'Teaching Assistant and Research Assistant Scholarships (TA/RA) Academic Year 2026 (English Version)' }}</div>
                    <div class="document-format">PDF • 69_tara_en.pdf</div>
                </div>
                <div class="document-download"><i class="bi bi-download"></i> {{ $th ? 'ดาวน์โหลด' : 'Download' }}</div>
            </a>
        </div>

        <div style="margin-top: 28px;">
            <a href="{{ route('home') }}" class="back-link">← {{ $th ? 'กลับไปหน้าแรก' : 'Back to Home' }}</a>
        </div>
    </div>

    {{-- ติดต่อสอบถาม (ซ่อนไว้ แสดงเฉพาะเอกสารดาวน์โหลด)
    <div class="content-card">
        <div class="contact-section">
            <div class="contact-label">
                <i class="bi bi-info-circle"></i>
                {{ $th ? 'ข้อมูลเพิ่มเติม' : 'Further Information' }}
            </div>
            <p class="contact-text">
                {{ $th ? 'โปรดติดต่อสอบถามข้อมูลเพิ่มเติมที่ งานบริการการศึกษา คณะวิศวกรรมศาสตร์' : 'For further information, please contact the Educational Services Office, Faculty of Engineering' }}
            </p>
            <div class="contact-phone">
                <i class="bi bi-telephone-fill"></i>
                <span>{{ $th ? '053-944179 ต่อ 116' : '053-944179 ext. 116' }}</span>
            </div>
        </div>
    </div>
    --}}

</div>

@endsection
