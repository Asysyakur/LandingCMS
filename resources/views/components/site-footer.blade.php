<footer class="cms-footer-minimal">
    <div class="container">
        <div class="row justify-content-between gy-4">

            {{-- Brand --}}
            <div class="col-lg-4">
                <div class="footer-brand">
                    <img src="{{ asset('assets/images/CMSLogo.svg') }}" alt="Logo" class="footer-logo">
                    <p class="footer-desc">
                        The simplest way to build your landing page in minutes.
                    </p>
                </div>
            </div>

            {{-- Links --}}
            <div class="col-lg-5">
                <div class="row">

                    <div class="col-md-4">
                        <h4 class="footer-title">Features</h4>
                        <ul class="footer-links">
                            <li><a href="#">Custom Field Layout</a></li>
                            <li><a href="#">Responsive Preview</a></li>
                            <li><a href="#">Content Versioning</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h4 class="footer-title">Support & Resources</h4>
                        <ul class="footer-links">
                            <li><a href="#">How it works</a></li>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">API Documentation</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4">
                        <h4 class="footer-title">Company & Legal</h4>
                        <ul class="footer-links">
                            <li><a href="#">Terms of Service</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Cookie Policy</a></li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="footer-bottom text-center">
            © {{ now()->year }} Landing Page. All rights reserved.
        </div>
    </div>
</footer>
