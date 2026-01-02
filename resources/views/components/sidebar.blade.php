@php
    $currentRoute = Route::currentRouteName();

    $menus = [
        [
            'label' => 'Dashboard',
            'icon'  => 'bi-house-door', // Tanpa fill agar sesuai gambar
            'route' => 'admin.dashboard',
            'active'=> Str::contains($currentRoute, 'dashboard')
        ],
        [
            'label' => 'Manage',
            'icon'  => 'bi-database', 
            'route' => 'admin.news.index', 
            'active'=> Str::contains($currentRoute, 'news') || Str::contains($currentRoute, 'manage')
        ],
        [
            'label' => 'Preview Landing',
            'icon'  => 'bi-laptop',
            'route' => 'admin.landing.preview',
            'active'=> Str::contains($currentRoute, 'preview')
        ],
        [
            'label' => 'Content Versioning',
            'icon'  => 'bi-columns-gap', // Ikon kotak 3 baris sesuai gambar
            'route' => 'admin.versions.index',
            'active'=> Str::contains($currentRoute, 'version')
        ],
        [
            'label' => 'Business Setting',
            'icon'  => 'bi-gear',
            'route' => 'admin.settings',
            'active'=> Str::contains($currentRoute, 'settings')
        ],
    ];
@endphp

<style>
    .sidebar-container {
        width: 280px;
        background-color: #ffffff;
        border-right: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
    }

    .custom-btn {
        display: flex;
        align-items: center;
        width: 100%;
        padding: 12px 20px;
        border: none;
        font-size: 16px;
        font-weight: 500;
        color: #8a8a8a; /* Warna teks menu tidak aktif */
        background: transparent;
        text-decoration: none;
        transition: all 0.2s;
        position: relative;
    }

    /* Menu Active State */
    .custom-btn.active {
        background-color: #f1f9fc; /* Warna background biru sangat muda */
        color: #0076d6; /* Warna teks & ikon biru */
    }

    /* Garis indikator biru di sisi kanan sesuai gambar */
    .custom-btn.active::after {
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background-color: #0076d6;
    }

    .custom-btn .icon {
        margin-right: 15px;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
    }

    .custom-btn:hover:not(.active) {
        background-color: #f8f9fa;
        color: #444;
    }

    .logout-btn {
        color: #ff4d4d !important;
        margin-top: auto;
    }
</style>

<div id="sidebar" class="vh-100 sidebar-container">
    <div class="p-4 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <img src="{{ asset('assets/images/CMSLogo.svg') }}" alt="Logo" style="height: 35px;" class="me-2">
        </div>
        <button class="btn btn-sm text-secondary"><i class="bi bi-list fs-4"></i></button>
    </div>

    <ul class="nav flex-column mt-2">
        @foreach($menus as $menu)
            <li class="nav-item">
                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}" 
                   class="custom-btn {{ $menu['active'] ? 'active' : '' }}">
                    <div class="icon"><i class="bi {{ $menu['icon'] }}"></i></div>
                    <span>{{ $menu['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="mt-auto p-3 border-top">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="custom-btn logout-btn">
                <div class="icon"><i class="bi bi-box-arrow-left"></i></div>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>