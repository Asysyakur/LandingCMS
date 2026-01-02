@extends('admin.layouts')

@section('content')
<div class="container-fluid py-4 font-sans">

{{-- ROW 1: HEADER --}}
    <div class="d-flex align-items-center w-100 mb-5">
        
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded" 
                 style="width: 48px; height: 48px; background-color: #DBF2F3; color: #0076D2;">
                <i class="bi bi-display fs-4"></i>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0076D2;">Preview</h2>
        </div>
        <div class="flex-grow-1 mx-4 border-top" style="border-color: #e0e0e0;"></div>
        <x-button variant="solid" color="primary" icon-right="bi bi-cloud-upload" style="background-color: #0076D2;" data-bs-toggle="modal" data-bs-target="#publishModal">
            Publish
        </x-button>
    </div>

    {{-- ROW 2: TOOLBAR (Floating, No Card Background) --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="dropdown">
            <button class="btn btn-soft-cyan rounded-pill px-4 py-2 fw-medium d-flex align-items-center gap-2" 
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>Change Layout</span>
                <i class="bi bi-chevron-down small"></i>
            </button>
            <ul class="dropdown-menu shadow border-0 mt-2">
                <li><h6 class="dropdown-header">Select Layout</h6></li>
                <li><a class="dropdown-item active" href="#">Home Layout</a></li>
                <li><a class="dropdown-item" href="#">Campaign A</a></li>
                <li><a class="dropdown-item" href="#">Seasonal Promo</a></li>
            </ul>
        </div>

        <!-- RIGHT: View Toggles & Expand -->
        <div class="d-flex align-items-center gap-3">
            <div class="device-switch-container p-1 rounded-pill d-flex align-items-center">
                <button type="button" onclick="setDevice('desktop')" id="btn-desktop" 
                    class="btn btn-primary rounded-pill btn-sm px-3 fw-medium d-flex align-items-center gap-2 transition-all">
                    <i class="bi bi-display"></i> Desktop
                </button>
                <button type="button" onclick="setDevice('mobile')" id="btn-mobile" 
                    class="btn btn-transparent rounded-pill btn-sm px-3 fw-medium text-secondary d-flex align-items-center gap-2 transition-all">
                    Phone
                </button>
            </div>
            <button onclick="toggleFullScreen()" class="btn btn-link p-0 text-primary" title="Expand View">
                <i class="bi bi-arrows-fullscreen fs-5 fw-bold"></i>
            </button>
        </div>
    </div>

    {{-- ROW 3: PREVIEW AREA --}}
    <div class="bg-light border rounded overflow-hidden position-relative d-flex justify-content-center align-items-start" 
         id="preview-container" style="height: 750px;">
        <div id="device-frame" class="bg-white shadow-sm transition-all h-100 w-100">
            <iframe src="{{ route('home') }}" class="w-100 h-100 border-0" title="Landing Preview"></iframe>
        </div>

    </div>

</div>

{{-- STYLES --}}
@push('styles')
<style>
    /* 1. Custom Soft Cyan Button (Matches Left side of screenshot) */
    .btn-soft-cyan {
        background-color: #E0F7FA; /* Very light cyan */
        color: #0076d6;            /* Primary Blue text */
        border: none;
    }
    .btn-soft-cyan:hover {
        background-color: #B2EBF2;
        color: #005a9e;
    }

    /* 2. Switch Container (Matches Right side of screenshot) */
    .device-switch-container {
        background-color: #E9ECEF;
        min-width: 180px;
    }

    /* 3. Helper Classes */
    .btn-transparent { background-color: transparent; border: none; }
    .transition-all { transition: all 0.3s ease-in-out; }

    /* 4. Mobile Frame Logic */
    .mobile-frame {
        width: 375px !important;     
        height: 95% !important;      
        margin-top: 2.5%;            
        border-radius: 24px;         
        border: 8px solid #333;      
        overflow: hidden;            
    }

    .custom-modal-width {
        max-width: 586px;
    }

    /* 14px Label */
    .custom-label {
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 6px;
    }

    .form-control:focus {
        border-color: #0076D2;
        box-shadow: 0 0 0 0.25rem rgba(0, 118, 210, 0.25);
    }    
</style>
@endpush

{{-- SCRIPTS --}}
@push('scripts')
<script>
    function setDevice(device) {
        const frame = document.getElementById('device-frame');
        const btnDesktop = document.getElementById('btn-desktop');
        const btnMobile = document.getElementById('btn-mobile');

        if (device === 'mobile') {
            frame.classList.add('mobile-frame');
            frame.classList.remove('w-100', 'h-100');
            btnMobile.classList.add('btn-primary');
            btnMobile.classList.remove('btn-transparent', 'text-secondary');
            btnDesktop.classList.remove('btn-primary');
            btnDesktop.classList.add('btn-transparent', 'text-secondary');

        } else {
            frame.classList.remove('mobile-frame');
            frame.classList.add('w-100', 'h-100');
            btnDesktop.classList.add('btn-primary');
            btnDesktop.classList.remove('btn-transparent', 'text-secondary');

            btnMobile.classList.remove('btn-primary');
            btnMobile.classList.add('btn-transparent', 'text-secondary');
        }
    }

    function toggleFullScreen() {
        const elem = document.getElementById('preview-container');
        if (!document.fullscreenElement) {
            elem.requestFullscreen().catch(err => { alert(`Error: ${err.message}`); });
        } else {
            document.exitFullscreen();
        }
    }
</script>
@endpush

<!-- Publish Modal -->
<div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="publishModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered custom-modal-width">
        <div class="modal-content border-0 p-3">
            
            <div class="modal-header border-0 pb-0">
                <h4 class="modal-title fw-bold" id="publishModalLabel">Publish Website</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf
                    
                    {{-- 1. Website Name --}}
                    <div class="mb-3">
                        <label for="websiteName" class="form-label custom-label">Website Name</label>
                        <input type="text" class="form-control" id="websiteName" placeholder="e.g. My Awesome Landing Page" value="Official Landing Page">
                    </div>

                    {{-- 2. Last Updated --}}
                    <div class="mb-3">
                        <label for="lastUpdated" class="form-label custom-label">Last Updated</label>
                        {{-- Readonly because usually system sets this --}}
                        <input type="text" class="form-control bg-light" id="lastUpdated" value="{{ now()->format('Y-m-d H:i') }}" readonly>
                    </div>

                    {{-- 3. Version Name --}}
                    <div class="mb-3">
                        <label for="versionName" class="form-label custom-label">Version Name</label>
                        <input type="text" class="form-control" id="versionName" placeholder="e.g. v1.0.5 - Summer Campaign">
                    </div>

                    {{-- 4. Description --}}
                    <div class="mb-4">
                        <label for="description" class="form-label custom-label">Description</label>
                        <textarea class="form-control" id="description" rows="4" placeholder="Briefly describe the changes made in this version..."></textarea>
                    </div>

                    {{-- 5. Full Width Button --}}
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-medium" style="background-color: #0076D2; border-color: #0076D2;">
                        Publish Now
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection