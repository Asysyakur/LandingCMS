@extends('admin.layouts')

@section('content')
<div class="container-fluid py-4 font-sans">

    {{-- HEADER --}}
    <div class="d-flex align-items-center w-100 mb-5">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center rounded" 
                 style="width: 48px; height: 48px; background-color: #DBF2F3; color: #0076D2;">
                <i class="bi bi-gear-wide-connected fs-4"></i>
            </div>
            <h2 class="fw-bold mb-0" style="color: #0076D2;">Business Setting</h2>
        </div>
        <div class="flex-grow-1 mx-4 border-top" style="border-color: #e0e0e0;"></div>
        <div class="d-flex gap-2">
            <x-button variant="soft" color="primary" class="fw-bold">Cancel</x-button>
            <x-button variant="solid" color="primary" icon-right="bi bi-pencil-square" style="background-color: #0076D2;">Edit</x-button>
        </div>
    </div>

    {{-- ROW 2: FORM CONTENT --}}
      <form action="#">
        <div class="d-flex flex-column gap-4">
            
            {{-- 1. Business Name --}}
            <div class="col-12">
                <label for="businessName" class="form-label custom-label">Business Name</label>
                <input type="text" class="form-control form-control-lg fs-6" id="businessName" placeholder="e.g. Acme Corp">
            </div>

            {{-- 2. Tagline --}}
            <div class="col-12">
                <label for="tagline" class="form-label custom-label">Tagline</label>
                <input type="text" class="form-control form-control-lg fs-6" id="tagline" placeholder="e.g. Innovation for Future">
            </div>

            {{-- 3. Brief Description --}}
            <div class="col-12">
                <label for="description" class="form-label custom-label">Brief Description of the Business</label>
                <textarea class="form-control" id="description" rows="4" placeholder="Describe your business..."></textarea>
            </div>

            {{-- 4. Background Image (Component) --}}
            <div class="col-12">
                <x-upload-input id="bg" label="Background Image" />
            </div>

            {{-- 5. Favicon (Component) --}}
            <div class="col-12">
                <x-upload-input id="favicon" label="Favicon" accept=".ico,.png" />
            </div>

            {{-- 6. Contact Info --}}
            <div class="col-12">
                <label for="contactInfo" class="form-label custom-label">Contact Info</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone text-muted"></i></span>
                    <input type="text" class="form-control form-control-lg fs-6 border-start-0 ps-0" id="contactInfo" placeholder="+1 234 567 890">
                </div>
            </div>

            {{-- 7. Location --}}
            <div class="col-12">
                <label for="location" class="form-label custom-label">Location</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-geo-alt text-muted"></i></span>
                    <input type="text" class="form-control form-control-lg fs-6 border-start-0 ps-0" id="location" placeholder="New York, USA">
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .custom-label {
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 8px;
    }
    .form-control:focus {
        border-color: #0076D2;
        box-shadow: 0 0 0 4px rgba(0, 118, 210, 0.1);
    }

    /* --- UPLOAD WIDGET STYLES --- */
    .drop-zone:hover, .drop-zone.drag-over {
        border-color: #0076D2 !important;
        background-color: #F0F9FF !important;
        box-shadow: 0 0 0 4px rgba(0, 118, 210, 0.1); 
    }
    
    .object-fit-cover { object-fit: cover; }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.upload-widget-wrapper').forEach(wrapper => {
            initUploadWidget(wrapper);
        });
    });

    function initUploadWidget(wrapper) {
        const input = wrapper.querySelector('.file-input');
        const dropZone = wrapper.querySelector('.drop-zone');
        const processingView = wrapper.querySelector('.processing-view');
        const progressCard = wrapper.querySelector('.progress-card');
        const progressBar = wrapper.querySelector('.progress-bar');
        const thumbnailContainer = wrapper.querySelector('.thumbnail-container');
        const previewImg = wrapper.querySelector('.preview-img');
        const errorBanner = wrapper.querySelector('.error-banner');
        const errorText = wrapper.querySelector('.error-text');
        const filenameEl = wrapper.querySelector('.filename');
        const filesizeEl = wrapper.querySelector('.filesize');
        const resetBtns = wrapper.querySelectorAll('.reset-btn');

        // Drag Over - Add Class for styling
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over'); // Triggers CSS
        });

        // Drag Leave - Remove Class
        dropZone.addEventListener('dragleave', (e) => {
            dropZone.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            if (e.dataTransfer.files.length) {
                input.files = e.dataTransfer.files;
                handleFiles(input.files[0]);
            }
        });

        input.addEventListener('change', (e) => {
            if (input.files.length) handleFiles(input.files[0]);
        });

        resetBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                input.value = '';
                dropZone.classList.remove('d-none');
                processingView.classList.add('d-none');
                thumbnailContainer.classList.add('d-none');
                progressCard.classList.remove('d-none');
                errorBanner.classList.add('d-none');
            });
        });

        function handleFiles(file) {
            if (!file.type.startsWith('image/')) {
                showError("Please upload an image file.");
                return;
            }
            errorBanner.classList.add('d-none');
            dropZone.classList.add('d-none');
            processingView.classList.remove('d-none');
            progressCard.classList.remove('d-none');
            thumbnailContainer.classList.add('d-none');

            filenameEl.innerText = file.name;
            filesizeEl.innerText = (file.size / (1024*1024)).toFixed(2) + ' MB';

            let progress = 0;
            progressBar.style.width = '0%';
            
            const interval = setInterval(() => {
                progress += Math.random() * 20;
                if (progress > 100) progress = 100;
                progressBar.style.width = progress + '%';

                if (progress === 100) {
                    clearInterval(interval);
                    setTimeout(() => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            previewImg.src = e.target.result;
                            progressCard.classList.add('d-none');
                            thumbnailContainer.classList.remove('d-none');
                        };
                        reader.readAsDataURL(file);
                    }, 500);
                }
            }, 100);
        }

        function showError(msg) {
            errorText.innerText = msg;
            errorBanner.classList.remove('d-none');
        }
    }
</script>
@endpush