<style>
    footer {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
        color: rgba(255, 255, 255, 0.88);
        padding: 36px 0;
        margin-top: 72px;
        font-size: 0.92rem;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #4f46e5 0%, #8b5cf6 35%, #ec4899 70%, #06b6d4 100%);
    }

    footer a {
        color: #a5b4fc;
        text-decoration: none;
    }

    footer a:hover {
        color: #f472b6;
        text-decoration: underline;
    }

    .footer-bottom {
        text-align: center;
    }

    .footer-bottom p {
        margin: 0;
        font-weight: 500;
        letter-spacing: 0.02em;
    }
</style>

<footer>
    {{-- <div class="container"> --}}
        {{-- <div class="footer-content">
            <!-- Left Section: Contact Info -->
            <div class="footer-section">
                <h6>{{ app()->getLocale() === 'th' ? 'ติดต่อเรา' : 'Contact Us' }}</h6>
                <p>
                    <strong>{{ app()->getLocale() === 'th' ? 'คณะวิศวกรรมศาสตร์' : 'Faculty of Engineering' }}</strong><br>
                    {{ __('site.footer_address') }}<br><br>
                    <i class="bi bi-telephone-fill"></i> {{ __('site.footer_phone') }}
                </p>
            </div>

            <!-- Right Section: Quick Links -->
            <div class="footer-section">
                <h6>{{ __('site.footer_quick_links') }}</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('programs.index') }}">{{ __('site.footer_link_programs') }}</a></li>
                    <li><a href="{{ route('scholarships.index') }}">{{ __('site.footer_link_scholarships') }}</a></li>
                    <li><a href="{{ route('research.index') }}">{{ __('site.footer_link_research') }}</a></li>
                </ul>
            </div>
        </div> --}}

        <!-- Bottom Copyright -->
        <div class="footer-bottom">
            <p>
                {{ __('site.footer_copyright') }}
            </p>
        </div>
    {{-- </div> --}}
</footer>
