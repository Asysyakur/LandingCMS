@props(['id', 'label', 'accept' => 'image/*'])

<div class="mb-4 upload-widget-wrapper" id="widget-{{ $id }}">
    <label class="form-label custom-label">{{ $label }}</label>
    
    <input type="file" id="input-{{ $id }}" class="d-none file-input" accept="{{ $accept }}">

    {{-- 1. DROP ZONE --}}
    <div class="drop-zone d-flex flex-column justify-content-center align-items-center text-center transition-all bg-white"
         style="min-height: 250px; border: 2px dashed #dee2e6; border-radius: 1rem; cursor: pointer; transition: all 0.3s ease;"
         onclick="document.getElementById('input-{{ $id }}').click()">

        <p class="fw-medium mb-1 text-dark">Drag and drop your files here.</p>
        <p class="text-muted small mb-3">or</p>
        
        <button type="button" class="btn btn-sm rounded-pill px-4 fw-bold d-flex align-items-center gap-2" 
                style="background-color: #E0F2F7; color: #0076D2; border: none;">
            <i class="bi bi-cloud-upload"></i> Browse
        </button>
    </div>

    {{-- 2. PROGRESS / PREVIEW AREA --}}
    <div class="processing-view d-none flex-column mt-3">
        <!-- Progress Bar -->
        <div class="progress-card border rounded-4 p-3 d-flex align-items-center gap-3 bg-white shadow-sm position-relative">
            <div class="rounded p-2 d-flex align-items-center justify-content-center" style="background-color: #E0F2F7; width: 48px; height: 48px;">
                <i class="bi bi-file-earmark-image text-primary fs-4"></i>
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between mb-1">
                    <small class="fw-bold text-dark filename">filename.jpg</small>
                    <small class="text-muted filesize">0 MB</small>
                </div>
                <div class="progress" style="height: 6px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%"></div>
                </div>
            </div>
            <button type="button" class="btn-close ms-2 reset-btn"></button>
        </div>

        <!-- Thumbnail -->
        <div class="thumbnail-container d-none mt-3">
            <div class="d-inline-block position-relative rounded-4 overflow-hidden border" style="width: 120px; height: 120px;">
                <img src="" class="w-100 h-100 object-fit-cover preview-img">
                <button type="button" class="position-absolute top-0 end-0 m-1 btn btn-light btn-sm rounded-circle shadow-sm p-1 reset-btn" style="width: 24px; height: 24px; line-height: 1;">
                    &times;
                </button>
            </div>
        </div>
    </div>

    {{-- Error Banner --}}
    <div class="alert alert-danger d-none mt-2 error-banner d-flex align-items-center p-2 rounded-3">
        <i class="bi bi-exclamation-circle-fill me-2"></i>
        <small class="error-text">Error message</small>
    </div>
</div>