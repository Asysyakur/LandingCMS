@props([
    'menu' => [
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'About', 'url' => route('home') . '#about-sec'],
        ['label' => 'Legal', 'url' => route('home') . '#legal-sec'],
        ['label' => 'Values', 'url' => route('home') . '#value-sec'],
        ['label' => 'Team', 'url' => route('home') . '#team-sec'],
        ['label' => 'Products', 'url' => route('home') . '#product-sec'],
        ['label' => 'Network', 'url' => route('home') . '#network-sec'],
        ['label' => 'News & Articles', 'url' => route('news')],
        ['label' => 'Contact', 'url' => route('home') . '#contact-sec'],
    ],
    'contacts' => [
        'address' => 'Jl. Temanggung No. 27, Kec. Antapani, Kota Bandung, Jawa Barat',
        'phone_display' => '+62 xxx - xxxx - xxxx',
        'phone_raw' => '+62xxxxxxxxxxx',
        'emails' => ['moneyhub.cas@gmail.com', 'corsec@moneyhub.co.id'],
    ],
    'homeRoute' => 'home',
])

@php
    $isActive = function ($itemUrl) {
        $current = url()->current();
        $base = explode('#', $itemUrl)[0];
        return $current === $base;
    };
@endphp

{{-- MOBILE MENU WRAPPER (pindahkan ke sini agar pasti dirender sebelum init JS) --}}
<div class="th-menu-wrapper">
    <div class="th-menu-area text-center">
        <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
        <div class="mobile-logo">
            <a class="icon-masking" href="{{ route($homeRoute) }}">
                <img src="{{ asset('assets/images/logo.svg') }}" alt="MoneyHub">
            </a>
        </div>
        <div class="th-mobile-menu">
            <ul>
                @foreach ($menu as $m)
                    <li><a href="{{ $m['url'] }}">{{ $m['label'] }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<header class="th-header header-layout2">
    <div class="sticky-wrapper">
        <div class="menu-area">
            <div class="container">
                <div class="row align-items-center justify-content-between">

                    {{-- LOGO --}}
                    <div class="col-auto">
                        <div class="header-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('assets/images/CMSLogo.svg') }}" alt="CMS Logo">
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT ACTIONS --}}
                    <div class="col-auto">
                        <div class="header-right">

                            {{-- Language --}}
                            <div class="header-links language-dropdown d-none d-md-inline-block">
                                <ul class="nav">
                                    <li class="nav-item dropdown">
                                        <a href="#" class="nav-link dropdown-toggle" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            English
                                            {{-- <i class="far fa-chevron-down"></i> --}}
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="langDropdown">
                                            <li><a class="dropdown-item" href="?lang=en">English</a></li>
                                            <li><a class="dropdown-item" href="?lang=id">Bahasa Indonesia</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            {{-- Sign Up --}}
                            <a href="#" class="th-btn style4 ms-3">
                                Sign Up
                            </a>

                            {{-- Log In --}}
                            <a href="#" class="th-btn ms-2">
                                Log In <i class="fas fa-arrow-right ms-1"></i>
                            </a>

                            {{-- Mobile Menu Toggle --}}
                            <button type="button" class="th-menu-toggle d-inline-block d-lg-none ms-2">
                                <i class="far fa-bars"></i>
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
