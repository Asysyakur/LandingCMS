<x-layout>
    <section class="cms-hero space-top">
        <div class="container">
            <div class="cms-hero-box">
                <div class="row align-items-center">

                    <!-- LEFT ILLUSTRATION -->
                    <div class="col-lg-5 mb-30 mb-lg-0">
                        <div class="cms-hero-illustration">
                            <img src="{{ asset('assets/images/hero-cms.svg') }}" alt="CMS Illustration">
                        </div>
                    </div>

                    <!-- RIGHT CONTENT -->
                    <div class="col-lg-7">
                        <div class="cms-hero-content">
                            <h1 class="cms-hero-title">
                                Build Your Landing Page in Minutes
                            </h1>

                            <p class="cms-hero-text">
                                No hassle, no coding, fill in your content, and your website is ready
                                to go live on your subdomain or custom domain.
                            </p>

                            <a href="#" class="th-btn style4">
                                Get Started <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="cms-features space">
        <div class="container">

            <!-- Title -->
            <div class="title-area text-start mb-50">
                <h2 class="sec-title">Features</h2>
                <p class="sec-text">
                    Powerful Features to Build Your Landing Page
                </p>
            </div>

            <!-- Feature Cards -->
            <div class="row gy-30">

                <div class="col-lg-4 col-md-6">
                    <div class="cms-feature-card text-start">
                        <div class="cms-feature-icon">
                            <img src="/assets/images/icon-landing/custom-field.svg" alt="">
                        </div>
                        <h3 class="cms-feature-title">Custom Field Layout</h3>
                        <p class="cms-feature-text">
                            Easily build your landing page by adding, editing, and rearranging sections no coding
                            required.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cms-feature-card text-start">
                        <div class="cms-feature-icon">
                            <img src="/assets/images/icon-landing/responsive-preview.svg" alt="">
                        </div>
                        <h3 class="cms-feature-title">Responsive Preview</h3>
                        <p class="cms-feature-text">
                            See exactly how your page looks on desktop, tablet, and mobile before publishing.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="cms-feature-card text-start">
                        <div class="cms-feature-icon">
                            <img src="/assets/images/icon-landing/responsive-preview.svg" alt="">
                        </div>
                        <h3 class="cms-feature-title">Content Versioning</h3>
                        <p class="cms-feature-text">
                            Track every change, compare versions, and restore previous content anytime.
                        </p>
                    </div>
                </div>

            </div>

            <!-- CTA -->
            <div class="text-center mt-50">
                <a href="#" class="th-btn cms-feature-cta">
                    Get Started <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>

        </div>
    </section>

    @push('scripts')
        <script>
            var map = L.map('map').setView([-2.5489, 118.0149], 4);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 14,
                minZoom: 3
            }).addTo(map);

            const locations = [{
                    city: "Banda Aceh",
                    coords: [5.5560, 95.3222]
                },
                {
                    city: "Medan",
                    coords: [3.5952, 98.6722]
                },
                {
                    city: "Palembang",
                    coords: [-2.9761, 104.7754]
                },
                {
                    city: "Banten",
                    coords: [-6.4230, 106.1205]
                },
                {
                    city: "DKI Jakarta",
                    coords: [-6.2088, 106.8456]
                },
                {
                    city: "Bandung",
                    coords: [-6.9175, 107.6191]
                },
                {
                    city: "Semarang",
                    coords: [-6.9667, 110.4281]
                },
                {
                    city: "Solo",
                    coords: [-7.5561, 110.8318]
                },
                {
                    city: "Mataram",
                    coords: [-8.5833, 116.1167]
                },
                {
                    city: "Kupang",
                    coords: [-10.1771, 123.6070]
                },
                {
                    city: "Makassar",
                    coords: [-5.1477, 119.4238]
                },
                {
                    city: "Palu",
                    coords: [-0.8988, 119.8708]
                },
                {
                    city: "Gorontalo",
                    coords: [0.5403, 123.0626]
                }
            ];

            locations.forEach(location => {
                L.marker(location.coords)
                    .addTo(map)
            });
        </script>
    @endpush
</x-layout>
